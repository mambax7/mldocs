<?php
//$Id: modinfo.php,v 0.86 19/05/2006 20:38:22 gabybob Exp $
// modification   2009/06/04  v 0.9

define('_MI_MLDOCS_NAME', 'MLdocs Archive');
define('_MI_MLDOCS_DESC', 'Utilis&eacute; comme G.E.D pour archiver des documents de production et de bureau');

if (!defined('MLDOCS_CONSTANTS_ARCHIVE')) {
    include_once(XOOPS_ROOT_PATH.'/modules/mldocs/include/constants.php');
define('_MI_MLDOCS_PATH_UPLOADS_DFLT',   XOOPS_ROOT_PATH . '/uploads/mldocs/uploads' );
define('_MI_MLDOCS_PATH_BANNETTE_DFLT',  XOOPS_ROOT_PATH . '/uploads/mldocs/bannette');
define('_MI_MLDOCS_PATH_ARCHIVE_DFLT',    XOOPS_ROOT_PATH . '/uploads/mldocs/archives' );
define('_MI_MLDOCS_PATH_CGI_BIN_DFLT',   MLDOCS_BASE_PATH . '/cgi-bin');
define('MLDOCS_CONSTANTS_ARCHIVE', 1);
}

//Template variables
define('_MI_MLDOCS_TEMP_ADDARCHIVE', 'Mod&egrave;le pour addArchive.php');
define('_MI_MLDOCS_TEMP_SEARCH', 'Mod&egrave;le pour search.php');
define('_MI_MLDOCS_TEMP_STAFF_INDEX', 'Mod&egrave;le &eacute;quipe pour index.php');
define('_MI_MLDOCS_TEMP_STAFF_PROFILE', 'Mod&egrave;le pour profile.php');
define('_MI_MLDOCS_TEMP_STAFF_ARCHIVEDETAILS', 'Mod&egrave;le &eacute;quipe pour archive.php');
define('_MI_MLDOCS_TEMP_USER_INDEX', 'Mod&egrave;le utilisateur pour index.php');
define('_MI_MLDOCS_TEMP_USER_ARCHIVEDETAILS', 'Mod&egrave;le utilisateur pour archive.php');
define('_MI_MLDOCS_TEMP_STAFF_RESPONSE', 'Mod&egrave;le pour response.php');
define('_MI_MLDOCS_TEMP_LOOKUP', 'Mod&egrave;le pour lookup.php');
define('_MI_MLDOCS_TEMP_STAFFREVIEW', 'Mod&egrave;le pour staffReview.php');
define('_MI_MLDOCS_TEMP_EDITARCHIVE', 'Mod&egrave;le pour editArchive.php');
define('_MI_MLDOCS_TEMP_EDITRESPONSE', 'Mod&egrave;le pour editResponse.php');
define('_MI_MLDOCS_TEMP_ANNOUNCEMENT', 'Mod&egrave;le pour annonces');
define('_MI_MLDOCS_TEMP_STAFF_HEADER', 'Mod&egrave;le pour staff menu options');
define('_MI_MLDOCS_TEMP_USER_HEADER', 'Mod&egrave;le pour les options du menu utilisateur');
define('_MI_MLDOCS_TEMP_PRINT', 'Mod&egrave;le pour la page impression des archives');
define('_MI_MLDOCS_TEMP_STAFF_ALL', 'Mod&egrave;le pour l\'&eacute;quipe Voir toutes les pages');
define('_MI_MLDOCS_TEMP_STAFF_ARCHIVE_TABLE', 'Mod&egrave;le afficher les archives de l\'&eacute;quipe');
define('_MI_MLDOCS_TEMP_SETDEPT', 'Mod&egrave;le pour le param&egrave;trage de la Page de D&eacute;partement');
define('_MI_MLDOCS_TEMP_SETPRIORITY', 'Mod&egrave;le pour le param&egrave;trage de la page de priorit&eacute;s');
define('_MI_MLDOCS_TEMP_SETOWNER', 'Mod&egrave;le pour la Page du Propri&eacute;taire');
define('_MI_MLDOCS_TEMP_SETSTATUS', 'Mod&egrave;le pour la Page de Param&egrave;trage des Etats');
define('_MI_MLDOCS_TEMP_DELETE', 'Mod&egrave;le pour la Page de Batch d\'effacement de l\'Archive');
define('_MI_MLDOCS_TEMP_BATCHRESPONSE', 'Mod&egrave;le pour la Page de Batch d\'Ajout de R&eacute;ponse');
define('_MI_MLDOCS_TEMP_ANON_ADDARCHIVE', 'Mod&egrave;le pour la page d\'ajout de l\'archive des anonymes');
define('_MI_MLDOCS_TEMP_ERROR', 'Mod&egrave;le pour la page d\'erreur');
define('_MI_MLDOCS_TEMP_EDITSEARCH', 'Mod&egrave;le pour l\&eacute;dition de recherche sauvegard&eacute;e.');
define('_MI_MLDOCS_TEMP_USER_ALL', 'Template pour la vue utilisateur de toute les pages');


