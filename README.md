# boomerang

Logiciel requis /!\ OBLIGATOIRE :
- Composer (https://getcomposer.org/download/)
- Symfony (https://symfony.com/download)
- Git bash (https://gitforwindows.org/)

Instruction pour l'installation du projet :
- git bash sur l'emplacement souhaité
- git clone https://github.com/MaximeLefeb/boomerang.git 
- cd boomerang
- Créer un fichier nommé .env.local
- Coller ces deux lignes :
    - APP_ENV=dev
    - DATABASE_URL="mysql://root:@127.0.0.1:3306/generationBoomerang?serverVersion=mariadb-10.4.11"
    - (Pour Mac remplacer la ci-dessus par DATABASE_URL="mysql://root:root@127.0.0.1:3306/generationBoomerang?serverVersion=mariadb-10.4.11")
- Dans git bash exécuter composer install


Démarrer le serveur local : 
- Dans le terminal (ou git bash) exécuter 
    - symfony serve (ou php bin/console server:run)


Éteindre le serveur local : 
- Dans le terminal (ou est actuellement allumé le serveur) Appuyer sur CTRL + C 
- Éxécuter la commande 
    - symfony server:stop (ou php bin/console server:stop)


Instruction pour créer sa branch :
- Vérifier les branch éxécuter 
    - git branch
- Créer sa branch éxécuter 
    - git branch NomDeMaBranch
- Pour aller sur cette branch 
    - git checkout NomDeLaBranch


Instruction pour créer un tag du projet (à faire uniquement pour les versions stable du projet et avant les mises en prod) :
- Éxécuter la commande dans git bash ou le terminal (version à incrémenter à chaque nouveau tag)
    - git tag -a v1.0.3 -m 'v1.0.3'
- Pour push le tag éxécuter
    - git push origin v1.0.3


Pour récuperer les changements de la banch master sur sa branch :
- En cas de changements en cours 
    - git add *
    - git commit -m 'commentaire concernant mes modifications'
- Ensuite éxécuter : 
    - git pull --rebase origin master


Pour push ses changement : 
- ajout des changement
    - git add *
- sauvegarder les changements 
    - git commit -m 'commentaire concernant mes modifications'
- rebase les changements du master afin d'éviter les pertes de code
    - git pull --rebase origin master
- push les changement sur ma branch
    - git push origin maBranch
- (en cas de fast-forward error) 
    - git push origin maBranch --force


Pour push ses changement en cas de conflits :
- Gerer les conflits manuellement 
    - Sur vs code le nom des fichiers ayant un problèmes apparaîtront en rouge 
    - Aller sur ces fichiers et choisir le code à conserver
- Une fois tous les conflits reglés éxécuter dans le terminal
    - git add *
    - git commit -m 'commentaire concernant mes modifications & fixe conflits'
    - git rebase --continue
    

Instructions pour merge les changements de ma branch sur le master :
- prioriser les merge via le repo sur un navigateur
    - (Dans le cas ou l'encart de pull request n'aparait pas sur le repo depuis la navigateur) :
        - Cliquez sur pull request en haut à gauche.
        - Cliquez sur le bouton vert " New pull request ".
        - Sur le input de droite (compare) de type select selectionner notre branch.
        - Cliquez sur " Create pull request ".
        - Cliquez sur le bouton vert " Merge pull request ".
- Dans le cas ou vous effectuez vos pull request sur git :
    - Débrouillez vous :^p (https://git-scm.com/docs/git-merge)

Instructions pour migration :
- Dans le terminal sur le dossier du projet
    - supprimer tous les fichiers dans le dossier migration
    - php bin/console make:migration ( ou symfony make:migra )
    - php bin/console d: m: m ( ou symfony d: m: m )