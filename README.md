# Web GestSIS

## Installation
1. Installer WampServer, disponible ici : http://www.wampserver.com/
2. Une fois installé, lancer WampServer, un icône devrait apparaître en bas à droite. Faire un clic gauche dessus, puis Apache > httpd-vhosts.conf. Le bloc-notes s'ouvre avec le fichier de config. Ajouter les lignes suivantes à la fin :
(adapter Y:/Web-GestSIS par le chemin vers le répertoire du projet)
```
<VirtualHost *:80>
    DocumentRoot "Y:/Web-GestSIS/public"
    ServerName api.gestsis.run
    <Directory "Y:/Web-GestSIS/public">
        AllowOverride All
        Order Allow,Deny
        Allow from all
        Require all granted
    </Directory>
</VirtualHost>
```

3. Enregistrer et fermer le bloc-notes
4. Ouvrir le bloc-notes en tant qu'administrateur, puis ouvrir le fichier ``C:\Windows\System32\drivers\etc\hosts`` et ajouter la ligne suivante à la fin :
``127.0.0.1 api.gestsis.run``
5. Enregistrer et fermer le bloc-notes
6. Redémarrer le service Apache en cliquant l'icône WampServer, puis Redémarrer les services
7. Installer Composer, disponible ici : https://getcomposer.org/download/
8. Ouvrir une ligne de commande, se positionner à l'intérieur du projet, et lancer la commande ``composer update``. Cela installera les dépendances.
9. Tester l'accès en ouvrant le lien http://api.gestsis.run

## Utilisation
Principe : L'utilisateur se connecte avec ses identifiants de connexion et il reçoit en retour un jeton de type JWT. Ce jeton sera utilisé dans toutes les futures requêtes comme moyen d'authentification.

### Connexion de l'utilisateur
POST /v1/user/login  
Paramètres : sis_id, username, password  
Exemple de valeur de retour :
```
{
  "success": true,
  "token": "--- Jeton ---",
  "token_exp": 1497636448,
  "user": {
    "id": 1,
    "gender_id": null,
    "gender_label": null,
    "firstname": null,
    "lastname": null
 }
}
```
