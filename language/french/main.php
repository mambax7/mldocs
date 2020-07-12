<?php
//$Id: main.php,v 1.36 2005/11/02 20:38:22 eric_juden Exp $
// modification  le 19/05/2006    BYOOS solutions  Gabriel
// ajout bannette
define("_CT_BANNETTEFORM","Formulaire de gestion de la bannette");
define("_CT_THANKYOU","Merci de votre int&eacute;r&ecirc;t pour notre site !");
define("_CT_NAME","Nom");
define("_CT_EMAIL","E-mail");
define("_CT_URL","URL de la bannette");
define("_CT_ICQ","Nombre de vues dans la bannette");

define('_MLDOCS_CATEGORY1', 'Assigner un Propri&eacute;taire');
define('_MLDOCS_CATEGORY2', 'Supprimer les r&eacute;ponses');
define('_MLDOCS_CATEGORY3', 'Supprimer les archives');
define('_MLDOCS_CATEGORY4', 'Journalisation des utilisateurs\' archives');
define('_MLDOCS_CATEGORY5', 'Modifier les r&eacute;ponses');
define('_MLDOCS_CATEGORY6', 'Modifier l\'information de l\'archive');

define('_MLDOCS_SEC_ARCHIVE_ADD', 0);
define('_MLDOCS_SEC_ARCHIVE_EDIT', 1);
define('_MLDOCS_SEC_ARCHIVE_DELETE', 2);
define('_MLDOCS_SEC_ARCHIVE_OWNERSHIP', 3);
define('_MLDOCS_SEC_ARCHIVE_STATUS', 4);
define('_MLDOCS_SEC_ARCHIVE_PRIORITY', 5);
define('_MLDOCS_SEC_ARCHIVE_LOGUSER', 6);
define('_MLDOCS_SEC_RESPONSE_ADD', 7);
define('_MLDOCS_SEC_RESPONSE_EDIT', 8);
define('_MLDOCS_SEC_ARCHIVE_MERGE', 9);
define('_MLDOCS_SEC_FILE_DELETE', 10);

define('_MLDOCS_SEC_TEXT_ARCHIVE_ADD', 'Ajouter des archives');
define('_MLDOCS_SEC_TEXT_ARCHIVE_EDIT', 'Modifier des archives');
define('_MLDOCS_SEC_TEXT_ARCHIVE_DELETE', 'Effacer des archives');
define('_MLDOCS_SEC_TEXT_ARCHIVE_OWNERSHIP', 'Changer le propri&eacute;taire de l\'archive');
define('_MLDOCS_SEC_TEXT_ARCHIVE_STATUS', 'Changer l\'&eacute;tat de l\'archive');
define('_MLDOCS_SEC_TEXT_ARCHIVE_PRIORITY', 'Changer la priorit&eacute; de l\'archive');
define('_MLDOCS_SEC_TEXT_ARCHIVE_LOGUSER', 'Enregistrer l\'archive pour l\'utilisateur');
define('_MLDOCS_SEC_TEXT_RESPONSE_ADD', 'Ajouter une r&eacute;ponse');
define('_MLDOCS_SEC_TEXT_RESPONSE_EDIT', 'Modifier une r&eacute;ponse');
define('_MLDOCS_SEC_TEXT_ARCHIVE_MERGE', 'Fusionner les archives');
define('_MLDOCS_SEC_TEXT_FILE_DELETE', 'Effacer les fichiers attach&eacute;s');

define('_MLDOCS_JSC_TEXT_DELETE', 'Etes vous certain de vouloir supprimer cette archive ?');