// Block variables
define('_MI_MLDOCS_BNAME1', 'Mes Archives Ouvertes');
define('_MI_MLDOCS_BNAME1_DESC', 'Affiche la liste des archives ouverts pour l\'utilisateur');
define('_MI_MLDOCS_BNAME2', 'Archives par D&eacute;partement');
define('_MI_MLDOCS_BNAME2_DESC', 'Affiche le nombre de archives ouverts pour chaque d&eacute;partement.');
define('_MI_MLDOCS_BNAME3', 'Derni&egrave;res Archives Vues');
define('_MI_MLDOCS_BNAME3_DESC', 'Affiche les archives qu\'un membre de l\'&eacute;quipe vient de visualiser r&eacute;cemment.');
define('_MI_MLDOCS_BNAME4', 'Actions de l\'Archive');
define('_MI_MLDOCS_BNAME4_DESC', 'Montrer toutes les action que le membre du staff peut effectuer sur l\'archive');
define('_MI_MLDOCS_BNAME5', 'Menu des actions de l\'archive');
define('_MI_MLDOCS_BNAME5_DESC', 'Montrer le menu des actions pour le syst&egrave;me d\'archive');

// Config variables
define('_MI_MLDOCS_TITLE', 'Titre du Gestionnaire');
define('_MI_MLDOCS_TITLE_DSC', 'Donnez un nom au Gestionnaire :');
define('_MI_MLDOCS_UPLOADS', 'R&eacute;pertoire de stockage des fichiers');
define('_MI_MLDOCS_UPLOADS_DSC', 'Chemin o&ugrave; seront stock&eacute;s les fichiers attach&eacute;s &agrave; une archive');
define('_MI_MLDOCS_ALLOW_UPLOAD', 'Autoriser l\'envoi de fichiers');
define('_MI_MLDOCS_ALLOW_UPLOAD_DSC', 'Autoriser les utilisateurs &agrave; ajouter un fichier &agrave; leur demande ?');
define('_MI_MLDOCS_PATH_BANNETTE', 'Chemin de la bannette');
define('_MI_MLDOCS_PATH_BANNETTE_DSC', 'position des fichiers de la bannette pour chaque user');
define('_MI_MLDOCS_URL_BANNETTE', 'adresse url de la bannette');
define('_MI_MLDOCS_URL_BANNETTE_DSC', 'adresse url des fichiers de la bannette pour chaque user');
define('_MI_MLDOCS_PATH_ARCHIVE', 'Chemin du rayonnage des archives');
define('_MI_MLDOCS_PATH_ARCHIVE_DSC', 'position des fichiers archive de production');
define('_MI_MLDOCS_PATH_CGI-BIN', 'Chemin des fichiers binaires');
define('_MI_MLDOCS_PATH_CGI-BIN_DSC', 'position des fichiers binaires (fullpath)');

