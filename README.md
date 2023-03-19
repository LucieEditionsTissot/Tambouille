# Tambouille

Tambouille est un projet d'école réalisé en Symfony 6 dans le but de créer un réseau social familial et amical autour de la cuisine et des recettes de cuisine à partager avec ses proches.

![Cover](https://github.com/LucieEditionsTissot/Tambouille/blob/main/public/assets/logo_tambouille.png)
![Cover](https://github.com/LucieEditionsTissot/Tambouille/blob/main/public/assets/tambouille.png)

## Fonctionnalités
Le site web Tambouille offre les fonctionnalités suivantes :

* Création de profil utilisateur et modification des informations
* Ajout et modification de recettes de cuisine personnelles
* Consultation des recettes d'autres utilisateurs
* Commentaires et évaluations des recettes
* Ajout de posts et de commentaires
* <sub>en cours </sub>~~Recherche de recettes par mot-clé et filtres de recherche avancée~~
* Partage de recettes sur le fil d'actualité
* Création de groupe et possibilité d'en rejoindre un


## Installation
Pour installer le projet Tambouille, suivez les étapes suivantes :

### Commencer par installer Symfony :

* [Installer Symfony](https://symfony.com/doc/current/setup.html#setting-up-an-existing-symfony-project)


#### Cloner le dépôt Git : 

``git clone https://github.com/LucieEditionsTissot/Tambouille.git``

#### Installer les dépendances du projet : 

``composer install``

Configurer la base de données dans le fichier **.env** en renseignant les informations de connexion à la base de données que vous pouvez trouver dans le **.env.example**

#### Créer la base de données : 

``php bin/console doctrine:database:create``

#### Effectuer les migrations : 

``php bin/console doctrine:migrations:migrate``

#### Charger les données de test : 

``php bin/console doctrine:fixtures:load ``

#### Lancement du projet
``symfony server:start``

#### Adresse pour accéder au projet 
**[localhost:8000](http://localhost:8000/login)**

!Optionnel!
 ### Si vous souhaitez avoir accès à votre base de données de manière visuelle

``docker run -d -p 8080:8080 --rm -v $(pwd)/var/data.db:/db/my_database.db tomdesinto/sqliteweb my_database.db``

#### Puis rendez vous sur 
**[Ma base de données en couleur](http://localhost:8080/)**
!Optionnel!

#### Utilisation
Pour cette première utilisation, j'ai pris le soin de vous créer un compte utilisateur au préalable.
Tout d'abord, bienvenue à vous **Ryan Gosling**, vous accéderez à votre profil avec votre adresse mail : **ryan.gosling@love.com** et nos équipes ont pris le soin de vous créez un mot de passe sur mesure : **1mot2passeSTP**.
Une fois connecté prenez la liberté d'explorer les différentes possibilités que nous pouvons retrouver sur notre site, bien qu'il soit encore en construction. Vous pouvez 'aller **voir les membres de votre famille déjà présent dans votre groupe** ou de **commenter les posts publiés par les autres utilisateurs.**
Vous aurez aussi la possibilité d'**accéder au livre de recette** afin d'**ajouter** vous aussi une nouvelle page à cette belle histoire culinaire.
Nous vou souhaitons un agréable séjour auprès de **Tambouille** et espérons vous revoir pour notre V3.

## Et la prod ?
#### **Work in progresss...**

# Made with :sparkling_heart: by
### Lucas Leperlier, Roxane Guella, Lucie Lesnier