define('_MLDOCS_MESSAGE_ADD_DEPT', 'D&eacute;partement ajout&eacute; avec succ&egrave;s');
define('_MLDOCS_MESSAGE_ADD_DEPT_ERROR', 'Erreur : D&eacute;partement non ajout&eacute;');
define('_MLDOCS_MESSAGE_UPDATE_DEPT', 'D&eacute;partement mis &agrave; jour');
define('_MLDOCS_MESSAGE_UPDATE_DEPT_ERROR', 'Erreur : D&eacute;partement non mis &agrave; jour');
define('_MLDOCS_MESSAGE_DEPT_DELETE', 'D&eacute;partement supprim&eacute;');
define('_MLDOCS_MESSAGE_DEPT_DELETE_ERROR', 'Erreur : D&eacute;partement non supprim&eacute;');
define('_MLDOCS_MESSAGE_ADDSTAFF_ERROR', 'Erreur : Membre du D&eacute;partement non ajout&eacute;');
define('_MLDOCS_MESSAGE_ADDSTAFF', 'Membre du D&eacute;partement ajout&eacute;');
define('_MLDOCS_MESSAGE_STAFF_DELETE', 'Membre du D&eacute;partement supprim&eacute;');
define('_MLDOCS_MESSAGE_STAFF_DELETE_ERROR', 'Membre du D&eacute;partement non supprim&eacute;');
define('_MLDOCS_MESSAGE_EDITSTAFF', 'Profil du Membre du D&eacute;partement mis &agrave; jour');
define('_MLDOCS_MESSAGE_EDITSTAFF_ERROR', 'Erreur : Membre du D&eacute;partement non mis &agrave; jour');
define('_MLDOCS_MESSAGE_EDITSTAFF_NOCLEAR_ERROR', 'Erreur : p&eacute;c&eacute;dent D&eacute;partement non supprim&eacute;');
define('_MLDOCS_MESSAGE_DEPT_EXISTS', 'ce D&eacute;partement existe d&eacute;j&agrave;');
define('_MLDOCS_MESSAGE_ADDARCHIVE', 'Archive enregistr&eacute;e');
define('_MLDOCS_MESSAGE_ADDARCHIVE_ERROR', 'Erreur : Archive non enregistr&eacute;e');
define('_MLDOCS_MESSAGE_LOGMESSAGE_ERROR', 'Erreur : Action non enregistr&eacute;e dans la base de donn&eacute;es');
define('_MLDOCS_MESSAGE_UPDATE_PRIORITY', 'Priorit&eacute; d\'une Archive mise &agrave; jour');
define('_MLDOCS_MESSAGE_UPDATE_PRIORITY_ERROR', 'Erreur : Priorit&eacute; de l\'Archive non mise &agrave; jour');
define('_MLDOCS_MESSAGE_UPDATE_STATUS', 'Etat de l\'Archive mise &agrave; jour');
define('_MLDOCS_MESSAGE_UPDATE_STATUS_ERROR', 'Erreur : Etat de l\'Archive non mise &agrave; jour');
define('_MLDOCS_MESSAGE_UPDATE_DEPARTMENT', 'D&eacute;partement de l\'Archive mise &agrave; jour avec succ&egrave;s');
define('_MLDOCS_MESSAGE_UPDATE_DEPARTMENT_ERROR', 'Erreur : Le D&eacute;partement de l\'Archive n\'a pas &eacute;t&eacute; mis &agrave; jour');
define('_MLDOCS_MESSAGE_CLAIM_OWNER', 'S\'approprier l\'archive');
define('_MLDOCS_MESSAGE_CLAIM_OWNER_ERROR', 'Erreur : Appropriation de l\'Archive non effectu&eacute;e');
define('_MLDOCS_MESSAGE_ASSIGN_OWNER', 'Vous avez assign&eacute; un Propri&eacute;taire &agrave; cette Archive');
define('_MLDOCS_MESSAGE_ASSIGN_OWNER_ERROR', 'Erreur : Propri&eacute;taire de l\'Archive non assign&eacute;e');
define('_MLDOCS_MESSAGE_UPDATE_OWNER', 'Mise &agrave; jour du Propri&eacute;taire de l\'Archive.');
define('_MLDOCS_MESSAGE_ADDFILE', 'Fichier envoy&eacute; avec succ&egrave;s');
define('_MLDOCS_MESSAGE_ADDFILE_ERROR', 'Erreur : Fichier non envoy&eacute;');
define('_MLDOCS_MESSAGE_ADDRESPONSE', 'R&eacute;ponse ajout&eacute;e');
define('_MLDOCS_MESSAGE_ADDRESPONSE_ERROR', 'Erreur : R&eacute;ponse non ajout&eacute;e');
define('_MLDOCS_MESSAGE_UPDATE_CALLS_CLOSED_ERROR', 'Erreur : Cloture de l\'Archive non mis &agrave; jour');
define('_MLDOCS_MESSAGE_ALREADY_OWNER', '%s est d&eacute;j&agrave; Propri&eacute;taire de cette Archive');
define('_MLDOCS_MESSAGE_ALREADY_STATUS', 'L\'Archive est d&eacute;j&agrave; d&eacute;fini avec cet Etat');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVE', 'Archive supprim&eacute;e');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVE_ERROR', 'Erreur : Archive non supprim&eacute;e');
define('_MLDOCS_MESSAGE_ADD_SIGNATURE', 'Signature ajout&eacute;e');
define('_MLDOCS_MESSAGE_ADD_SIGNATURE_ERROR', 'Erreur : Signature non mise &agrave; jour');
define('_MLDOCS_MESSAGE_RESPONSE_TPL', 'R&eacute;ponse pr&eacute;d&eacute;finie mise &agrave; jour');
define('_MLDOCS_MESSAGE_RESPONSE_TPL_ERROR', 'Erreur : R&eacute;ponse non mise &agrave; jour');
define('_MLDOCS_MESSAGE_DELETE_RESPONSE_TPL', 'R&eacute;ponse pr&eacute;d&eacute;finie supprim&eacute;e');
define('_MLDOCS_MESSAGE_DELETE_RESPONSE_TPL_ERROR', 'Erreur : R&eacute;ponse pr&eacute;d&eacute;finie non supprim&eacute;e');
define('_MLDOCS_MESSAGE_ADD_STAFFREVIEW', 'R&eacute;vision ajout&eacute;e');
define('_MLDOCS_MESSAGE_ADD_STAFFREVIEW_ERROR', 'Erreur : R&eacute;vision non ajout&eacute;e');
define('_MLDOCS_MESSAGE_UPDATE_STAFF_ERROR', 'Erreur : Profil du Membre non mis &agrave; jour');
define('_MLDOCS_MESSAGE_UPDATE_SIG_ERROR', 'Erreur : Signature non mise &agrave; jour');
define('_MLDOCS_MESSAGE_UPDATE_SIG', 'Signature mise &agrave; jour');
define('_MLDOCS_MESSAGE_EDITARCHIVE', 'Archive mise &agrave; jour');
define('_MLDOCS_MESSAGE_EDITARCHIVE_ERROR', 'Erreur : Archive non mise &agrave; jour');
define('_MLDOCS_MESSAGE_USER_MOREINFO', 'Archive mise &agrave; jour.');
define('_MLDOCS_MESSAGE_USER_MOREINFO_ERROR', 'Erreur : Informations non ajout&eacute;e');
define('_MLDOCS_MESSAGE_USER_NO_INFO', 'Erreur: Vous ne pouvez plus soumettre aucune autre nouvelle information');
define('_MLDOCS_MESSAGE_EDITRESPONSE', 'R&eacute;ponse mise &agrave; jour');
define('_MLDOCS_MESSAGE_EDITRESPONSE_ERROR', 'Erreur: R&eacute;ponse non mise &agrave; jour');
define('_MLDOCS_MESSAGE_NOTIFY_UPDATE', 'Notifications mise &agrave; jour');
define('_MLDOCS_MESSAGE_NOTIFY_UPDATE_ERROR', 'Notifications non mise &agrave; jour');
define('_MLDOCS_MESSAGE_NO_NOTIFICATIONS', 'L\utilisateur n\'avait pas de notification');
define('_MLDOCS_MESSAGE_NO_DEPTS', 'Erreur : Pas de D&eacute;partement d&eacute;fini. Contacter l\'Administrateur.');
define('_MLDOCS_MESSAGE_NO_STAFF', 'Erreur : Pas de Membre dans le D&eacute;partement consern&eacute;. Contacter l\'Administrateur.');
define('_MLDOCS_MESSAGE_ARCHIVE_REOPEN', 'Archive r&eacute;-ouverte.');
define('_MLDOCS_MESSAGE_ARCHIVE_REOPEN_ERROR', 'Erreur : Archive non r&eacute;ouvert.');
define('_MLDOCS_MESSAGE_ARCHIVE_CLOSE', 'Archive close.');
define('_MLDOCS_MESSAGE_ARCHIVE_CLOSE_ERROR', 'Erreur: Archive non close.');
define('_MLDOCS_MESSAGE_NOT_USER', 'Erreur : vous ne pouvez pas r&eacute;ouvrir une Archive que vous n\'avez pas soumise.');
define('_MLDOCS_MESSAGE_NO_ARCHIVES', 'Erreur : Pas de Archive s&eacute;lectionn&eacute;e.');
define('_MLDOCS_MESSAGE_NOOWNER', 'Pas de Propri&eacute;taire.');
define('_MLDOCS_MESSAGE_UNKNOWN', 'Inconnu');
define('_MLDOCS_MESSAGE_WRONG_MIMETYPE', 'Erreur : Type de Fichier non autoris&eacute;.');
define('_MLDOCS_MESSAGE_NO_UID', 'Erreur : Pas de Num&eacute;ro Utilisateur sp&eacute;cifi&eacute;');
define('_MLDOCS_MESSAGE_NO_PRIORITY', 'Erreur : Pas de Priorit&eacute; d&eacute;finie');
define('_MLDOCS_MESSAGE_FILE_ERROR', 'Erreur : Impossible de stocker le fichier transmis pour la raison suivante :<br />%s');
define('_MLDOCS_MESSAGE_UPDATE_EMAIL_ERROR', 'Erreur : Email non mis &agrave; jour');
define('_MLDOCS_MESSAGE_ARCHIVE_DELETE_CNFRM', 'Etes vous certain de vouloir effacer ces archives ?');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVES', 'Archives effac&eacute;es avec succ&egrave;s');
define('_MLDOCS_MESSAGE_DELETE_ARCHIVES_ERROR', 'Erreur: les Archives n\'ont pas &eacute;t&eacute; effac&eacute;es');
define('_MLDOCS_MESSAGE_VALIDATE_ERROR', 'Votre archive contient des erreurs, veuillez le corriger et le resoumettre.');
define('_MLDOCS_MESSAGE_UNAME_TAKEN', ' est d&eacute;j&agrave; en cours d\'utilisation.');
define('_MLDOCS_MESSAGE_INVALID', ' est non valide.');
define('_MLDOCS_MESSAGE_REQUIRED', ' est requis');
define('_MLDOCS_MESSAGE_LONG', ' est trop long.');
define('_MLDOCS_MESSAGE_SHORT', ' est trop court.');
define('_MLDOCS_MESSAGE_NOT_ENTERED', ' n\'est pas enter&eacute;.');
define('_MLDOCS_MESSAGE_NOT_NUMERIC', ' n\'est pas num&eacute;rique.');
define('_MLDOCS_MESSAGE_RESERVED', ' est r&eacute;serv&eacute;.');
define('_MLDOCS_MESSAGE_NO_SPACES', ' ne doit pas contenir d\'espace');
define('_MLDOCS_MESSAGE_NOT_SAME', ' n\'est pas le m&ecirc;me.');
define('_MLDOCS_MESSAGE_NOT_SUPPLIED', ' n\'est pas demand&eacute;.');
define('_MLDOCS_MESSAGE_CREATE_USER_ERROR', 'Utilisateur non cr&eacute;&eacute;');
define('_MLDOCS_MESSAGE_NO_REGISTER', 'L\'inscription a &eacute;t&eacute; close. Vous n\'&ecirc;tes pas autoris&eacute; &agrave; suivre une archive en ce moment.');
define('_MLDOCS_MESSAGE_NEW_USER_ERR', 'Erreur: votre compte utilisateur n\'a pas &eacute;t&eacute; cr&eacute;&eacute;.');
define('_MLDOCS_MESSAGE_EMAIL_USED', 'Erreur: cette adresse email est d&eacute;ja enregistr&eacute;e.');
define('_MLDOCS_MESSAGE_DELETE_FILE_ERR', 'Erreur: le fichier n\'a pas &eacute;t&eacute; effac&eacute;.');
define('_MLDOCS_MESSAGE_DELETE_SEARCH_ERR', 'Erreur: la recherche n\'a pas &eacute;t&eacute; &eacute;ffac&eacute;e.');