define('_MI_MLDOCS_UNIQUE_ARCHIVE', 'Rendre le Code Archive comme cl&eacute; unique');
define('_MI_MLDOCS_UNIQUE_ARCHIVE_DSC', 'Permet ou non  d\'ajouter un code Archive en plusieurs exemplaires');


define('_MI_MLDOCS_UPLOAD_SIZE', 'Taille des fichiers envoy&eacute;s');
define('_MI_MLDOCS_UPLOAD_SIZE_DSC', 'Taille Maxi des fichiers envoy&eacute;s (en octets)');
define('_MI_MLDOCS_UPLOAD_WIDTH', 'Largeur Maxi');
define('_MI_MLDOCS_UPLOAD_WIDTH_DSC', 'Largeur Maxi des fichiers envoy&eacute;s (en pixels)');
define('_MI_MLDOCS_UPLOAD_HEIGHT', 'Hauteur Maxi');
define('_MI_MLDOCS_UPLOAD_HEIGHT_DSC', 'Hauteur Maxi des fichiers envoy&eacute;s (en pixels)');
define('_MI_MLDOCS_NUM_ARCHIVE_UPLOADS', 'Nombre de fichiers max au t&eacute;l&eacute;chargement');
define('_MI_MLDOCS_NUM_ARCHIVE_UPLOADS_DSC', 'Ceci est le nombre maximum de fichiers qui peuvent &ecirc;tre t&eacute;l&eacute;charg&eacute;s dans une archive &agrave; la soumission d\'une archive (n\'inclus pas le champs customis&eacute; fichier).');
define('_MI_MLDOCS_ANNOUNCEMENTS', 'Sujet des annonces');
//define('_MI_MLDOCS_ANNOUNCEMENTS_DSC', 'C\'est le sujet des annonces pour mldocs. Mettez &agrave; jour le module mldocs pour voir les nouvelles cat&eacute;gories');
define('_MI_MLDOCS_ANNOUNCEMENTS_DSC', "ceci est le sujet des actualit&eacute;s qui poussera les annonces pour mldocs. <a href='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/mldocs/install.php?op=updateTopics\", \"xoops_module_install_mldocs\",400, 300);'>Cliquez ici</a> pour mettre &agrave; jour les nouvelles cat&eacute;gories.");
define('_MI_MLDOCS_ANNOUNCEMENTS_NONE', '***D&eacute;sactiver les annonces***');
define('_MI_MLDOCS_ALLOW_REOPEN', 'Autoriser la r&eacute;ouverture d\'une Archive');
define('_MI_MLDOCS_ALLOW_REOPEN_DSC', 'Autorise les utilisateurs &agrave; r&eacute;ouvrir une Archive close ?');
define('_MI_MLDOCS_STAFF_TC', 'Nombre d\'archives affich&eacute;s pour l\'&eacute;quipe');
define('_MI_MLDOCS_STAFF_TC_DSC', 'Combien d\'archives doivent &ecirc;tre affich&eacute;s pour chaque d&eacute;partement ?');
define('_MI_MLDOCS_STAFF_ACTIONS', 'Actions du Staff');
define('_MI_MLDOCS_STAFF_ACTIONS_DSC', 'Quel style d&eacute;sirez vou appliquer aux actions du Staff ? Inligne-Style est le style par d&eacute;faut, Block-Style requiert que vous activiez le blocs des Actions du Staff.');
define('_MI_MLDOCS_ACTION1', 'Style en ligne');
define('_MI_MLDOCS_ACTION2', 'Style en Bloc');
define('_MI_MLDOCS_DEFAULT_DEPT', 'D&eacute;partement par d&eacute;faut');
define('_MI_MLDOCS_DEFAULT_DEPT_DSC', "Ceci est le d&eacute;partement s&eacute;lectionn&eacute; par d&eacute;faut dans la liste &agrave; l'ajout d\'archive. <a href='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/mldocs/install.php?op=updateDepts\", \"xoops_module_install_mldocs\",400, 300);'>Cliquez ici</a> pour mettre &agrave; jour les d&eacute;partements.");
define('_MI_MLDOCS_OVERDUE_TIME', 'Limite d\'&eacute;x&eacute;cution en temps alou&eacute; &agrave; l\'archive');
define('_MI_MLDOCS_OVERDUE_TIME_DSC', 'Ceci d&eacute;termine le temps dont dispose l\'intervenant afin de cloturer l\'archive avant qu\'il ne soit trop tard (en heures).');
define('_MI_MLDOCS_ALLOW_ANON', 'Autoriser les utilisateurs anonymes &agrave; soumettre des archives');
define('_MI_MLDOCS_ALLOW_ANON_DSC', 'Ceci aloue la cr&eacute;ation d\'archive sur votre site &agrave; tout le monde. Lorsque les utilisateurs anonymes soumettent une archive, ils sont aussitot convi&eacute;s &agrave; cr&eacute;er un compte .');
define('_MI_MLDOCS_APPLY_VISIBILITY', 'Appliquer la visibilit&eacute; du d&eacute;partement aux membres du staff ?');
define('_MI_MLDOCS_APPLY_VISIBILITY_DSC', 'Ceci d&eacute;termine si le staff est limit&eacute; &agrave; quelques d&eacute;partement que ce soit afin de soumettre des archives. si "oui" est s&eacute;lectionn&eacute;, les membres du staff seront limit&eacute; dans leurs soumission d\'archives aux d&eacute;partements qui leurs sont attribu&eacute;s par s&eacute;lection dans les groupes.');
define('_MI_MLDOCS_DISPLAY_NAME', 'Montrer le nom d\'utilisateur ou le nom r&eacute;el ?');
define('_MI_MLDOCS_DISPLAY_NAME_DSC', 'Ceci autorise l\'affichage des noms r&eacute;els en lieu est place des nom d\'utilisateur comme cela l\'est g&eacute;n&eacute;ralement (Le nom d\'utilisateur sera montr&eacute; s\'il n\'existe pas de nom r&eacute;el).');
define('_MI_MLDOCS_USERNAME', 'Nom d\'utilisateur');
define('_MI_MLDOCS_REALNAME', 'Nom r&eacute;el');

