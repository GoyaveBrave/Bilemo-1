# BileMo [![Codacy Badge](https://api.codacy.com/project/badge/Grade/fb109be8d2e249869a3ec4181815cb5e)](https://www.codacy.com/app/percevalseb1309/Bilemo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=percevalseb1309/Bilemo&amp;utm_campaign=Badge_Grade)

__OpenClassrooms project :__ Create a web service exposing an API 

![Vibrating Phone](public/images/vibrating-phone.jpg)

## Summary

*   [Assignment](#assignment)
*   [Installation](#installation)
*   [Usage](#usage)
*   [Documentation](#documentation)

## Assignment

### Contexte

__BileMo__ est une entreprise offrant toute une sélection de téléphones mobiles haut de gamme.

Vous êtes en charge du développement de la vitrine de téléphones mobiles de l’entreprise BileMo. Le business modèle de BileMo n’est pas de vendre directement ses produits sur le site web, mais de fournir à toutes les plateformes qui le souhaitent l’accès au catalogue via une API (Application Programming Interface). Il s’agit donc de vente exclusivement en B2B (business to business).

Il va donc falloir que vous exposiez un certain nombre d’API pour que les applications des autres plateformes web puissent effectuer des opérations.

### Besoin client

Le premier client a enfin signé un contrat de partenariat avec BileMo ! C’est le branle-bas de combat pour répondre aux besoins de ce premier client qui va permettre de mettre en place l’ensemble des API et les éprouver tout de suite.

Après une réunion dense avec le client, il a été identifié un certain nombre d’informations. Il doit être possible de : 
*   consulter la liste des produits BileMo
*   consulter les détails d’un produit BileMo
*   consulter la liste des utilisateurs inscrits liés à un client sur le site web
*   consulter le détail d’un utilisateur inscrit lié à un client
*   ajouter un nouvel utilisateur lié à un client
*   supprimer un utilisateur ajouté par un client

Seuls les clients référencés peuvent accéder aux API. Les clients de l’API doivent être authentifiés via Oauth ou JWT.

Vous avez le choix de mettre en place un serveur Oauth et d’y faire appel (en utilisant le FOSOAuthServerBundle) ou d’utiliser Facebook, Google ou LinkedIn. Si vous décidez d’utiliser JWT, il vous faudra vérifier la validité du token ; l’usage d’une librairie est autorisée.

### Présentation des données

Le premier partenaire de BileMo est très exigeant : il requiert que vous exposiez vos données en suivant les règles des niveaux 1, 2 et 3 du modèle de Richardson. Il a demandé à ce que vous serviez les données en JSON. Si possible, le client souhaite que les réponses soient mises en cache afin d’optimiser les performances des requêtes en direction de l’API.

## Installation

1.  Clone or download this repository in your project folder
2.  Install all the project dependencies
```
$ composer install
```
3.  Customize the database connection information in the DATABASE_URL variable inside .env
4.  Create the database, the schema, and load data fixtures
```
$ php bin/console doctrine:database:create
$ php bin/console make:entity
$ php bin/console make:migration
$ php bin/console hautelook:fixtures:load
```
5.  Generate the SSH keys
```
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
6.  Configure the SSH keys path in the JWT_PASSPHRASE variable inside .env

## Usage

You need to get a JSON Web Token to access the API resources

For that, send the HTTP POST request in {yourdomain}/api/login_check with this JSON data in the Body of the request
```
{
	"username": "phoneandroid",
	"password": "l565oHhY"
}
```

Then, you receive a valid token for one hour that you must fill in the Headers of each of your HTTP requests to access the API resources
```
Authorization: Bearer yourAccessToken
```

## Documentation

You can access API documentation in {yourdomain}/api/doc or from this link ![api documentation in json format](doc/api-doc.json)