define('_MLDOCS_MESSAGE_UPLOAD_ALLOWED_ERR', 'Erreur: Le t&eacute;l&eacute;chargement de fichier n\'est pas activ&eacute; pour le module.');
define('_MLDOCS_MESSAGE_UPLOAD_ERR', 'le fichier %s de %s n\'a pas &eacute;t&eacute; enregist&eacute; parce que %s.');

define('_MLDOCS_MESSAGE_NO_ADD_ARCHIVE', 'Vous ne disposez pas des permissions pour enregistrer des archives.');
define('_MLDOCS_MESSAGE_NO_DELETE_ARCHIVE', 'Vous ne disposez pas des permissions pour effacer des archives.');
define('_MLDOCS_MESSAGE_NO_EDIT_ARCHIVE', 'Vous ne disposez pas des permissions pour &eacute;diter des archives.');
define('_MLDOCS_MESSAGE_NO_CHANGE_OWNER', 'Vous ne disposez pas des permissions pour changer de propri&eacute;taire.');
define('_MLDOCS_MESSAGE_NO_CHANGE_PRIORITY', 'Vous ne disposez pas des permissions pour changer de priorit&eacute;.');
define('_MLDOCS_MESSAGE_NO_CHANGE_STATUS', 'Vous ne disposez pas des permissions pour changer d\'&eacute;tat.');
define('_MLDOCS_MESSAGE_NO_ADD_RESPONSE', 'Vous ne disposez pas des permissions pour ajouter une r&eacute;ponse.');
define('_MLDOCS_MESSAGE_NO_EDIT_RESPONSE', 'Vous ne disposez pas des permissions pour &eacute;diter les r&eacute,ponses.');
define('_MLDOCS_MESSAGE_NO_MERGE', 'Vous ne disposez pas des permissions pour fusionner les archives.');
define('_MLDOCS_MESSAGE_NO_ARCHIVE2', 'Erreur: vous n\'avez pas sp&eacute;cifi&eacute; l\'archive &agrave; fusionner avec.');
define('_MLDOCS_MESSAGE_ADDED_EMAIL', 'Email ajout&eacute; avec succ&egrave;s.');
define('_MLDOCS_MESSAGE_ADDED_EMAIL_ERROR', 'Erreur: l\'email n\'a pas &eacute;t&eacute; ajout&eacute;.');
define('_MLDOCS_MESSAGE_NO_EMAIL', 'Erreur: vous n\'avez pas sp&eacute;cifi&eacute; l\'email &agrave; ajouter.');
define('_MLDOCS_MESSAGE_ADD_EMAIL', 'Notifications d\'Email mises &agrave; jour.');
define('_MLDOCS_MESSAGE_ADD_EMAIL_ERROR', 'Erreur : Notifications d\'Email non mises &agrave; jour.');
define('_MLDOCS_MESSAGE_NO_MERGE_ARCHIVE', 'Vous ne disposez pas des permissions pour supprimer un email');
define('_MLDOCS_MESSAGE_NO_FILE_DELETE', 'Vous ne disposez pas des permissions pour effacer des fichiers.');
define('_MLDOCS_MESSAGE_NO_CUSTFLD_ADDED', 'Erreur : La valeur du champs customis&eacute; n\'a pas &eacute;t&eacute; sauvegard&eacute;e.');

