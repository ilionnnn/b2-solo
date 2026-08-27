# Mise en place de l'environnement de préproduction (VM Debian)

Ce runbook transforme une VM Debian (VirtualBox, adaptateur **bridged**) en
environnement de préproduction déployant CESIZen via Docker, avec un pipeline
CI/CD basé sur un **runner self-hosted**.

> Contexte : la VM `cesizen-preprod` est en réseau *bridged* → elle a une IP sur
> le réseau local et est joignable en SSH depuis l'hôte. Comme elle est sur le
> réseau d'entreprise, les builds Docker utilisent le contournement DNS
> (`--network=host` + images Debian) déjà intégré à `deploy.sh`.

---

## Phase 1 — Réseau et accès SSH

**Sur la VM (console)** : récupérer l'IP et activer SSH.

```bash
ip a | grep 'inet '                     # noter l'IP (ex. 192.168.x.y)
sudo apt update && sudo apt install -y openssh-server
sudo systemctl enable --now ssh
```

**Depuis l'hôte** : se connecter (remplacer user/IP).

```bash
ssh <user>@<ip-de-la-vm>
```

> Si le bridge est bloqué par le réseau d'entreprise, repasser l'adaptateur en
> NAT + redirection de port :
> `VBoxManage controlvm cesizen-preprod natpf1 "ssh,tcp,,2222,,22"`
> puis `ssh -p 2222 <user>@127.0.0.1`.

## Phase 2 — Installer Docker sur la VM

```bash
sudo apt update
sudo apt install -y ca-certificates curl git
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg | sudo tee /etc/apt/keyrings/docker.asc >/dev/null
sudo chmod a+r /etc/apt/keyrings/docker.asc
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/debian $(. /etc/os-release && echo $VERSION_CODENAME) stable" | sudo tee /etc/apt/sources.list.d/docker.list >/dev/null
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Autoriser l'utilisateur à piloter Docker sans sudo
sudo usermod -aG docker "$USER"
newgrp docker                           # ou se déconnecter/reconnecter
docker run --rm hello-world             # test
```

## Phase 3 — Récupérer le code

```bash
git clone <url-du-depot> ~/cesizen
cd ~/cesizen/bloc2-solo
cp .env.example .env                    # renseigner APP_KEY, APP_URL, MAIL_*
php -r "echo 'APP_KEY=base64:'.base64_encode(random_bytes(32));" 2>/dev/null || true
```

> `APP_URL` doit pointer sur l'IP/nom de la VM, ex. `http://192.168.x.y:8080`.
> Les identifiants MySQL de la préprod sont fixés dans `docker-compose.yml`
> (`cesizen`/`secret`) — à remplacer par des secrets pour une vraie prod.

## Phase 4 — Premier déploiement manuel (validation)

```bash
cd ~/cesizen/bloc2-solo
./deploy.sh
```

Le script construit l'image (contournement DNS inclus), démarre la stack, et
l'`entrypoint` applique automatiquement migrations + caches. Vérifier :

```bash
curl -s -o /dev/null -w "%{http_code}\n" http://localhost:8080/up   # attendu : 200
```

Depuis l'hôte : ouvrir `http://<ip-de-la-vm>:8080`.

## Phase 5 — CI/CD automatisé (runner self-hosted)

Objectif : un `git push` sur la branche `preprod` déclenche automatiquement le
déploiement sur la VM.

### 5.1 Installer le runner (sur la VM)

Dans GitHub : **Settings → Actions → Runners → New self-hosted runner**
(OS Linux x64). Suivre les commandes fournies, en ajoutant le **label `preprod`**
à la question des labels :

```bash
mkdir -p ~/actions-runner && cd ~/actions-runner
curl -o runner.tar.gz -L <url-fournie-par-github>
tar xzf runner.tar.gz
./config.sh --url https://github.com/<org>/<repo> --token <token-fourni> --labels preprod
```

### 5.2 Lancer le runner en service

```bash
sudo ./svc.sh install
sudo ./svc.sh start
sudo ./svc.sh status
```

### 5.3 Déclenchement

Le workflow `.github/workflows/deploy.yml` cible `runs-on: [self-hosted, preprod]`
et exécute `deploy.sh`. Désormais :

- `git push origin preprod` → build + redéploiement automatiques sur la VM ;
- ou onglet **Actions → Deploy → Run workflow** (déclenchement manuel).

> Le runner exécute Docker : son utilisateur doit être dans le groupe `docker`
> (cf. Phase 2).

## Démo quotidienne (environnement déjà installé)

Pas d'installation ni de rebuild — juste le lancement :

```bash
# 1. Démarrer la VM cesizen-preprod dans VirtualBox
# 2. Récupérer l'IP (le hotspot/DHCP peut la changer)
ip a | grep 'inet ' | grep -v 127.0.0.1
# 3. Se connecter et démarrer la stack
ssh vboxuser@172.20.10.4
cd ~/cesizen/bloc2-solo
docker compose up -d          # rapide : image déjà construite
# 4. Vérifier
curl -s -o /dev/null -w "%{http_code}\n" http://localhost:8080/up   # 200 = OK
# 5. Démo dans le navigateur du PC : http://<ip-de-la-vm>:8080
```

> Avec `restart: unless-stopped` + `sudo systemctl enable docker` (une fois), les
> conteneurs redémarrent automatiquement au boot de la VM : le site est déjà en
> ligne sans commande. `./deploy.sh` n'est nécessaire qu'après un changement de code.

## Mise à jour d'une version

- **Automatique** : merger/pusher sur `preprod`.
- **Manuelle** : sur la VM, `cd ~/cesizen && git pull && ./bloc2-solo/deploy.sh`.

## Dépannage

| Symptôme | Cause probable | Solution |
|----------|----------------|----------|
| Build échoue « DNS: transient error » | Réseau d'entreprise + musl | Déjà géré par `deploy.sh` (`--network=host` + Debian) |
| `permission denied` sur `docker` | Utilisateur hors groupe docker | `sudo usermod -aG docker $USER` puis reconnexion |
| Page 404 partout | Volume `app-code` désynchronisé | `docker compose down && docker volume rm cesizen_app-code && ./deploy.sh` |
| App injoignable depuis l'hôte | Pare-feu VM | `sudo ufw allow 8080/tcp` (si ufw actif) |
