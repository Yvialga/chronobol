## Tech Stack
- Frontend : Twig, Tailwind
- Backend : Symfony, MariaDB
- dev : Docker compose, phpmyadmin

## Prerequisites
- Composer
- PHP php:8.4
- Symfony cli
- Git
- Docker and Docker composer

## Étapes pour exécuter le projet en local
1. Cloner le repository
```bash
git clone https://github.com/your_username/chronobol.git
```
2. Installer les dépendances
```bash
cd app/
composer install
cd ..
```
3. Exécuter le container du projet
```bash
docker-compose up -d
```
3. voir ses modifications en cas de changements CSS
```bash
cd app/
npm run watch
```

### Mettre à jour la codebase
```bash
cd app/
composer update
```

```bash
cd app/
npm updgrade
```