Pour faire fonctionner le projet :

- Téléchargez WampServeur. Ce dernier est disponible est disponible en téléchargement gratuit sur différents sites (www.wampserver.com, www.clubic.com, www.01net.com ...)
- Installez WampServeur, il suffit de double-cliquer sur le fichier téléchargé et suivre les étapes d'installation (Par défaut, WampServeur est libré avec toutes les dernières versions de Apache, MySQL et PHP).
- Un répertoire "www", dont le chemin est "c:\wamp\www" est créé automatiquement. Il est nécessaire de créer un sous-répertoire, à l'intérieur même du répertoire "www". Ce sous-réperoire permerttra le stockage du projet et des différents fichers.
- Une fois le sous-répertoire créé, il faut y cloner le repositary. Pour ce faire, il faut lancer NetBeans, cliquer sur team, puis git, puis clone. Ensuite il faut entrer l'url du repositary à cloner, puis entrer le chemin du dossier qui contiendra le clone (en loccurence ici notre sous-répertoire créé précedement).
- A présent, lancez WampServeur.
- En bas à droite de l'écran, cliquez sur l'icone de WampServeur, puis lancé phpmyadmin.
- Dans PhpMyadmin, créez une base de données que vous nommez "projet_csi"
- Il faut par la suite créer un utilisateur dont le username est "projet_csi" et le pass est "csi" (le client doit être en local). Pour ce faire, il faut sélectionner la base de donnée créé, puis sélectionner la table user, puis vous pourrez effectuer les changements nécessaires.
- Enfin, il faut éxecutez le script dans /script/database.sql pour créer les tables