// Admin Menu variables
define('_MI_MLDOCS_MENU_BLOCKS', 'Gestion des Blocs');
define('_MI_MLDOCS_MENU_MANAGE_DEPARTMENTS', 'Gestion des D&eacute;partements');
define('_MI_MLDOCS_MENU_MANAGE_STAFF', 'Gestion des Equipes');
define('_MI_MLDOCS_MENU_MODIFY_EMLTPL', 'Modifier le mod&egrave;le des Emails');
define('_MI_MLDOCS_MENU_MODIFY_ARCHIVE_FIELDS', 'Modifier les champs de l\'Archive');
define('_MI_MLDOCS_MENU_GROUP_PERM', 'Permissions des groupes');
define('_MI_MLDOCS_MENU_ADD_STAFF', 'Ajouter une &eacute;quipe');
define('_MI_MLDOCS_MENU_MIMETYPES', 'Gestion des types Mime');
define('_MI_MLDOCS_MENU_CHECK_TABLES', 'Controle des Tables');
define('_MI_MLDOCS_MENU_MANAGE_ROLES', 'Gestion des Roles');
define('_MI_MLDOCS_MENU_MAIL_EVENTS', 'Ev&eacute;nements d\'email');
define('_MI_MLDOCS_MENU_CHECK_EMAIL', 'Controler les Emails');
define('_MI_MLDOCS_MENU_MANAGE_FILES', 'Gestion de fichiers');
define('_MI_MLDOCS_ADMIN_ABOUT', 'A propos');
define('_MI_MLDOCS_TEXT_MANAGE_STATUSES', 'Gestion des &eacute;tats');
define('_MI_MLDOCS_TEXT_MANAGE_FIELDS', 'Gestion des champs personnalis&eacute;s');
define('_MI_MLDOCS_TEXT_NOTIFICATIONS', 'Gestion de Notifications');

