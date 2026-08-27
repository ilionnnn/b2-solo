# Plan de maintenance — CESIZen

## 1. Objectifs

Garantir la **correction des anomalies**, la **prise en compte des évolutions**
et la **pérennité technologique** de l'application, avec une méthodologie
outillée et traçable entre le prestataire et le client.

## 2. Outil de gestion des demandes (ticketing)

L'outil retenu est **GitHub Issues + Projects**, intégré au dépôt de code (donc
au versioning et à la CI/CD), ce qui évite la dispersion des outils.

### 2.1 Configuration (dossier `.github/`)

- **Gabarits d'issue** (`.github/ISSUE_TEMPLATE/`) :
  - `bug_report.yml` — anomalie, avec champ **criticité** (bloquant → cosmétique)
    et étapes de reproduction.
  - `feature_request.yml` — évolution, avec **priorité** et critères d'acceptation.
  - `config.yml` — redirige les failles de sécurité vers un canal privé et le
    support utilisateur vers la page dédiée.
- **Gabarit de pull request** (`.github/PULL_REQUEST_TEMPLATE.md`) : checklist
  qualité (style, tests, pas de secret, doc à jour).
- **Labels** : `bug`, `évolution`, `sécurité`, criticité/priorité, `à trier`.

### 2.2 Tableau de suivi (GitHub Projects)

Colonnes : `À trier` → `Backlog priorisé` → `En cours` → `En revue` →
`En recette (préprod)` → `Terminé`.

## 3. Méthodologie de traitement

### 3.1 Cycle de vie d'un ticket

```
Signalement (client/utilisateur/veille)
   → Qualification (type, criticité, priorité)
   → Priorisation (backlog)
   → Développement sur branche dédiée (feat/* ou fix/*)
   → Pull request + revue + CI verte
   → Recette en préproduction
   → Validation client
   → Mise en production
   → Clôture + communication au demandeur
```

### 3.2 SLA indicatifs (correction d'anomalie)

| Criticité | Prise en compte | Résolution cible |
|-----------|-----------------|------------------|
| Bloquant | 4 h | 24 h |
| Majeur | 1 jour ouvré | 5 jours ouvrés |
| Mineur | 3 jours ouvrés | Prochaine version planifiée |
| Cosmétique | Backlog | Selon disponibilité |

### 3.3 Gestion des évolutions

Regroupées en **versions** (SemVer : `MAJEUR.MINEUR.CORRECTIF`), avec notes de
version (`CHANGELOG`) et livraison via la CI/CD. Toute évolution passe par une
issue, une PR revue et une recette client en préproduction.

## 4. Rôles et responsabilités

| Acteur | Responsabilité |
|--------|----------------|
| Utilisateur / client | Signale via support ou issue |
| Prestataire (dév) | Qualifie, corrige, teste, documente |
| Relecteur (PR) | Vérifie qualité et non-régression |
| Client | Valide la recette avant mise en production |

## 5. Bonnes pratiques de développement (pérennité)

- Style de code homogène et automatisé (**Laravel Pint**, `pint.json`).
- Tests automatisés exécutés en CI à chaque changement.
- Revue de code obligatoire via pull request.
- Documentation versionnée (`docs/`, `README.md`).
- Séparation des environnements et secrets hors du dépôt.

## 6. Veille et surveillance des dépendances

- **Dependabot** (`.github/dependabot.yml`) : PR hebdomadaires de mise à jour
  (Composer, npm, GitHub Actions) et alertes de sécurité.
- La méthodologie de veille technologique complète est décrite dans
  [`04-veille-technologique.md`](04-veille-technologique.md).