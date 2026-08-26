# Veille technologique — CESIZen

## 1. Objectif

Assurer la **pérennité** et la **sécurité** de l'application en suivant
l'évolution des technologies utilisées (Laravel, PHP, dépendances, sécurité) et
en anticipant les migrations nécessaires.

## 2. Périmètre surveillé

| Domaine | Éléments suivis |
|---------|-----------------|
| Framework | Versions et cycle de vie de Laravel, PHP |
| Sécurité | Avis CVE, OWASP, alertes des dépendances |
| Dépendances | Paquets Composer et npm du projet |
| Écosystème | Bonnes pratiques, outillage (Pint, tests) |

## 3. Sources de veille

- **Officielles** : blog Laravel, notes de version PHP, `laravel-news.com`.
- **Sécurité** : bulletins CNIL/ANSSI, base CVE, GitHub Security Advisories.
- **Communauté** : Laracasts, dépôts GitHub, newsletters spécialisées.

## 4. Outils automatisés mis en place

| Outil | Rôle | Fréquence |
|-------|------|-----------|
| **Dependabot** (`.github/dependabot.yml`) | PR de mise à jour + alertes de vulnérabilité | Hebdomadaire |
| **`composer audit`** (CI) | Détection de dépendances PHP vulnérables | À chaque push |
| **CI GitHub Actions** | Vérifie qu'une MàJ ne casse rien (tests, style) | À chaque push/PR |

Ce couplage rend la veille **actionnable** : une vulnérabilité connue génère
automatiquement une PR, testée par la CI avant intégration.

## 5. Méthodologie

```
Collecte (sources + outils automatisés)
   → Analyse d'impact (criticité, effort, compatibilité)
   → Priorisation (issue dédiée si action requise)
   → Application via PR + CI + recette préproduction
   → Documentation (CHANGELOG, docs/)
```

- **Rythme** : revue hebdomadaire des PR Dependabot, revue mensuelle des versions
  majeures et de la roadmap technologique.
- **Critères de décision** : criticité sécurité, fin de support (EOL), gain
  fonctionnel/performance, coût de migration.

## 6. Gestion de l'obsolescence

- Suivi des dates de fin de support de PHP et Laravel (planification des montées
  de version **avant** l'EOL).
- Migrations majeures traitées comme des évolutions (branche dédiée, tests,
  recette) et non en urgence.
