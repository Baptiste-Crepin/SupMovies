# Guide d'utilisation

## Solution 1

La solution la plus simple pour pouvoir tester ce code est de vous rendre sur [ce lien](https://baptiste-crepin.fr/SupMovies/).

Cela permet d'avoir acces a toute les fonctionnalités du site.

## Solution 2

Dans le cas ou vous souhaiteriez utiliser le site en local, aucune manipulation ne devrait etre necessaire et vous devriez etre connecté a la base de donnée hostée.

En cas de problème, tout les mots de passes utiles se trouvent dans le fichier credentials.php et vous avez un script 'movies.sql' qui vous permettra de créer la base de donnée en local.

## Informations complémentaires

### Requetes base de donnée

Attention, il est important de noter que la base de donnée est hostée sur un serveur n'autorisant que très peu de requetes, il est donc possible que le site ne soit pas accessible pendant un certain temps.

### Mots de passe

Il y a un anti brute force sur les mots de passe, il est donc possible que vous ne puissiez pas vous connecter au site si vous avez fait trop de tentative de connexion.

### Compte

Il existe un compte de base pour tester le site, il s'agit du compte 'Admin' avec le mot de passe 'Admin123'. cependant, ce compte ne possede pas plus de droit que les autres utilisateurs. vous pouvez donc créer votre propre compte sans que rien ne change au niveau de l'experience utilisateur.

### Factures

Quand vous achetez un film, une facture est générée, elle est envoyée par mail si vous l'avez renseigné au moment de l'inscription ou modifié par la suite. cette fonctionalité n'existe que sur la version hostée du site. vous n'y aurez donc pas accès en local avec la solution 2.