// Sub menus in main menu block
define('_MI_MLDOCS_PRODUCT','Indexer Archive');
define('_MI_MLDOCS_EXPLORE','Explore');
define('_MI_MLDOCS_BANNETTE','Bannette');
define('_MI_MLDOCS_OUTILS','Outils');
define('_MI_MLDOCS_TESTS','Tests');

//NOTIFICATION vars
define('_MI_MLDOCS_DEPT_NOTIFY','D&eacute;partement');
define('_MI_MLDOCS_DEPT_NOTIFYDSC', 'Options de Notification s\'appliquant &agrave; un d&eacute;partement');

define('_MI_MLDOCS_ARCHIVE_NOTIFY','Archive');
define('_MI_MLDOCS_ARCHIVE_NOTIFYDSC','Option de Notification applicable pour l\'archive actuelle');

define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFY', 'Sect : Nouvelle Archive');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYCAP', 'Me pr&eacute;venir lors de la cr&eacute;ation d\'une nouvelle archive');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYDSC', 'Recevoir une notification quand une nouvelle archive est cr&eacute;&eacute;e');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive cr&eacute;&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_NEWARCHIVE_NOTIFYTPL', 'dept_newarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFY', 'Sect : Suppression Archive');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYCAP', 'Me pr&eacute;venir lors de la suppression d\'une archive');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYDSC', 'Recevoir une notification quand une archive est supprim&eacute;e');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive supprim&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_REMOVEDARCHIVE_NOTIFYTPL', 'dept_removedarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFY', 'Sect : Modification Archive');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYCAP', 'Me pr&eacute;venir lors de la modification d\'une archive');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYDSC', 'Recevoir une notification quand une archive est modifi&eacute;e');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive modifi&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_MODIFIEDARCHIVE_NOTIFYTPL', 'dept_modifiedarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFY', 'Sect : Nouvelle r&eacute;ponse');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYCAP', 'Me pr&eacute;venir lorsqu\'une r&eacute;ponse est apport&eacute;e');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYDSC', 'Recevoir une notification quand une r&eacute;ponse est apport&eacute;e');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYSBJ', '{X_MODULE} R&eacute;ponse apport&eacute;e &agrave; l\'Archive - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_NEWRESPONSE_NOTIFYTPL', 'dept_newresponse_notify.tpl');

define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFY', 'Sect : R&eacute;ponse modifi&eacute;e');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYCAP', 'Me pr&eacute;venir lorsqu\'une r&eacute;ponse est modifi&eacute;e');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYDSC', 'Recevoir une notification quand une r&eacute;ponse est modifi&eacute;e');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYSBJ', '{X_MODULE} Archive R&eacute;ponse modifi&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_MODIFIEDRESPONSE_NOTIFYTPL', 'dept_modifiedresponse_notify.tpl');

define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFY', 'Sect : Changement d\'Etat d\'une Archive');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYCAP', 'Me pr&eacute;venir lorsque L\'Etat d\'une archive est modifi&eacute;');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYDSC', 'Recevoir une notification lorsque L\'Etat d\'une archive est modifi&eacute;');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYSBJ', '{X_MODULE} Changement d\'Etat d\'une Archive - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_CHANGEDSTATUS_NOTIFYTPL', 'dept_changedstatus_notify.tpl');

define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFY', 'Sect : Changement de Priorit&eacute; d\'une Archive');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYCAP', 'Me pr&eacute;venir lorsque la priorit&eacute; d\'une archive est modifi&eacute;e');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYDSC', 'Recevoir une notification lorsque la priorit&eacute; d\'une archive est modifi&eacute;e');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYSBJ', '{X_MODULE} Changement de priorit&eacute; d\'une Archive - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_CHANGEDPRIORITY_NOTIFYTPL', 'dept_changedpriority_notify.tpl');