define('_MLDOCS_ERROR_INV_ARCHIVE', 'Erreur : Archive invalide !');
define('_MLDOCS_ERROR_INV_RESPONSE', 'Erreur : R&eacute;ponse invalide !');
define('_MLDOCS_ERROR_NODEPTPERM', 'Vous ne pouvez pas soumettre une r&eacute;ponse &agrave; cette archive. Raison : Vous n\'&ecirc;tes pas membre de ce d&eacute;partement.');
define('_MLDOCS_ERROR_INV_STAFF', 'Erreur : l\'utilsateur n\'est pas un membre du D&eacute;partement.');
define('_MLDOCS_ERROR_INV_TEMPLATE', 'Erreur : Mod&egrave;le invalide');
define('_MLDOCS_ERROR_INV_USER', 'Erreur : Vous ne disposez pas des permissions pour visualiser cette archive.');

define('_MLDOCS_TITLE_ADDARCHIVE', 'Indexer une Archive');
define('_MLDOCS_TITLE_ADDRESPONSE', 'Ajouter une R&eacute;ponse');
define('_MLDOCS_TITLE_EDITARCHIVE', 'Editer les Info de l\'Archive');
define('_MLDOCS_TITLE_EDITRESPONSE', 'Editer la R&eacute;ponse');
define('_MLDOCS_TITLE_SEARCH', 'Rechercher');

