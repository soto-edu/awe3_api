# Version 4 - Utilisation de la version 3 pour faire l'autentification de l'api



```bash
composer install
```

Executer le projet
```bash
php -S localhost:8080 -t public
```

## Swagger - Authorize (Bearer)

Les endpoints peuvent être marqués comme sécurisés via OpenAPI (`security: [["bearerAuth" => []]]`).
Dans Swagger UI (`/swagger`), tu peux ensuite cliquer sur **Authorize** et saisir ton token JWT (sans le préfixe `Bearer`).
