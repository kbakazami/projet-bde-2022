#  PROJET ANNUEL - BDE
    
## About the project

### Contributors

 * Developers : Sofia Chaudhry, Wyvin Struys, Nadia Schwaller
 * Designer : Sofia Chaudhry
 
### Prerequis

> PhP 8.0 
> Composer 
> Npm

### Installation 

Après avoir fait un git pull : ``composer install`` pour installer les dépendances.

La première fois que l'on récupère le projet sans tailwind il faut faire : ``npm install`` pour installer les dépendances tailwindcss.

Lancer le localhost : ``composer start``.

Lancer le build du css : ``npm run watch`` /!\ Lancer la commande même si on ajoute seulement des classes dans un template twig /!\.

A la première installation du site il est obligatoire de faire cette commande pour build le css ``npm run watch``.

Pensez également a bien mettre un readme (vous pouvez prendre celui de symfony)