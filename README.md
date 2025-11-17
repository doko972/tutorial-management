# 📚 HR Télécoms - Plateforme de Gestion de Tutoriels

Application Laravel moderne de gestion de tutoriels multi-branches pour HR Télécoms.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## ✨ Fonctionnalités

- 🎨 **Interface moderne** avec animations Lottie
- 🔐 **Authentification complète** (Login, Register, Reset Password, Email Verification)
- 📚 **Gestion des tutoriels** (CRUD complet avec upload de fichiers)
- 🎥 **Solution hybride vidéos** (Upload local OU liens YouTube/Vimeo)
- 🏷️ **Système de tags** et catégorisation
- 🔍 **Recherche avancée** avec filtres multiples
- 🔔 **Notifications en temps réel**
- 👥 **Gestion des utilisateurs** avec 3 rôles (User, Manager, Admin)
- 🏢 **4 branches** (Administratif, Comptabilité, Technique, Commercial)
- 🔒 **Système de permissions** avec Policies
- 📄 **Pagination personnalisée**
- 📱 **Design 100% responsive**
- 🎬 **Page 404 personnalisée** avec animation

## 🗂️ Structure du projet
```
hr-telecoms-tutorials/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── BranchController.php
│   │   │   │   └── UserController.php
│   │   │   ├── MyTutorialController.php
│   │   │   ├── TutorialController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Tutorial.php
│   │   ├── Branch.php
│   │   ├── Tag.php
│   │   └── TutorialView.php
│   ├── Notifications/
│   │   └── TutorialPublished.php
│   ├── Policies/
│   │   ├── TutorialPolicy.php
│   │   ├── UserPolicy.php
│   │   └── BranchPolicy.php
│   ├── Services/
│   │   └── FileUploadService.php
│   └── View/
│       └── Components/
│           └── LottieAnimation.php
├── database/
│   ├── migrations/
│   │   ├── 2024_XX_XX_create_branches_table.php
│   │   ├── 2024_XX_XX_create_tutorials_table.php
│   │   ├── 2024_XX_XX_create_tags_table.php
│   │   ├── 2024_XX_XX_create_tutorial_tag_table.php
│   │   └── 2024_XX_XX_create_tutorial_views_table.php
│   └── seeders/
│       ├── BranchSeeder.php
│       ├── TagSeeder.php
│       ├── UserSeeder.php
│       └── TutorialSeeder.php
├── public/
│   ├── animations/
│   │   ├── 404.json
│   │   ├── empty.json
│   │   ├── no-results.json
│   │   ├── no-notifications.json
│   │   └── success.json
│   └── storage/
│       ├── tutorials/
│       └── thumbnails/
├── resources/
│   ├── sass/
│   │   ├── app.scss
│   │   ├── _variables.scss
│   │   ├── _mixins.scss
│   │   ├── auth.scss
│   │   ├── dashboard.scss
│   │   ├── components.scss
│   │   ├── cards.scss
│   │   └── home.scss
│   ├── views/
│   │   ├── admin/
│   │   │   ├── branches/
│   │   │   └── users/
│   │   ├── auth/
│   │   ├── components/
│   │   │   └── lottie-animation.blade.php
│   │   ├── errors/
│   │   │   └── 404.blade.php
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── app-dashboard.blade.php
│   │   │   ├── guest.blade.php
│   │   │   └── partials/
│   │   │       ├── navbar.blade.php
│   │   │       └── sidebar.blade.php
│   │   ├── my-tutorials/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── tutorials/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   ├── dashboard.blade.php
│   │   └── home.blade.php
│   └── js/
│       └── app.js
├── routes/
│   ├── web.php
│   └── auth.php
├── .env.example
├── composer.json
├── package.json
└── README.md
```

## 📋 Prérequis

- PHP >= 8.2
- Composer
- Node.js >= 18.x & NPM
- MySQL >= 8.0
- Serveur web (Apache/Nginx) ou Laravel Valet

## 🚀 Installation

### 1. Cloner le repository
```bash
git clone https://github.com/ton-username/hr-telecoms-tutorials.git
cd hr-telecoms-tutorials
```

### 2. Installer les dépendances PHP
```bash
composer install
```

### 3. Installer les dépendances Node.js
```bash
npm install
npm install sass --save-dev
```