define('_MLDOCS_TEXT_SIZE', 'Taille :');
define('_MLDOCS_TEXT_REALNAME', 'Nom r&eacute;el');
define('_MLDOCS_TEXT_ID', 'N&ordm;');
define('_MLDOCS_TEXT_NAME', 'Nom');
define('_MLDOCS_TEXT_USER', 'Utilisateur:');
define('_MLDOCS_TEXT_USERID', 'N&ordm; d\'Utilisateur :');
define('_MLDOCS_TEXT_LOOKUP', 'R&eacute;solution');
define('_MLDOCS_TEXT_LOOKUP_USER', 'R&eacute;solution Utilisateur');
define('_MLDOCS_TEXT_EMAIL', 'Email :');
define('_MLDOCS_TEXT_ASSIGNTO', 'Assign&eacute; &agrave;');
define('_MLDOCS_TEXT_PRIORITY', 'Priorit&eacute;');
define('_MLDOCS_TEXT_STATUS', 'Etat');
define('_MLDOCS_TEXT_SUBJECT', 'Libell&eacute;');
define('_MLDOCS_TEXT_CODEARCHIVE', 'Code archive');
define('_MLDOCS_TEXT_DEPARTMENT', 'D&eacute;partement');
define('_MLDOCS_TEXT_OWNER', 'Propri&eacute;taire');
define('_MLDOCS_TEXT_CLOSEDBY', 'Clos par');
define('_MLDOCS_TEXT_NOTAPPLY', 'N/A');
define('_MLDOCS_TEXT_TIMESPENT', 'Temps Pass&eacute;');
define('_MLDOCS_TEXT_DESCRIPTION', 'Description');
define('_MLDOCS_TEXT_ADDFILE', 'Ajouter un fichier :');
define('_MLDOCS_TEXT_FILE', 'Fichier :');
define('_MLDOCS_TEXT_RESPONSE', 'R&eacute;ponse');
define('_MLDOCS_TEXT_RESPONSES', 'R&eacute;ponses');
define('_MLDOCS_TEXT_CLAIMOWNER', 'Originaire de la r&eacute;clamation :');
define('_MLDOCS_TEXT_CLAIM_OWNER', 'S\'approprier la r&eacute;clamation');
define('_MLDOCS_TEXT_ARCHIVEDETAILS', 'D&eacute;tails de l\'Archive');
define('_MLDOCS_TEXT_MINUTES', 'minutes');
define('_MLDOCS_TEXT_SEARCH', 'Recherche :');
define('_MLDOCS_TEXT_SEARCHBY', 'Par :');
define('_MLDOCS_SEARCH_DESC', 'Description');
define('_MLDOCS_SEARCH_SUBJECT', 'Sujet');
define('_MLDOCS_TEXT_NUMRESULTS', 'Nombre de r&eacute;sultats par page:');
define('_MLDOCS_TEXT_RESULT1', '5');
define('_MLDOCS_TEXT_RESULT2', '10');
define('_MLDOCS_TEXT_RESULT3', '25');
define('_MLDOCS_TEXT_RESULT4', '50');
define('_MLDOCS_TEXT_SEARCH_RESULTS', 'R&eacute;sultats de la recherche');
define('_MLDOCS_TEXT_PREDEFINED_RESPONSES', 'R&eacute;ponses Pr&eacute;-Definies :');
define('_MLDOCS_TEXT_PREDEFINED0', '-- Cr&eacute;er une R&eacute;ponse --');
define('_MLDOCS_TEXT_NO_USERS', 'Pas d\'utilisateurs trouv&eacute;');
define('_MLDOCS_TEXT_SEARCH_AGAIN', 'Chercher de nouveau');
define('_MLDOCS_TEXT_LOGGED_BY', 'Suivi par');
define('_MLDOCS_TEXT_LOG_TIME', 'Suivi horaire ');
define('_MLDOCS_TEXT_OWNERSHIP_DETAILS', 'D&eacute;tails sur le Propri&eacute;taire');
define('_MLDOCS_TEXT_ACTIVITY_LOG', 'Suivi d\'activit&eacute;');
define('_MLDOCS_TEXT_HELPDESK_ARCHIVE', 'Archive de Support:');
define('_MLDOCS_TEXT_YES', 'Oui');
define('_MLDOCS_TEXT_NO', 'Non');
define('_MLDOCS_TEXT_ALL_ARCHIVES', 'Toutes les Archives');
define('_MLDOCS_TEXT_HIGH_PRIORITY', 'Archives non-assign&eacute;es et de Hautes Priorit&eacute;es ');
define('_MLDOCS_TEXT_NEW_ARCHIVES', 'Nouvelles Archives');
define('_MLDOCS_TEXT_MY_ARCHIVES', 'Archives qui me sont assign&eacute;es');
define('_MLDOCS_TEXT_SUBMITTED_ARCHIVES', 'Archives que j\'ai soumis');
define('_MLDOCS_TEXT_ANNOUNCEMENTS', 'Annonces');
define('_MLDOCS_TEXT_MY_PERFORMANCE', 'Mes Performances');
define('_MLDOCS_TEXT_RESPONSE_TIME', 'Temps moyen de r&eacute;ponse :');
define('_MLDOCS_TEXT_RATING', 'Ratio :');
define('_MLDOCS_TEXT_NUMREVIEWS', 'Nombre de r&eacute;visions :');
define('_MLDOCS_TEXT_NUM_ARCHIVES_CLOSED', 'Nombres d\'archives closes :');
define('_MLDOCS_TEXT_TEMPLATE_NAME', 'Nom du mod&egrave;le :');
define('_MLDOCS_TEXT_MESSAGE', 'Message :');
define('_MLDOCS_TEXT_ACTIONS', 'Actions :');
define('_MLDOCS_TEXT_ACTIONS2', 'Actions');
define('_MLDOCS_TEXT_MY_NOTIFICATIONS', 'Mes notifications');
define('_MLDOCS_TEXT_SELECT_ALL', 'Tous');
define('_MLDOCS_TEXT_USER_IP', 'IP utilisateur :');
define('_MLDOCS_TEXT_OWNERSHIP', 'Propri&eacute;taire');
define('_MLDOCS_TEXT_ASSIGN_OWNER', 'Assigner un propri&eacute;taire');
define('_MLDOCS_TEXT_ARCHIVE', 'Archive');
define('_MLDOCS_TEXT_USER_RATING', 'Notation utilisateur :');
define('_MLDOCS_TEXT_EDIT_RESPONSE', 'Editer R&eacute;ponse');
define('_MLDOCS_TEXT_FILE_ADDED', 'Fichier Ajout&eacute; :');
define('_MLDOCS_TEXT_ACTION', 'Action :');
define('_MLDOCS_TEXT_LAST_ARCHIVES', 'Derniere Archive soumise par :');
define('_MLDOCS_TEXT_RATE_STAFF', 'Noter la r&eacute;ponse du D&eacute;partement');
define('_MLDOCS_TEXT_COMMENTS', 'Commentaires :');
define('_MLDOCS_TEXT_MY_OPEN_ARCHIVES', 'Mes Archives Ouvertes');
define('_MLDOCS_TEXT_RATE_RESPONSE', 'Noter la R&eacute;ponse ?');
define('_MLDOCS_TEXT_RESPONSE_RATING', 'Note de R&eacute;ponse :');
define('_MLDOCS_TEXT_REOPEN_ARCHIVE', 'Re-ouvrir l\'Archive ?');
define('_MLDOCS_TEXT_MORE_INFO', 'Un compl&eacute;ment d\'information est requis ?');
define('_MLDOCS_TEXT_REOPEN_REASON', 'Raison de la r&eacute;-ouverture (optionnel)');
define('_MLDOCS_TEXT_MORE_INFO2', 'Utilisez ce formulaire afin d\'ajouter un compl&eacute;ment d\'information à cette archive.');
define('_MLDOCS_TEXT_NO_DEPT', 'Pas de D&eacute;partement');
define('_MLDOCS_TEXT_NOT_EMAIL', 'Adresse Email :');
define('_MLDOCS_TEXT_LAST_REVIEWS', 'Derni&egrave;res r&eacute;visions du D&eacute;partement');
define('_MLDOCS_TEXT_SORT_ARCHIVES', 'Trier les Archives par cette colonne');
define('_MLDOCS_TEXT_ELAPSED', 'Ecoul&eacute; :');
define('_MLDOCS_TEXT_FILTERARCHIVES', 'Filtrer les Archives :');
define('_MLDOCS_TEXT_LIMIT', 'Enregistrements par page');
define('_MLDOCS_TEXT_SUBMITTEDBY', 'Soumis par :');
define('_MLDOCS_TEXT_NO_INCLUDE', 'Aucun');
define('_MLDOCS_TEXT_PRIVATE_RESPONSE', 'R&eacute;ponse priv&eacute;e :');
define('_MLDOCS_TEXT_PRIVATE', 'Priv&eacute;');
define('_MLDOCS_TEXT_CLOSE_ARCHIVE', 'Fermer l\'Archive ?');
define('_MLDOCS_TEXT_ADD_SIGNATURE', 'Ajouter une signature aux r&eacute;ponses?');
define('_MLDOCS_TEXT_LASTUPDATE', 'Derni&egrave;re mise &agrave; jour:');
define('_MLDOCS_TEXT_BATCH_ACTIONS', 'Traitement par lot :');
define('_MLDOCS_TEXT_BATCH_DEPARTMENT', 'Changer de D&eacute;partement');
define('_MLDOCS_TEXT_BATCH_PRIORITY', 'Changer de Priorit&eacute;');
define('_MLDOCS_TEXT_BATCH_STATUS', 'Changer d\'&eacute;tat');
define('_MLDOCS_TEXT_BATCH_DELETE', 'Effacer les Archives');
define('_MLDOCS_TEXT_BATCH_RESPONSE', 'R&eacute;pondre');
define('_MLDOCS_TEXT_BATCH_OWNERSHIP', 'Prendre/Assigner la Propri&eacute;t&eacute;');
define('_MLDOCS_TEXT_UPDATE_COMP', 'Mise &agrave; jour compl&eacute;t&eacute;e!');
define('_MLDOCS_TEXT_TOPICS_ADDED', 'Sujets ajout&eacute;s');
define('_MLDOCS_TEXT_DEPTS_ADDED', 'D&eacute;partements ajout&eacute;s');
define('_MLDOCS_TEXT_CLOSE_WINDOW', 'Fermer la Fen&ecirc;tre');
define('_MLDOCS_TEXT_USER_LOOKUP', 'R&eacute;solution d\'Utilisateur');
define('_MLDOCS_TEXT_EVENT', 'Ev&eacute;nements');
define('_MLDOCS_TEXT_AVAIL_FILETYPES', 'Types de fichiers valides');
define('_MLDOCS_TEXT_AVAIL_BANNETTE', ' Fichier(s) dans la bannette');
define('_MLDOCS_USER_REGISTER', 'Enregistrement d\'Utilisateur');

