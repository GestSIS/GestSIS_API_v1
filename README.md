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
Durée de validité du jeton (token_exp) : 30 jours par défaut
Exemple de valeur de retour :
```javascript
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJ...",
  "token_exp": 1497636448,
  "user": {
    "id": 12,
    "gender_id": 1,
    "gender_label": "Monsieur",
    "firstname": "Henri",
    "lastname": "Dupont"
 }
}
```

### Inscription de l'utilisateur
POST /v1/user/signup  
Paramètres : sis_id, email, password, password_confirmation  
Exemple de valeur de retour :
```javascript
{
  "success": true,
  "message": "Votre compte a bien été créé. Vous allez prochainement recevoir un e-mail contenant un lien pour activer définitivement votre compte."
}
```

### Utilisation du jeton
Pour accéder à toutes les ressources, il est nécessaire de s'authentifier en utilisant le jeton obtenu lors du login. Pour ce faire, il faut ajouter le header Authorization et lui passer la valeur Bearer suivi du jeton.
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJh...
```

### Liste des sapeurs
GET /v1/sapeurs

#### Paramètres
- Limiter le nombre de résultats : start (int), limit (int, min : 1, max : 30)
- Ordre : order (string, valeurs possibles : nom_prenom, fon_nom_prenom, porteur_fon_nom_prenom, permisc1_fon_nom_prenom, grade_nom_prenom, datenaiss_nom_prenom, anniv_nom_prenom, groupe_fon_nom_prenom, dateinco, datesortie, commune, mutinco, mutsortie), reverse (bool)
- Filtres : grp_id (int), cou_id (int), com_id (int), fon_id (int), civ_id (int), annee_inco (date), annee_sortie (date), annee_naiss_de (date), annee_naiss_a (int, 4 chiffres), porteur (bool), permis_c1 (bool), permis_b (bool), actif (bool), politique (bool), effectif_en (int, 4 chiffres)

#### Exemple de résultat
GET /v1/sapeurs?start=0&limit=5&annee_inco=2013&order=nom_prenom
```javascript
{
  "data": [
    {
    "id": 12,
    "nom": "Dupont",
    "prenom": "Henri",
    "porteur": 0,
    "permis_c1": 0,
    "permis_c1_date": null,
    "groupes": "92, 96, 10",
    "tel_prive": null,
    "tel_prive_rta": 1,
    "tel_prof": null,
    "tel_prof_rta": 1,
    "tel_mobile": "099 999 99 99",
    "tel_mobile_rta": 1,
    "date_naissance": "1994-01-01",
    "email": "henri.dupont@gmail.com",
    "no_rue": "14",
    "rue": "Rue de la Vigne",
    "date_inco": "2013-01-01",
    "date_sortie": null,
    "npa": "2946",
    "localite": "Miécourt",
    "civilite": "Monsieur",
    "fonction": null,
    "grade": null
    },
    //...
  ],
  "paging": {
    "next": "http://api.gestsis.run/v1/sapeurs?start=5&limit=5&annee_inco=2013&order=nom_prenom"
  },
  "count": 8
}
```

### Détail d'un sapeur
GET /v1/sapeurs/{id}

#### Exemple de résultat
GET /v1/sapeurs/12
```javascript
{
  "sapeur": {
    "id": 12,
    "nom": "Dupont",
    "prenom": "Henri",
    "porteur": 0,
    "permis_c1": 0,
    "permis_c1_date": null,
    "groupes": "92, 96, 10",
    "tel_prive": null,
    "tel_prive_rta": 1,
    "tel_prof": null,
    "tel_prof_rta": 1,
    "tel_mobile": "099 999 99 99",
    "tel_mobile_rta": 1,
    "date_naissance": "1994-01-01",
    "email": "henri.dupont@gmail.com",
    "no_rue": "14",
    "rue": "Rue de la Vigne",
    "date_inco": "2013-01-01",
    "date_sortie": null,
    "profession": "Polymécanicien",
    "employeur": "\u0000",
    "no_avs": "999.9999.9999.99",
    "permis_b": 1,
    "permis_b_date": null,
    "lieu_travail": "Bassecourt",
    "actif": 1,
    "cpt_bancaire": null,
    "no_ccp": null,
    "iban": "CH99 9999 9999 9999 9999 9",
    "iban_statut": 1,
    "politique": false,
    "npa": "2946",
    "localite": "Miécourt",
    "civilite": "Monsieur",
    "fonction": "Porteur",
    "grade": null,
    "photo": "http://hs.gestsis.ch/photos/sap_id_12.jpg"
  },
  "mutations": [
    {
      "id": 3000066,
      "date_inco": "2015-02-03",
      "date_sortie": null,
      "motif": "Incorporation",
      "localite": "Bassecourt"
    }
  ],
  "fonctions": [
    {
      "id": 19,
      "nom": "Porteur",
      "nom_abr": "PAR",
      "date": "2017-01-01",
      "fin": null,
      "remarque": ""
    }
    // ...
  ],
  "groupes": [
    {
      "id": 3,
      "no": 92,
      "nom": "SIS-HS2"
    }
    // ...
  ],
  "cours": [
    {
      "id": 17,
      "nom": "FGB/PR (formation  général de base+PR)",
      "nom_abr": "BA 1",
      "date": "2016-08-08",
      "lieu": "Balsthal"
    }
    // ...
  ],
  "promotions": [
      {
        "id": 6,
        "grade": "Caporal",
        "grade_abr": "Cpl",
        "date": "2005-01-01",
        "remarque": ""
      }
      // ...
  ],
  "ctrl_med": [
    {
      "id": 6000004,
      "date_consultation": "2016-01-25",
      "date_validite": "2021-01-25",
      "accepte": 1,
      "encours": 1,
      "type": "Contrôle PAR",
      "medecin": "Dr. Pouleur"
    }
    // ...
  ],
  "exercices": {
    "data": [
      {
        "id": 4000131,
        "date": "2017-12-09",
        "heure": "00:00:00",
        "lieu": "Par section",
        "communication": "Téléthon : 9 et 10 décembre",
        "duree": 120,
        "statut": 1,
        "categorie": "Divers - Information",
        "localite": "-",
        "convoque": 1,
        "present": 0,
        "amende": 0,
        "type_excuse": null,
        "id_type_excuse": null
      }
      // ...
    ],
    "paging": {
      "next": "http://api.gestsis.run/v1/exercices?sap_id=12&start=10&limit=10&order=date&reverse=1"
    },
    "count": 44
  },
  "interventions": {
    "data": [
      {
        "id": 5000003,
        "date": "2017-03-31",
        "heure": "22:37:00",
        "lieu": "Rue de la Gare",
        "objet": "Salle d'attente gare",
        "date_fin": "2017-03-31",
        "heure_fin": "23:30:00",
        "quittance": 1,
        "present": 1,
        "nb_heures": 0.75,
        "nb_heures_piquet": null,
        "nb_heures_entretien": null,
        "type": "Feu bâtiment",
        "npa": "2854",
        "localite": "Bassecourt",
        "traitement": "A vérifier",
        "stat_fed": "Lutte contre le feu"
      },
      // ...
    ],
    "paging": {
      "next": "http://api.gestsis.run/v1/interventions?sap_id=12&start=10&limit=10&order=date&reverse=1"
    },
    "count": 13
  }
}
```

### Liste des exercices
GET /v1/exercices

#### Paramètres
- Limiter le nombre de résultats : start (int), limit (int, min : 1, max : 30)
- Ordre : order (string, valeurs possibles : date, heure, localite, categorie, lieu, communication, heure_fin), reverse (bool)
- Filtres : annee (int, 4 chiffres), loc_id (int), cex_id (int), sap_id (int)

#### Exemple de résultat
GET /v1/exercices?start=0&limit=5&annee=2017&order=date&reverse=1

```javascript
{
  "data": [
    {
      "id": 4000132,
      "date": "2017-12-18",
      "heure": "19:00:00",
      "lieu": "Rue des Longennes 256",
      "communication": "Bureau chez le cdt",
      "duree": 120,
      "statut": 1,
      "categorie": "Bureau",
      "localite": "Boécourt",
      "convoque": null,
      "present": null,
      "amende": null,
      "type_excuse": null,
      "id_type_excuse": null
    }
    // ...    
  ],
  "paging": {
    "next": "http://api.gestsis.run/v1/exercices?annee=2017&start=5&limit=5&order=date&reverse=1"
  },
  "count": 57
}
```

### Détail d'un exercice
GET /v1/exercices/{id}

#### Exemple de résultat
GET /v1/exercices/4000132
```javascript
{
  "exercice": {
    "id": 4000132,
    "date": "2017-12-18",
    "heure": "19:00:00",
    "lieu": "Rue des Longennes 256",
    "communication": "Bureau chez le cdt",
    "description": "<div><font Style=\"Font: 11px Arial; color:#000000;\"><br /></font></div>",
    "duree": 120,
    "statut": 1,
    "categorie": "Bureau",
    "localite": "Boécourt"
  },
  "sapeurs": [
    {
      "id": 4,
      "nom": "Bellè",
      "prenom": "Mirco",
      "convoque": 1,
      "present": 0,
      "amende": 0,
      "type_excuse": null
    }
    // ...
  ]
}
```

### Liste des interventions
GET /v1/interventions

#### Paramètres
- Limiter le nombre de résultats : start (int), limit (int, min : 1, max : 30)
- Ordre : order (string, valeurs possibles : date, traitement, localite, type, lieu, objet), reverse (bool)
- Filtres : loc_id (int), annee (int, 4 chiffres), type_int_id, traitement_id, stat_fed_id, sap_id

#### Exemple de résultat
GET /v1/interventions?start=0&limit=5&annee=2017&order=date&reverse=1

```javascript
{
  "data": [
    {
      "id": 5000005,
      "date": "2017-04-19",
      "heure": "18:54:00",
      "lieu": "Rue ...",
      "objet": "Usine ...",
      "date_fin": "2017-04-19",
      "heure_fin": "20:15:00",
      "quittance": null,
      "present": null,
      "nb_heures": null,
      "nb_heures_piquet": null,
      "nb_heures_entretien": null,
      "type": "Alarme automatique",
      "npa": "2855",
      "localite": "Glovelier",
      "traitement": "A vérifier",
      "stat_fed": "Interventions diverses"
    }
    // ...
  ],
  "paging": {
    "next": "http://api.gestsis.run/v1/interventions?annee=2017&start=5&limit=5&order=date&reverse=1"
  },
  "count": 11
}
```

### Détail d'une intervention
GET /v1/interventions/{id}

#### Exemple de résultat
GET /v1/interventions/5000005
```javascript
{
  "intervention": {
    "id": 5000005,
    "date": "2017-04-19",
    "heure": "18:54:00",
    "lieu": "Rue du ....",
    "objet": "Usine ...",
    "date_fin": "2017-04-19",
    "heure_fin": "20:15:00",
    "rapport_police": 0,
    "stat_fed_nb": 1,
    "personnes_sauvees": null,
    "animaux_sauves": null,
    "description": "Une machine (tour) &agrave; surchauff&eacute; car elle est rest&eacute; allum&eacute; apr&egrave;s les heures de travail.<br />Elle a provoqu&eacute; de la fum&eacute;e.<br /><br />Nous avons ventil&eacute; les locaux et arret&eacute; la machine",
    "proprietaire": "...<br />Rue du ...<br />2855 Glovelier",
    "responsable": "Monsieur<br />...<br />999 999 99 99<br /><br />Monsieur <br />...<br />",
    "degre": 4,
    "type": "Alarme automatique",
    "npa": "2855",
    "localite": "Glovelier",
    "traitement": "A vérifier",
    "stat_fed": "Interventions diverses",
    "chef_int_nom": "Cacciatore",
    "chef_int_prenom": "Daniele"
  },
  "sapeurs": [
    {
      "id": 4,
      "nom": "Bellè",
      "prenom": "Mirco",
      "quittance": 0,
      "present": 0,
      "nb_heure": null,
      "nb_heure_piquet": null,
      "nb_heure_entretien": null
    }
    // ...
  ],
  "groupes": [
    {
      "id": 28,
      "no": null,
      "nom": "Glovelier"
    }
    // ...
  ],
  "vehicules": [
    {
      "id": 1,
      "nom": "Tonne-Pompe (Bassecourt)"
    }
    // ...
  ],
  "materiel": [
    {
      "id": 6,
      "nom": "Ventilateur"
    }
  ]
}
```

### Liste des transferts
GET /v1/transfert

#### Paramètres
- Filtres : categorie (string : rapport-intervention ou presences-exercice), transmis (bool)

#### Exemple de résultat
GET /v1/transfert?categorie=rapport-intervention&transmis=0
```javascript
{
    "data": [
        {
          "id": 3,
          "categorie": "rapport-intervention",
          "nom": "02.12.2017 10:46 - Feu Usine",
          "contenu": {
              "en_creation": false,
              "proprietaire": {
                "nom": "Prop. nom",
                "prenom": "Prop. prénom",
                "adresse": "Adresse",
                "loc_id": 87,
                "telephone": "012 345 67 89",
                "email": "test@test.com"
              },
              "sapeurs": [
                  // ... TODO : Liste des sapeurs avec leur présence
              ],
              "missions": [
                {
                  "sapeur": {
                    "id": 4000000,
                    "nom": "Wermeille",
                    "prenom": "Bastien"
                  },
                  "date_debut": "2017-12-02T13:40:02+01:00",
                  "titre": "Sauvetage",
                  "date_fin": "2017-12-02T13:50:00Z",
                  "resume": "Résumé mission"
                }
                // ...
              ],
              "appels": [
                {
                  "date": "2017-12-26T14:40:43+01:00",
                  "numero": "123456",
                  "nom": "Test",
                  "commentaire": "Commentaire..."
                }
                // ...
              ],
              "vehicules": [
                3,
                7
                // ...
              ],
              "materiel": [
                {
                  "id": 6000007,
                  "nom": "Absorbant Ecosorb",
                  "quantite": 1
                },
                {
                  "id": 3,
                  "nom": "Aspirateurs",
                  "quantite": 2
                }
                // ...
              ],
              "date_debut": "2017-12-02T10:46:20+01:00",
              "objet": "Feu Usine",
              "lieu": "Usine 123",
              "date_fin": "2017-12-02T14:41:00Z",
              "type_int_id": 3,
              "stat_fed_id": 1,
              "chef_inter_sap_id": 224,
              "nb_personnes_sauvees": "3",
              "loc_id": 5,
              "nb_animaux_sauves": "1",
              "rapport_police": 1,
              "agent": "Prénom agent 1",
              "responsables": "Commentaire responsables... Multi-lignes",
              "description": "Description intervention Multi-lignes"
              },
          "date_creation": "2017-12-26 14:44:02",
          "date_reception": null
        }
    ]
}
```

### Confirmation de réception d'un transfert
PUT /v1/transfert/{id}/recu

Cette fonction sert à indiquer que le système distant a bien reçu le transfert. Cela enregistrera dans la DB la date de réception.

#### Exemple de résultat
PUT /v1/transfert/3/recu

```javascript
{
    "success": true
}
```