### 4. Configuration de l'environnement
```bash
# Copier le fichier .env
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 5. Configurer la base de données

Éditer le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_telecoms_tutorials
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 6. Créer la base de données
```bash
mysql -u root -p
CREATE DATABASE hr_telecoms_tutorials CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 7. Exécuter les migrations et seeders
```bash
# Migrations
php artisan migrate

# Seeders (données de base)
php artisan db:seed --class=BranchSeeder
php artisan db:seed --class=TagSeeder
php artisan db:seed --class=UserSeeder

# (Optionnel) Tutoriels de démonstration
php artisan db:seed --class=TutorialSeeder
```

### 8. Créer le lien symbolique pour le storage
```bash
php artisan storage:link
```

### 9. Compiler les assets
```bash
# Développement
npm run dev

# Production
npm run build
```

### 10. Démarrer le serveur
```bash
php artisan serve
```

L'application sera accessible sur : `http://127.0.0.1:8000`

## 👥 Comptes de test

Après avoir exécuté le `UserSeeder`, vous pouvez vous connecter avec :

### Administrateur
- **Email :** admin@hrttelecoms.fr
- **Mot de passe :** password

### Managers (par branche)
- **Technique :** manager.technique@hrttelecoms.fr / password
- **Administratif :** manager.administratif@hrttelecoms.fr / password
- **Comptabilité :** manager.comptabilite@hrttelecoms.fr / password
- **Commercial :** manager.commercial@hrttelecoms.fr / password

### Utilisateurs (par branche)
- **Technique :** user.technique@hrttelecoms.fr / password
- **Administratif :** user.administratif@hrttelecoms.fr / password
- **Comptabilité :** user.comptabilite@hrttelecoms.fr / password
- **Commercial :** user.commercial@hrttelecoms.fr / password

## 🎬 Animations Lottie

Les animations Lottie doivent être placées dans `public/animations/` :

- `404.json` - Page 404
- `empty.json` - État vide (mes tutoriels)
- `no-results.json` - Aucun résultat de recherche
- `no-notifications.json` - Aucune notification
- `success.json` - Message de succès

Téléchargez des animations gratuites sur [LottieFiles.com](https://lottiefiles.com/)

## 🔒 Rôles et Permissions

### User (Utilisateur)
- Consulter tous les tutoriels
- Créer/Modifier/Supprimer ses propres tutoriels (si assigné à une branche)
- Recevoir des notifications

### Manager
- Toutes les permissions User
- Modifier/Supprimer les tutoriels de sa branche

### Admin (Administrateur)
- Toutes les permissions Manager
- Gérer les utilisateurs (CRUD)
- Gérer les branches (CRUD)
- Accès complet à l'administration

## 📱 Branches disponibles

1. **Administratif** (Bleu - #3b82f6)
2. **Comptabilité** (Vert - #10b981)
3. **Technique** (Orange - #f59e0b)
4. **Commercial** (Rouge - #ef4444)

## 🛠️ Commandes utiles
```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recompiler les assets en développement
npm run dev

# Recompiler les assets en production
npm run build

# Créer un nouvel utilisateur admin
php artisan tinker
> User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);

# Reset la base de données (attention : supprime toutes les données)
php artisan migrate:fresh --seed
```

## 📦 Technologies utilisées

### Backend
- **Laravel 10** - Framework PHP
- **Laravel Breeze** - Authentification
- **MySQL** - Base de données

### Frontend
- **SASS** - Préprocesseur CSS
- **Vite** - Build tool
- **Lottie Web** - Animations JSON

### Services
- **FileUploadService** - Gestion des uploads de fichiers
- **Notifications** - Système de notifications Laravel

## 🐛 Dépannage

### Erreur "Class not found"
```bash
composer dump-autoload
```

### Erreur "Mix manifest not found"
```bash
npm run dev
```

### Problème de permissions sur storage
```bash
chmod -R 775 storage bootstrap/cache
```

### Erreur "SQLSTATE[HY000] [2002]"
Vérifier que MySQL est démarré et que les credentials dans `.env` sont corrects.

## 📄 Licence

Ce projet est privé et propriété de HR Télécoms.

## 👨‍💻 Développeur

Développé par **David** - Atelier Normand du Web

---

**HR Télécoms** © 2025 - Tous droits réservés