define('_MLDOCS_TEXT_SETDEPT', 'Choisir un D&eacute;partement :');
define('_MLDOCS_TEXT_SETPRIORITY', 'Param&egrave;trage de la priorit&eacute; de l\'Archive :');
define('_MLDOCS_TEXT_SETOWNER', 'Choisir un Propri&eacute;taire :');
define('_MLDOCS_TEXT_SETSTATUS', 'Param&egrave;trage de l\'Etat de l\'Archive:');
define('_MLDOCS_TEXT_MERGE_ARCHIVE', 'Fusionner les Archives');
define('_MLDOCS_TEXT_MERGE_TITLE', 'Entrer le N&ordm; de l\'archive avec lequel vous voulez fusionner.');
define('_MLDOCS_TEXT_EMAIL_NOTIFICATION', 'Notification d\'email:');
define('_MLDOCS_TEXT_EMAIL_NOTIFICATION_TITLE', 'Ajouter une adresse email afin d\'&ecirc;tre notifi&eacute; des mises &agrave; jour d\'archives.');
define('_MLDOCS_TEXT_RECEIVE_NOTIFICATIONS', 'Recevoir les Notifications:');
define('_MLDOCS_TEXT_EMAIL_SUPPRESS', 'les Emails sont supprim&eacute;s. Cliquez pour envoyer les notifications d\'Email.');
define('_MLDOCS_TEXT_EMAIL_NOT_SUPPRESS', 'les Emails ont &eacute;t&eacute; supprim&eacute;s. Cliquez pour les supprimer.');
define('_MLDOCS_TEXT_ARCHIVE_NOTIFICATIONS', 'Notifications des Archives');
define('_MLDOCS_TEXT_STATE', 'Etats:');
define('_MLDOCS_TEXT_BY_STATUS', 'par &eacute;tats:');
define('_MLDOCS_TEXT_BY_STATE', 'par &eacute;tats pr&eacute;d&eacute;finis :');
define('_MLDOCS_TEXT_SEARCH_OR', '-- OU --');
define('_MLDOCS_TEXT_VIEW1', 'vue classique');
define('_MLDOCS_TEXT_VIEW2', 'vue avanc&eacute;e');
define('_MLDOCS_TEXT_SAVE_SEARCH', 'Sauvegarder la recherche ?');
define('_MLDOCS_TEXT_SEARCH_NAME', 'Nom de recherche:');
define('_MLDOCS_TEXT_SAVED_SEARCHES', 'Recherches sauvegard&eacute;es pr&eacute;vues');
define('_MLDOCS_TEXT_SWITCH_TO', 'Permuter vers ');
define('_MLDOCS_TEXT_ADDITIONAL_INFO', 'Information additionnelle');

define('_MLDOCS_ROLE_NAME1', 'Gestionnaire d\'Archive');
define('_MLDOCS_ROLE_NAME2', 'Intervenant de Support');
define('_MLDOCS_ROLE_NAME3', 'Simple Consultant');
define('_MLDOCS_ROLE_DSC1', 'Peuvent faire tout et n\'importe quoi');
define('_MLDOCS_ROLE_DSC2', 'Enregistre des archives et des r&eacute;ponses, change l\'&eacute;tat ou la priorit&eacute;, et enregistre des archives pour les utilisateurs');
define('_MLDOCS_ROLE_DSC3', 'ne peut faire aucun changement');
define('_MLDOCS_ROLE_VAL1', '511');
define('_MLDOCS_ROLE_VAL2', '241');
define('_MLDOCS_ROLE_VAL3', '0');



// Archive.php - Actions
define('_MLDOCS_TEXT_SELECTED', 'Avec les archives s&eacute;lectionn&eacute;es :');
define('_MLDOCS_TEXT_ADD_RESPONSE', 'Ajouter une R&eacute;ponse');
define('_MLDOCS_TEXT_EDIT_ARCHIVE', 'Editer l\'Archive');
define('_MLDOCS_TEXT_DELETE_ARCHIVE', 'Supprimer l\'Archive');
define('_MLDOCS_TEXT_PRINT_ARCHIVE', 'Imprimer l\'Archive');
define('_MLDOCS_TEXT_UPDATE_PRIORITY', 'Mettre &agrave; jour la Priorit&eacute;');
define('_MLDOCS_TEXT_UPDATE_STATUS', 'Mettre &agrave; jour l\'&eacute;tat');

define('_MLDOCS_PIC_ALT_USER_AVATAR', 'Avatar utilisateur');

// Index.php - Auto Refresh Page vars
define('_MLDOCS_TEXT_AUTO_REFRESH0', 'Pas d\'auto rafra&icirc;chissement');
define('_MLDOCS_TEXT_AUTO_REFRESH1', 'Toutes les minutes');
define('_MLDOCS_TEXT_AUTO_REFRESH2', 'Toutes les 5 minutes');
define('_MLDOCS_TEXT_AUTO_REFRESH3', 'Toutes les 10 minutes');
define('_MLDOCS_TEXT_AUTO_REFRESH4', 'Toutes les 30 minutes');
define('_MLDOCS_AUTO_REFRESH0', 0);          // Change these to
define('_MLDOCS_AUTO_REFRESH1', 60);         // adjust the values 
define('_MLDOCS_AUTO_REFRESH2', 300);        // in the select box
define('_MLDOCS_AUTO_REFRESH3', 600);
define('_MLDOCS_AUTO_REFRESH4', 1800);

define('_MLDOCS_MENU_MAIN', 'Sommaire');
define('_MLDOCS_MENU_LOG_ARCHIVE', 'Indexer une Archive');
define('_MLDOCS_MENU_MY_PROFILE', 'Mon Profil');
define('_MLDOCS_MENU_ALL_ARCHIVES', 'Voir Toutes les Archives');
define('_MLDOCS_MENU_SEARCH', 'Rechercher');

