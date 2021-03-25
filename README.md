
#Projet GestyFood
*** 
##A faire lorsqu'on récupère le projet sur GitHub :

##Créer le fichier .env.local :
```dotenv
DATABASE_URL=mysql://root:root@127.0.0.1:8889/gestyfood?serverVersion=5.7
```

```shell script
composer install
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
php bin/console lexik:jwt:generate-keypair
symfony serve
```

##Installation et compilation des assets :
```shell script
npm install
npm run watch
```
****************************************************************
****************************************************************
****************************************************************
## Création du projet GestyFood
-[X] Effectué
```shell script
symfony new --full gestyfood
```
## mise en place du server symfony
-[x] Effectué
```shell script
symfony serve
```

                                                                ## COMMIT !!

### Installation de Maker bundle
### Doctrine ORM
-[x] Déjà effectué en Full

###Configurer la connexion à la base de données en créant le fichier .env.local :
   ```dotenv
   DATABASE_URL=mysql://root:root@127.0.0.1:8889/gestyfood?serverVersion=5.7
   ```
                                                                    ## COMMIT !!

##Créer la base de données :
-[x] Effectué
```shell script
php bin/console doctrine:database:create
```

##Créer les entités Doctrine :
-[x] Effectué
```shell script
php bin/console make:entity
```

##SAUF POUR L'ENTITE User :
-[x] Effectué
```shell script
composer req security
php bin/console make:user
```

##Créer le fichier de migration puis l'exécuter :
-[x] Effectué
```shell script
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
                                                                    ## COMMIT !!
*************************************************
# Créer les données de test

##Installer DoctrineFixturesBundle :
-[X] Effectué
```shell script
composer req orm-fixtures --dev
```

##Créer des fichiers de fixtures pour chaque entity :
-[] Effectué
```shell script
php bin/console make:fixtures
```

##Execute les fixtures :
-[x] Effectué
```shell script
php bin/console doctrine:fixtures:load
```
                                                                    ## COMMIT !!
*************************************************

#mise en place du composant api_platform

##installer le composant Api Platform  :
-[x] Effectué
```shell script
composer require api
```
##création  des composants pour chaque entité et configuration api_platform
-[x] Effectué

                                                                   ## COMMIT !!
*************************************************

#mise en place du Jwt Authentication
https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#getting-started

##installer Jwt Authentication  :
-[x] Effectué
```shell script
composer require "lexik/jwt-authentication-bundle"
```
##verifier si on a openssl
-[x] Effectué

###Generate the SSL keys:
-[x] Effectué
```shell script
php bin/console lexik:jwt:generate-keypair
```
### Configure the SSL keys path in config/packages/lexik_jwt_authentication.yaml
-[x] Effectué
```shell script
security:
    # ...
    
    firewalls:

        login:
            pattern:  ^/api/login
            stateless: true
            anonymous: true
            json_login:
                check_path:               /api/login_check
                success_handler:          lexik_jwt_authentication.handler.authentication_success
                failure_handler:          lexik_jwt_authentication.handler.authentication_failure

        api:
            pattern:   ^/api
            stateless: true
            guard:
                authenticators:
                    - lexik_jwt_authentication.jwt_token_authenticator

    access_control:
        - { path: ^/api/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/api,       roles: IS_AUTHENTICATED_FULLY }
```
###Configure your routing into config/routes.yaml :
-[x] Effectué
```shell script
api_login_check:
    path: /api/login_check
```
                                                                  ## COMMIT !!
*************************************************
###mise en place d'event pour securisé l'acces a certaine donnée par recuperation d"evenement :
dossier CurrentUserSession
-[x] Effectué
                                                                  ## COMMIT !!
*************************************************
###mise en place doctrine pour securisé l'acces a certaine donnée :
dossier CurrentUserSession
-[x] Effectué