define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFY', 'Sect : Nouveau responsable de l\'Archive');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYCAP', 'Me pr&eacute;venir lorsque le responsable d\'une archive est modifi&eacute;');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYDSC', 'Recevoir une notification lorsque le responsable d\'une archive est modifi&eacute;e');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYSBJ', '{X_MODULE} Responsable de Archive modifi&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_NEWOWNER_NOTIFYTPL', 'dept_newowner_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFY', 'Archive : Supprim&eacute;e');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYCAP', 'Me pr&eacute;venir lorsque ce archive est supprim&eacute;e');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYDSC', 'Recevoir une notification lorsque cette archive est supprim&eacute;e');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive Supprim&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_REMOVEDARCHIVE_NOTIFYTPL', 'archive_removedarchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFY', 'Archive : Modifi&eacute;');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYCAP', 'Me pr&eacute;venir lorsque cette archive est modifi&eacute;e');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYDSC', 'Recevoir une notification lorsque cette archive est modifi&eacute;e');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive modifi&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDARCHIVE_NOTIFYTPL', 'archive_modifiedarchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFY', 'Archive : Nouvelle R&eacute;ponse');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYCAP', 'Me pr&eacute;venir lorsqu\'une r&eacute;ponse est cr&eacute;&eacute;e pour cette archive');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYDSC', 'Recevoir une notification lorsqu\'une r&eacute;ponse est cr&eacute;&eacute;e pour cette archive');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYSBJ', '{X_MODULE} R&eacute;ponse cr&eacute;&eacute;e pour cette Archive - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_NEWRESPONSE_NOTIFYTPL', 'archive_newresponse_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFY', 'Archive : R&eacute;ponse Modifi&eacute;e');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYCAP', 'Me pr&eacute;venir lorsqu\'une r&eacute;ponse est modifi&eacute;e pour cette archive');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYDSC', 'Recevoir une notification lorsqu\'une r&eacute;ponse est modifi&eacute;e pour cette archive');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYSBJ', '{X_MODULE} R&eacute;ponse à cette Archive modifi&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_MODIFIEDRESPONSE_NOTIFYTPL', 'archive_modifiedresponse_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFY', 'Archive : Changement d\'Etat');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYCAP', 'Me pr&eacute;venir lorsque l\'Etat de cette archive est modifi&eacute;');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYDSC', 'Recevoir une notification lorsque l\'Etat de cette archive est modifi&eacute;e');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYSBJ', '{X_MODULE} Etat de Archive modifi&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_CHANGEDSTATUS_NOTIFYTPL', 'archive_changedstatus_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFY', 'Archive : Changement de Priorit&eacute;');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYCAP', 'Me pr&eacute;venir lorsque la priorit&eacute; de cette archive est modifi&eacute;e');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYDSC', 'Recevoir une notification lorsque la priorit&eacute; de cette archive est modifi&eacute;e');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYSBJ', '{X_MODULE} Priorit&eacute; d\'une Archive modifi&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_CHANGEDPRIORITY_NOTIFYTPL', 'archive_changedpriority_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFY', 'Archive : Nouveau Responsable');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYCAP', 'Me prevenir lorsque le responsable change pour cette archive');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYDSC', 'Recevoir une notification lorsque le reponsable de cette archive est chang&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYSBJ', '{X_MODULE} Changement de propr&eacute;taire de l\'Archive - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_NEWOWNER_NOTIFYTPL', 'archive_newowner_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFY', 'Archive: Nouvelle Archive');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYCAP', 'Confirmer quand une nouvelle archive est cr&eacute;&eacute;e');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYDSC', 'Recevoir une notification quand une nouvelle archive est cr&eacute;&eacute;e');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive cr&eacute;&eacute;e - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_NOTIFYTPL', 'archive_newarchive_notify.tpl');