define('_MLDOCS_SEARCH_EMAIL', 'Email');
define('_MLDOCS_SEARCH_USERNAME', 'Nom d\'Utilisateur');
define('_MLDOCS_SEARCH_UID', 'N&ordm; d\'Utilisateur');

define('_MLDOCS_BUTTON_ADDRESPONSE', 'Ajouter une R&eacute;ponse');
define('_MLDOCS_BUTTON_ADDARCHIVE', 'Classer une Archive');
define('_MLDOCS_BUTTON_EDITARCHIVE', 'Editer une Archive');
define('_MLDOCS_BUTTON_RESET', 'Nettoyer');
define('_MLDOCS_BUTTON_EDITRESPONSE', 'Mettre &agrave; jour la R&eacute;ponse');
define('_MLDOCS_BUTTON_SEARCH', 'Recherche');
define('_MLDOCS_BUTTON_LOG_USER', 'Enregistrer pour l\'utilisateur');
define('_MLDOCS_BUTTON_FIND_USER', 'Rechercher un utilisateur');
define('_MLDOCS_BUTTON_SUBMIT', 'Envoyer');
define('_MLDOCS_BUTTON_DELETE', 'Supprimer');
define('_MLDOCS_BUTTON_UPDATE', 'Mise &agrave; Jour');
define('_MLDOCS_BUTTON_UPDATE_PRIORITY', 'Mettre &agrave; jour la Priorit&eacute;');
define('_MLDOCS_BUTTON_UPDATE_STATUS', 'Mettre &agrave; jour l\'&eacute;tat');
define('_MLDOCS_BUTTON_ADD_INFO', 'Ajouter des Info');
define('_MLDOCS_BUTTON_SET', 'D&eacute;finir');
define('_MLDOCS_BUTTON_ADD_EMAIL', 'Ajouter une adresse Email');
define('_MLDOCS_BUTTON_RUN', 'Go');

define('_MLDOCS_PRIORITY1', 1);
define('_MLDOCS_PRIORITY2', 2);
define('_MLDOCS_PRIORITY3', 3);
define('_MLDOCS_PRIORITY4', 4);
define('_MLDOCS_PRIORITY5', 5);

define('_MLDOCS_TEXT_PRIORITY1', 'Tr&egrave;s Haute');
define('_MLDOCS_TEXT_PRIORITY2', 'Haute');
define('_MLDOCS_TEXT_PRIORITY3', 'Moyennement-Haute');
define('_MLDOCS_TEXT_PRIORITY4', 'Moyennement-Basse');
define('_MLDOCS_TEXT_PRIORITY5', 'Basse');

define('_MLDOCS_STATUS0', 'OUVERTE');
define('_MLDOCS_STATUS1', 'EN ATTENTE');
define('_MLDOCS_STATUS2', 'CLOSE');

define('_MLDOCS_STATE1', 'Non R&eacute;solue');
define('_MLDOCS_STATE2', 'R&eacute;solue');
define('_MLDOCS_NUM_STATE1', 1);
define('_MLDOCS_NUM_STATE2', 2);

define('_MLDOCS_RATING0', 'aucune note');
define('_MLDOCS_RATING1', 'mauvais');
define('_MLDOCS_RATING2', 'en dessous de la moyenne');
define('_MLDOCS_RATING3', 'moyen');
define('_MLDOCS_RATING4', 'au dessus de la moyenne');
define('_MLDOCS_RATING5', 'Excellent');

// Log Messages
define('_MLDOCS_LOG_ADDARCHIVE', 'Archive cr&eacute;&eacute;');
define('_MLDOCS_LOG_ADDARCHIVE_FORUSER', 'Archive cr&eacute;&eacute; pour %s par %s');
define('_MLDOCS_LOG_EDITARCHIVE', 'Edition d\'information de l\'Archive');
define('_MLDOCS_LOG_UPDATE_PRIORITY', 'Priorit&eacute; mise &agrave; jour de :%u &agrave; :%u');
define('_MLDOCS_LOG_UPDATE_STATUS', 'Etat mis &agrave; jour de  %s &agrave; %s');
define('_MLDOCS_LOG_CLAIM_OWNERSHIP', 'Propri&eacute;t&eacute; r&eacute;clam&eacute;e');
define('_MLDOCS_LOG_ASSIGN_OWNERSHIP', 'Propri&eacute;taire assign&eacute;e &agrave; %s');
define('_MLDOCS_LOG_ADDRESPONSE', 'R&eacute;ponse ajout&eacute;e');
define('_MLDOCS_LOG_USER_MOREINFO', 'Ajout d\'informations compl&eacute;mentaires');
define('_MLDOCS_LOG_EDIT_RESPONSE', 'R&eacute;ponse # %s &eacute;dit&eacute;e');
define('_MLDOCS_LOG_REOPEN_ARCHIVE', 'Archive re-ouvert');
define('_MLDOCS_LOG_CLOSE_ARCHIVE', 'Archive clos');
define('_MLDOCS_LOG_ADDRATING', 'Notation de R&eacute;ponse %u');
define('_MLDOCS_LOG_SETDEPT', 'Assign&eacute; au D&eacute;partement %s');
define('_MLDOCS_LOG_MERGEARCHIVES', 'Fusionner l\'archive %s avec %s');
define('_MLDOCS_LOG_DELETEFILE', 'Fichier %s effac&eacute;');

// Error checking for no records in DB
define('_MLDOCS_NO_ARCHIVES_ERROR', 'Pas d\'Archive trouv&eacute;');
define('_MLDOCS_NO_RESPONSES_ERROR', 'Pas de r&eacute;ponse trouv&eacute;e');
define('_MLDOCS_NO_MAILBOX_ERROR', 'Bo&icirc;te aux lettres invalide');
define('_MLDOCS_NO_FILES_ERROR', 'Pas de fichier trouv&eacute;');

define('_MLDOCS_SIG_SPACER', '<br /><br />-------------------------------<br />');
define('_MLDOCS_COMMMENTS', 'Commentaires ?');
define("_MLDOCS_ANNOUNCE_READMORE","Lire la suite...");
define("_MLDOCS_ANNOUNCE_ONECOMMENT","1 commentaire");
define("_MLDOCS_ANNOUNCE_NUMCOMMENTS","%s commentaires");
define("_MLDOCS_ARCHIVE_MD5SIGNATURE", "Cl&eacute; de Support :");


