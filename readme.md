# SymBNB
Ce projet est l'application de la formation de Lior Chamla sur Symfony "Les fondamentaux par la pratique"

## Installation
  ### Requis
  - Composer
  - PHP 5.4
  - Symfony 4

  ### Procédure
  - Cloner le repo
  - Executer un `composer install`
  - Remplacer les identifiant de connexion à la base de donnée dans le fichier .env DATABASE_URL=mysql://<identifiant>:<mot de passe>@<host>/<nom de la base de donnée à créé>
  - Executer un `php bin/console doctrine:database:create` afin de créer la base de donnée
  - Executer un `php bin/console doctrine:migrations:migrate` afin d'executer les dernières migrations