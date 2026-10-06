# Version 3 - Utilisation de la version 2 pour créer la documentation OpenApi



```bash
composer install
composer require zircote/swagger-php
```

Executer le projet
```bash
php -S localhost:8080 -t public
```

1. On peut ajouter une nouvelle route dans le fichier routes.php
2. avec son controller `SwaggerController'
3. Nouvelle page View/swagger.php