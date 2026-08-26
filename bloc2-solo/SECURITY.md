# Politique de sécurité — CESIZen

## Signaler une vulnérabilité

Nous prenons la sécurité au sérieux. **Merci de ne pas divulguer publiquement**
une faille (pas d'issue GitHub publique).

- Contact : `security@cesizen.example`
- Ou via l'avis de sécurité privé GitHub (*Security > Advisories*).

Merci d'inclure : description, étapes de reproduction, impact estimé et, si
possible, une proposition de correction.

### Engagement de traitement

| Étape | Délai cible |
|-------|-------------|
| Accusé de réception | 48 h |
| Qualification / criticité | 5 jours ouvrés |
| Correctif (faille critique) | 15 jours |
| Communication au déclarant | à chaque étape |

## Versions supportées

Seule la dernière version en production reçoit les correctifs de sécurité.

## Bonnes pratiques appliquées

- Mots de passe hachés (bcrypt), jamais stockés en clair.
- Protection CSRF native Laravel sur les formulaires.
- Requêtes préparées via Eloquent/PDO (anti-injection SQL).
- Échappement Blade par défaut (anti-XSS).
- En-têtes de sécurité HTTP (`SecurityHeaders` middleware).
- Contrôle d'accès par rôle (`admin`, `role` middlewares).
- Secrets hors du dépôt (`.env` ignoré par Git, secrets CI/CD chiffrés).
- Dépendances surveillées par Dependabot.
