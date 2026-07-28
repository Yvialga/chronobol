# Chronobol
Il s'agit d'une application de chronométrage pour un évènement de type triathlon.  
Elle va permettre de gérer les compétitions, les parcours, les équipes, les compétiteurs et les temps de course.

## Tech Stack
- Frontend : Twig, Tailwind
- Backend : Symfony, MariaDB
- dev : Docker compose, phpmyadmin

## Prerequisites
- Composer >= 2.8
- PHP >= 8.2
- Symfony cli >= 5.15
- Git
- Docker and Docker composer v28+

## Étapes pour exécuter le projet en local
1. Cloner le repository
```bash
git clone https://github.com/yvialga/chronobol.git
```
2. Installer les dépendances
```bash
cd app/
composer install
cd ..
```
3. Créer la base de données
```bash
symfony console doctrine:database:create
```
4. Exécuter les migrations
```bash
symfony console doctrine:migrations:migrate
```
5. Charger les fixtures
```bash
symfony console doctrine:fixtures:load
```
6. Exécuter le container du projet
```bash
docker-compose up -d
```

7. Lancer symfony en local. Le chargement à chaque modification par docker étant trop long.
```bash
symfony serve
```

8. voir ses modifications en cas de changements CSS --
```bash
cd app/
npm run watch
```

### Mettre à jour les dépendances codebase
```bash
cd app/
composer update
```

```bash
cd app/
npm updgrade
```

## Se connecter à mysql
```bash
docker exec -it database mysql -u you_user -p
```