# Mise à jour de la base de données TDF

## À propos du projet

- Tours concernés : Tours enregistrés pour consultations et les mises à jour. Prochains tours pour les insertions
- Langage utilisé : PHP [+javascript]
- Technique de mise à jour : des formulaires HTML
- Résultat attendu : application Web de mise jour de la base.
- Tables concernées : celles de la base TDF

![MLD](mld.png)


## Préparation des tables des tours 2015 à XXXX

L'objectif est de réaliser un ou plusieurs formulaires de mise à jour des tables du tour de France.
Le langage utilisé sera le PHP et la présentation sera faite en HTML.


### Contraintes

Les tables à mettre à jour sont (respecter l'ordre)

- TDF_COUREUR :
    - On ne peut supprimer un coureur qui possède des participations au tour de France,
    - Une modification ne peut concerner le numéro de coureur,
    - Les champs : nom,prenom et code_tdf sont obligatoires,
    - num_coureur est calculé,
    - les noms des coureurs sont écrits en majuscule sans accent. Les tirets (dont 1 double tiret), espaces isolés
sont autorisés mais pas au début et à la fin. Les apostrophes sont autorisées. Les caractères autorisés sont
ceux de l'alphabet français (sans ligature),
    - les prénoms des coureurs sont écrits en minuscule sauf les premières lettres de chaque mot, codée en
majuscule sans accent. Les tirets et espaces isolés sont autorisés mais ni au début, ni à la fin,

- TDF_SPONSOR
    - Est considéré comme nouveau sponsor une « équipe » dont le nom exact + nom abrégé (ou code_tdf) n'est
pas ou plus dans la liste des sponsors actifs. Le sponsor actif est le dernier sponsor d'une équipe qui n'a pas
disparue. Créer un nouveau sponsor consiste à « remplacer » (par ajout d'un nouveau sponsor) l'ancien
sponsor par le nouveau.

- TDF_EQUIPE
    - Quand une nouvelle équipe est créée, un nouveau sponsor lui est associé.

- TDF_EQUPE_ANNEE
    - Cette table contient la participation des équipes au tour de France. Seuls les sponsors actifs peuvent être
inscrits
    - Au moins un directeur est associé à cette participation.
    - Un directeur ne peut participer au même tour de France avec plusieurs sponsors

- TDF_PARTICIPATION
    - Les coureurs peuvent être inscrits dans les équipes elles-mêmes participantes.
    - 9 coureurs peuvent être inscrits dans chaque équipe
    - les dossards d'une équipe appartient à la même dizaine (de X1 à X9)
    - les dossards doivent être uniques à chaque tour de France
    - un coureur ne peut-être inscrit à plusieurs tours de France la même année

- Les noms des épreuves sont codés comme les noms des coureurs . Les chiffres sont autorisés,
- Les noms des sponsors sont écrits en majuscule sans accent : tous les caractères (même ceux de contrôle) sont
autorisés.
- Attention aux suppressions et modifications : l'intégrité référentielle doit être préservée.


### Fonctionnalités 

L'application minimale :

- proposera des formulaires d'ajout d'information dans la base
- empêchera l'inscription de données déjà présentes dans la base
- empêchera l'inscription de données absurdes

Plusieurs options peuvent permettre d'améliorer l'application

- une page générale proposant tous les ajouts
- des menus déroulant d'aide à la saisie
- l'affichage des données inscrites avant enregistrement définitif dans la table
- des scripts de vérification des données saisies
- le calcul automatique des identifiants
- amélioration de la présentation par des feuilles de style
- journal des transactions et des éventuelles erreurs
- possibilité de visualiser voire de corriger la base
- identification de l'utilisateur (gestion de la sécurité)
- consultations variées des données TDF

Dans un souci d'efficacité chaque binôme développera (dans l'ordre) le formulaire coureur + (s’il est parfait)

- faible difficulté :
    - formulaire année
    - formulaire épreuve
- moyenne difficulté :
    - formulaire sponsor
    - formulaire équipe
    - formulaire pays
- grande difficulté :
    - formulaire participation des équipes [avec lien sur création d'équipe et pays]
    - formulaire participation des coureurs [avec lien sur création de coureur et pays]
- complet :
    - tous les formulaires sauf abandon, typeaban, temps, ordrequi
- méga complet :
    - possibilité en mode « non connecté » de visualiser de nombreuses informations de la base TDF
(liste des gagnants d'étapes , liste des coureurs français , classement général, liste des sponsors ...)