define('_MLDOCS_NO_OWNER', 'Pas de Propri&eacute;taire');
define('_MLDOCS_RESPONSE_EDIT', 'R&eacute;ponse modifi&eacute;e par %s le %s');

define('_MLDOCS_TIME_SECS', 'secondes');
define('_MLDOCS_TIME_MINS', 'minutes');
define('_MLDOCS_TIME_HOURS', 'heures');
define('_MLDOCS_TIME_DAYS', 'jours');
define('_MLDOCS_TIME_WEEKS', 'semaines');
define('_MLDOCS_TIME_YEARS', 'ann&eacute;es');

define('_MLDOCS_TIME_SEC', 'seconde');
define('_MLDOCS_TIME_MIN', 'minute');
define('_MLDOCS_TIME_HOUR', 'heure');
define('_MLDOCS_TIME_DAY', 'jour');
define('_MLDOCS_TIME_WEEK', 'semaine');
define('_MLDOCS_TIME_YEAR', 'ann&eacute;e');

define('_MLDOCS_MAILEVENT_CLASS0', '0');     // Connection message
define('_MLDOCS_MAILEVENT_CLASS1', '1');     // Parse message
define('_MLDOCS_MAILEVENT_CLASS2', '2');     // Storage message
define('_MLDOCS_MAILEVENT_CLASS3', '3');     // General message

define('_MLDOCS_MAILEVENT_DESC0', 'Ne peut se connecter au serveur.');
define('_MLDOCS_MAILEVENT_DESC1', 'Ne peut parser le message.');
define('_MLDOCS_MAILEVENT_DESC2', 'Ne peut enregistrer le message.');
define('_MLDOCS_MAILEVENT_DESC3', '');
define('_MLDOCS_MBOX_ERR_LOGIN', 'Echec de connexion au serveur de messagerie : identifiant/mot de passe invalides');
define('_MLDOCS_MBOX_INV_BOXTYPE', 'le type de bo&icirc;te aux lettres sp&eacute;cifi&eacute; n\'est pas support&eacute;');

define('_MLDOCS_MAIL_CLASS0', 'Connection');
define('_MLDOCS_MAIL_CLASS1', 'Parsing');
define('_MLDOCS_MAIL_CLASS2', 'Enregistrement');
define('_MLDOCS_MAIL_CLASS3', 'G&eacute;n&eacute;ral');

define('_MLDOCS_GROUP_PERM_DEPT', 'mldocs_dept');
define('_MLDOCS_MISMATCH_EMAIL', '%s a &eactue;t&eacute; notifi&eacute; que son message n\'a pas &eacte;t&eacute; sauvegard&eacute;. La cl&eacute; de support concorde, mais le message aurait du &ecicr;tre envoy&eacute; de %s pour le fait.');
define('_MLDOCS_MESSAGE_MERGE', 'Fusion compl&egrave;t&eacute;e avec succ&egrave;s.');
define('_MLDOCS_MESSAGE_MERGE_ERROR', 'Erreur: la fusion n\'a pas &eacute;t&eacute; compl&egrave;t&eacute;e.');
define('_MLDOCS_RESPONSE_NO_ARCHIVE', 'Aucun archive trouv&eacute; pour la r&eacute;ponse de l\'archive');
define('_MLDOCS_MESSAGE_NO_ANON', 'Le Message de %s a &eacute;t&eacute; bloqu&eacute;, la soumission d\'archive par les anonymes est d&eacute;sactiv&eacute;e');
define('_MLDOCS_MESSAGE_EMAIL_DEPT_MBOX', 'Le Message de %s a &eacute;t&eacute; bloqu&eacute;, l\'exp&eacute;diteur est une bo&icirc;te email de d&eacute;partement');

define('_MLDOCS_SIZE_BYTES', 'Bytes');
define('_MLDOCS_SIZE_KB', 'KB');
define('_MLDOCS_SIZE_MB', 'MB');
define('_MLDOCS_SIZE_GB', 'GB');
define('_MLDOCS_SIZE_TB', 'TB');

define('_MLDOCS_TEXT_USER_NOT_ACTIVATED', 'L\'utilisateur n\'a pas termin&eacute; le processus d\'activation.');

define('_MLDOCS_TEXT_ADMIN_DISABLED', '<em>[D&eacute;sactiv&eacute; par l\'Administrateur]</em>');

define('_MLDOCS_TEXT_CURRENT_NOTIFICATION', 'Methode de notification courante');
define('_MLDOCS_NOTIFY_METHOD1', 'Message Priv&eacute;');
define('_MLDOCS_NOTIFY_METHOD2', 'Email');

define('_MLDOCS_TEXT_ARCHIVE_LISTS', 'Liste d\'Archives');
define('_MLDOCS_TEXT_LIST_NAME', 'Nom de Liste');
define('_MLDOCS_TEXT_CREATE_NEW_LIST', 'Cr&eacute;ation d\'une nouvelle liste');
define('_MLDOCS_TEXT_NO_RECORDS', 'Aucun enregistrement trouv&eacute;');
define('_MLDOCS_TEXT_EDIT', 'Edition');
define('_MLDOCS_TEXT_DELETE', 'Effacement');
define('_MLDOCS_TEXT_CREATE_SAVED_SEARCH', 'Cr&eacute;ation de recherche sauvegard&eacute;');
define('_MLDOCS_MSG_ADD_ARCHIVELIST_ERR', 'Erreur : Liste de archives non cr&eacute;&eacute;e.');
define('_MLDOCS_MSG_DEL_ARCHIVELIST_ERR', 'Erreur : Liste de archives non effac&eacute;e.');
define('_MLDOCS_MSG_NO_ID', 'Erreur : Vous n\'avez pas sp&eacute;cifi&eacute; de N&ordm;.');
define('_MLDOCS_TEXT_VIEW_MORE_ARCHIVES', 'Visualisation de plus d\'archives');
define('_MLDOCS_MSG_NO_EDIT_SEARCH', 'Erreur : Vous n\&ecirce;tes pas authoris&eacute; &agrave; modifier cette recherche.');
define('_MLDOCS_MSG_NO_DEL_SEARCH', 'Erreur : vous n\'&ecirc;tes pas autoris&eacute; &agrave; effacer cette recherche.');
?>
