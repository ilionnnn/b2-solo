# Plan de sécurisation — CESIZen

## 1. Périmètre et méthode

Ce plan couvre la sécurité de l'application CESIZen et des données qu'elle
traite. L'analyse s'appuie sur le **Top 10 OWASP** et une cotation de la
**criticité** de chaque risque :

```
Criticité = Probabilité (1 à 4) × Impact (1 à 4)
```

| Niveau | Plage de criticité |
|--------|--------------------|
| 🟢 Faible | 1 – 3 |
| 🟡 Moyen | 4 – 7 |
| 🟠 Élevé | 8 – 11 |
| 🔴 Critique | 12 – 16 |

## 2. Analyse des vulnérabilités et des risques

| # | Vulnérabilité / risque | Réf. OWASP | Prob. | Impact | Criticité | Niveau |
|---|------------------------|-----------|:-----:|:------:|:---------:|--------|
| R1 | Injection SQL | A03 | 2 | 4 | 8 | 🟠 Élevé |
| R2 | XSS (injection de scripts) | A03 | 3 | 3 | 9 | 🟠 Élevé |
| R3 | Vol de session / CSRF | A01/A07 | 2 | 4 | 8 | 🟠 Élevé |
| R4 | Accès non autorisé (élévation de privilèges) | A01 | 3 | 4 | 12 | 🔴 Critique |
| R5 | Mots de passe faibles / fuite d'identifiants | A07 | 3 | 4 | 12 | 🔴 Critique |
| R6 | Exposition de données sensibles (santé) | A02 | 2 | 4 | 8 | 🟠 Élevé |
| R7 | Dépendances vulnérables | A06 | 3 | 3 | 9 | 🟠 Élevé |
| R8 | Mauvaise configuration (debug, secrets exposés) | A05 | 3 | 4 | 12 | 🔴 Critique |
| R9 | Absence de journalisation / détection | A09 | 3 | 2 | 6 | 🟡 Moyen |
| R10 | Déni de service / brute force login | A07 | 2 | 3 | 6 | 🟡 Moyen |

## 3. Actions correctives et préventives

Priorité donnée aux risques **critiques et élevés** (couverture > 75 %).

| # | Actions correctives et préventives | Statut |
|---|-------------------------------------|--------|
| R1 | ORM Eloquent + requêtes préparées (PDO), validation des entrées (`FormRequest`) | ✅ En place |
| R2 | Échappement Blade `{{ }}` par défaut, en-tête `X-Content-Type-Options`, CSP à renforcer | ✅ / 🔶 |
| R3 | Jetons CSRF Laravel, cookies `HttpOnly`/`SameSite`, régénération de session au login | ✅ En place |
| R4 | Middlewares `admin` et `role` (contrôle d'accès serveur sur chaque route protégée) | ✅ En place |
| R5 | Hachage bcrypt, règles de complexité (`Password::defaults()`), consentement à l'inscription | ✅ En place |
| R6 | Chiffrement en transit (TLS), champs sensibles minimisés, HSTS en production | ✅ / 🔶 |
| R7 | Dependabot (MàJ hebdo + alertes), `composer audit` en CI | ✅ En place |
| R8 | `APP_DEBUG=false` en prod, secrets via variables d'environnement, `.env` hors dépôt | ✅ En place |
| R9 | Journalisation Laravel (`stack`), traçabilité des actions d'administration | 🔶 À renforcer |
| R10 | Limitation de débit (`throttle`) sur login/formulaires sensibles | 🔶 Recommandé |

**Légende** : ✅ mis en œuvre · 🔶 recommandé / à renforcer.

### Mesures transverses appliquées dans le code

- `app/Http/Middleware/SecurityHeaders.php` : en-têtes `X-Frame-Options`,
  `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, HSTS.
- Configuration Nginx (`docker/nginx.conf`) : blocage de l'accès à `.env`,
  `.log`, `.sqlite` et fichiers cachés.

## 4. Solutions de chiffrement et cryptage

| Donnée | Mécanisme |
|--------|-----------|
| Mots de passe | Hachage **bcrypt** (`BCRYPT_ROUNDS=12`), non réversible |
| Sessions & cookies | Chiffrés par `APP_KEY` (AES-256-CBC), `HttpOnly`, `SameSite` |
| Transit réseau | **HTTPS/TLS** obligatoire en production + HSTS |
| Secrets applicatifs | Variables d'environnement, secrets CI/CD chiffrés |
| Données au repos | Chiffrement disque / base fourni par l'hébergeur |

## 5. Données personnelles et conformité RGPD

### 5.1 Cartographie des données

| Donnée | Catégorie | Sensibilité |
|--------|-----------|-------------|
| Nom, e-mail | Identité | Standard |
| Mot de passe (haché) | Authentification | Élevée |
| Tracker d'émotions | **Donnée de santé** | Très élevée |
| Journaux de connexion | Technique | Standard |

### 5.2 Mesures de conformité

- **Base légale** : consentement recueilli à l'inscription
  (champ `consent_rgpd` du modèle `User`).
- **Minimisation** : seules les données nécessaires sont collectées.
- **Droits des personnes** : accès, rectification et **effacement** possibles
  depuis le profil (« Supprimer mon compte » → `ProfileController@destroy`).
- **Transparence** : page *Politique de confidentialité* (`/confidentialite`),
  *Mentions légales*, *CGU*.
- **Durée de conservation** : suppression/anonymisation après inactivité.
- **Localisation** : hébergement dans l'Union européenne.
- **Sécurité** : chiffrement, contrôle d'accès, journalisation (cf. §3-4).

## 6. Gestion de crise en cas d'attaque ou d'incident de sécurité

### 6.1 Processus d'escalade

```
Détection (alerte, log, signalement security@)
   → Qualification de la gravité (équipe technique)
   → Confinement (isolation, révocation de secrets, mode maintenance)
   → Éradication + correction
   → Restauration depuis sauvegarde saine
   → Retour d'expérience (post-mortem)
```

### 6.2 Rôles et responsabilités

| Rôle | Responsabilité en crise |
|------|-------------------------|
| Responsable technique | Pilote la réponse, décide du confinement |
| Développeur | Analyse, corrige, déploie le correctif |
| DPO | Évalue l'atteinte aux données personnelles |
| Direction | Décisions, communication externe |

### 6.3 Communication et obligations légales

- **Notification CNIL sous 72 h** en cas de violation de données personnelles
  (art. 33 RGPD), et information des personnes concernées si risque élevé
  (art. 34).
- Canal de signalement dédié : `security@cesizen.example` (cf. `SECURITY.md`).
- Communication interne (équipe) puis externe (utilisateurs) maîtrisée et
  factuelle, coordonnée par la direction.

### 6.4 Mesures préventives permanentes

- Sauvegardes régulières et testées (restaurabilité vérifiée).
- Surveillance des dépendances (Dependabot) et des logs.
- Tests de sécurité intégrés (`composer audit` en CI, revue de code).
- Principe du moindre privilège sur les accès (rôles applicatifs et infra).