define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFY', 'Sect : Fermeture de Archive');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYCAP', 'Me pr&eacute;venir quand une archive est close');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYDSC', 'Recevoir une notification quand une archive est close');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive close - id {ARCHIVE_ID}');
define('_MI_MLDOCS_DEPT_CLOSEARCHIVE_NOTIFYTPL', 'dept_closearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFY', 'Archive: Fermeture de l\'Archive');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYCAP', 'Confirmer quand une Archive est close');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYDSC', 'Recevoir une notification quand une Archive est close');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYSBJ', '{X_MODULE} Archive close - id {ARCHIVE_ID}');
define('_MI_MLDOCS_ARCHIVE_CLOSEARCHIVE_NOTIFYTPL', 'archive_closearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFY', 'Archive: Nouvel Utilisateur cr&eacute;&eacute; &agrave; partir d\'une soumission d\'Email');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYCAP', 'Notifie l\'Utilisateur qu\'un nouveau compte a &eacte;t&eacute; cr&eacte;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYDSC', 'Recevoir une notification quand un nouveau utilisateur est cr&eacute;&eacute; &agrave; partir d\'une soumission d\'Email');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYSBJ', '{X_MODULE} Nouvel Utilisateur cr&eacute;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_NOTIFYTPL', 'archive_new_user_byemail.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFY', 'Archive: Nouveau Utiliteur cr&eacute;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYCAP', 'Notifie l\'Utilisateur lorsqu\'un nouveau compte vient d\'&ecirc;tre cr&eacute;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYDSC', 'Recevoir une notification quand un nouveau utilisateur est cr&eacute;&eacute; par un email de sousmission (Auto Activation)');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYSBJ', '{X_MODULE} Nouveau Utilisateur cr&eacute;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT1_NOTIFYTPL', 'archive_new_user_activation1.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFY', 'Archive: Nouveau Utilisateur cr&eacute;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYCAP', 'Notifie l\'Utilisateur lorsqu\'un nouveau compte vient d\'&ecirc;tre cr&eacute;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYDSC', 'Recevoir une notification quand un nouveau utilisateur est cr&eacute;&eacute; par un email de sousmission (Requiert une Activation d\'Admin)');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYSBJ', '{X_MODULE} Nouvel Utilisateur cr&eacute;&eacute;');
define('_MI_MLDOCS_ARCHIVE_NEWUSER_ACT2_NOTIFYTPL', 'archive_new_user_activation2.tpl');

define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFY', 'Archive: Erreur d\'Email');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYCAP', 'Notifie l\'Utilisateur lorsque son email n\'est pas enregistr&eacute;');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYDSC', 'Recevoir une notification quand l\'email de soumission n\'est pas enregistr&eacute;e');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYSBJ', 'RE: {ARCHIVE_SUBJECT}');
define('_MI_MLDOCS_ARCHIVE_EMAIL_ERROR_NOTIFYTPL', 'archive_email_error.tpl');

define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFY', 'Sect : Fusion de Archives');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYCAP', 'Notifier moi lorsque des archives sont fusionn&eacute;es');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYDSC', 'recevoir une notification lorsque les archives sont fusionn&eacute;es');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYSBJ', '{X_MODULE} Archives fusionn&eacute;es');
define('_MI_MLDOCS_DEPT_MERGE_ARCHIVE_NOTIFYTPL', 'dept_mergearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFY', 'Archive: Fusion de Archives');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYCAP', 'Notifier moi lorsque des archives sont fusionn&eacute;es');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYDSC', 'Revevoir une notification lorsque des archives sont fusionn&eacute;es');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYSBJ', '{X_MODULE} Archives fusionn&eacute;es');
define('_MI_MLDOCS_ARCHIVE_MERGE_ARCHIVE_NOTIFYTPL', 'archive_mergearchive_notify.tpl');

define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFY', 'Utilisateur : Nouveau archive par Email');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYCAP', 'Confirmation de la cr&eacute;ation d\'une nouvelle archive par email');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYDSC', 'Recevoir une notification lorsqu\'un nouvelle archive est cr&eacute;&eacute;e par email');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYSBJ', 'RE: {ARCHIVE_SUBJECT} {ARCHIVE_SUPPORT_KEY}');
define('_MI_MLDOCS_ARCHIVE_NEWARCHIVE_EMAIL_NOTIFYTPL', 'archive_newarchive_byemail_notify.tpl');
// Be sure to add new mail_templates to array in admin/index.php - modifyEmlTpl()
?>
