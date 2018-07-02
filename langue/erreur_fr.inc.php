<?php
/*
Fichier			: err_fr.inc.php
Commentaire		: textes d'erreurs en francais, %s étant l'argument passé au moment de l'appel 
Version			: 2017A


*/

$_histo_messages = array(

0 => array('Erreur N° code','Aucun code d\'erreur n\'a été spécifié !'),

1 => array('Erreur de connexion à la base de donnée','Erreur(%s) : %s'),
2 => array('Méthode inexistante','La méthode %s n\'existe pas.'),
3 => array('Arguments methode','La méthode %s doit avoir %d arguments de type %s.'),
4 => array('Erreur','%s %s'),
5 => array('Erreur','Une erreur s\'est produite dans la méthode %s : %s'),

10 => array('Fichier introuvable','Le fichier %s n\'existe pas. Erreur dans la méthode %s'),
11 => array('Erreur boucle sur tableau','La variable %s de la page %s n\'est pas un tableau'),
12 => array('Fichier introuvable','Le fichier (%s) de la page (%s)  n\'existe pas.'),
13 => array('Requete inconnu','Une demande inconnu (%s) a été faite au serveur.'),
14 => array('Le serveur ne réponds pas','Impossible de mettre à jour le tableau %s, veuillez re-essayer plus tard.'),
15 => array('Connexion utilisateur','Le mot de passe saisie est incorrecte. Il vous reste %s tentative(s)"'),    
16 => array('Connexion utilisateur','Trop de tentative . Veuillez fermer le navigateur et recommencer !'),    

20 => array('Connexion FTP','Impossible de se connecter au serveur %s'),    
21 => array('Connexion FTP','Impossible de se connecter au serveur %s@%s avec le mot de passe %s')    

);
?>
