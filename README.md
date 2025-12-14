# Application de Gestion de Bibliothèque en Ligne - Laravel

Application web complète de gestion de bibliothèque développée avec Laravel 12, permettant aux utilisateurs de consulter, réserver des livres et aux administrateurs de gérer l'ensemble du système.

## Fonctionnalités

### Pour les Utilisateurs
- ✅ Inscription et connexion
- ✅ Consultation du catalogue de livres
- ✅ Recherche de livres par titre ou auteur
- ✅ Filtrage des livres par catégorie
- ✅ Réservation d'un livre (un seul à la fois)
- ✅ Consultation de ses réservations
- ✅ Annulation de ses réservations en attente
- ✅ Gestion du profil utilisateur

### Pour les Administrateurs
- ✅ Dashboard avec statistiques
- ✅ Gestion complète des livres (CRUD)
- ✅ Gestion des utilisateurs (CRUD)
- ✅ Gestion des réservations
- ✅ Validation/Annulation des réservations

## Technologies Utilisées

- **Laravel 12**
- **MySQL** (base de données)
- **Bootstrap 5** (interface utilisateur)
- **Eloquent ORM**
- **Blade** (templates)

## Installation

### Prérequis
- PHP >= 8.2
- Composer
- MySQL
- Node.js et npm (optionnel)

### Étapes d'installation

1. **Cloner le projet** (si nécessaire)
```bash
cd project_laravel_rania-faouzi
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**

Modifiez le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bibliotheque
DB_USERNAME=root
DB_PASSWORD=
```

Créez la base de données MySQL :
```sql
CREATE DATABASE bibliotheque;
```

5. **Exécuter les migrations et seeders**
```bash
php artisan migrate
php artisan db:seed
```

6. **Démarrer le serveur**
```bash
php artisan serve
```

L'application sera accessible à l'adresse : `http://localhost:8000`

## Comptes par défaut

Après l'exécution des seeders, vous pouvez vous connecter avec :

### Administrateur
- **Email:** admin@bibliotheque.com
- **Mot de passe:** password

### Utilisateurs
- **Email:** jean.dupont@example.com
- **Mot de passe:** password

- **Email:** marie.martin@example.com
- **Mot de passe:** password

## Structure du Projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   └── UserController.php
│   │   ├── Auth/
│   │   │   └── RegisterController.php
│   │   ├── LivreController.php
│   │   └── ReservationController.php
│   └── Middleware/
│       └── EnsureUserIsAdmin.php
├── Models/
│   ├── CategorieLivre.php
│   ├── Livre.php
│   ├── Reservation.php
│   └── User.php
└── Policies/
    └── ReservationPolicy.php

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2025_12_12_175519_add_role_to_users_table.php
│   ├── 2025_12_12_175533_create_categorie_livres_table.php
│   ├── 2025_12_12_175541_create_livres_table.php
│   └── 2025_12_12_175555_create_reservations_table.php
└── seeders/
    ├── CategorieLivreSeeder.php
    ├── LivreSeeder.php
    ├── UserSeeder.php
    └── DatabaseSeeder.php

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── livres/
    │   ├── index.blade.php
    │   ├── show.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── reservations/
    │   ├── index.blade.php
    │   └── show.blade.php
    ├── admin/
    │   ├── dashboard.blade.php
    │   └── users/
    │       ├── index.blade.php
    │       ├── create.blade.php
    │       ├── edit.blade.php
    │       └── show.blade.php
    └── profile.blade.php
```

## Routes Principales

- `/` - Page d'accueil (redirige vers la liste des livres)
- `/livres` - Liste des livres
- `/livres/{id}` - Détails d'un livre
- `/register` - Inscription
- `/login` - Connexion
- `/profile` - Profil utilisateur
- `/reservations` - Liste des réservations
- `/admin/dashboard` - Dashboard administrateur
- `/admin/users` - Gestion des utilisateurs
- `/admin/livres` - Gestion des livres (admin)

## Fonctionnalités Techniques

### Authentification
- Système d'authentification personnalisé
- Deux rôles : `user` et `admin`
- Middleware pour protéger les routes admin

### Réservations
- Un utilisateur ne peut réserver qu'un seul livre à la fois
- États des réservations : `en_attente`, `validee`, `annulee`
- Validation/annulation par l'administrateur

### Recherche et Filtrage
- Recherche par titre ou auteur
- Filtrage par catégorie
- Pagination des résultats

## Commandes Utiles

```bash
# Créer une migration
php artisan make:migration nom_migration

# Créer un modèle avec migration
php artisan make:model NomModel -m

# Créer un contrôleur
php artisan make:controller NomController

# Exécuter les migrations
php artisan migrate

# Exécuter les seeders
php artisan db:seed

# Vider et réinitialiser la base de données
php artisan migrate:fresh --seed

# Démarrer le serveur
php artisan serve
```

## Auteur

Développé dans le cadre d'un mini-projet Laravel.

## Licence

Ce projet est un projet éducatif.
