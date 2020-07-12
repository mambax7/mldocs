<?php

function file_library($zone){

$FolderSize = '';
if (is_dir($zone) && file_exists($zone.'/.dirinfo')) include_once($zone.'/.dirinfo');

                if(@is_dir($zone)){
                        $info['ico'] = 'rep';
                        $info['size'] = '';//$FolderSize;
			$info['type'] = 'Dossier';
                        $info['date'] = date("d/m/Y H:i", filemtime($zone));
                        $info['ext'] = 'rep';
                        return $info;
                }

                if(@is_file($zone)){
                        $info['size'] = convertUnits(filesize($zone));

                        $zone_explode = explode('.', $zone);
                        $zone_explode_len = count($zone_explode);
                        $ext = $zone_explode[$zone_explode_len-1];

                        $ico_info = ext_library(strtolower($ext));

                        //echo "extention retour fonction : $ext<br />";

                        $info['ico'] = $ico_info['ico'];
                        $info['type'] = $ico_info['type'];
                        $info['date'] = date("d/m/Y H:i", filemtime($zone));
                        $info['ext'] = $ico_info['ext'];
                        return $info;
                }
                return $info = false;
}





function ext_library($ext) {
                $info['ico'] = 'no';
                $info['type'] = "Fichier";
                $info['ext'] = $ext;

# association des extentions
              	if($ext == "aca") { $info['ico'] = 'aca' ; $info['type'] = "Fichier Microsoft Agent"; }
              	if($ext == "ace") { $info['ico'] = 'zip' ; $info['type'] = "Fichier compressé"; }
              	if($ext == "acg") { $info['ico'] = 'aca' ; $info['type'] = "Fichier Microsoft Agent"; }
            	if($ext == "acs") { $info['ico'] = 'aca' ; $info['type'] = "Fichier Microsoft Agent"; }
	        if($ext == "aif") { $info['ico'] = 'mpg' ; $info['type'] = "Séquence AIFF"; }
		if($ext == "aifc") { $info['ico'] = 'mpg' ; $info['type'] = "Séquence AIFF"; }
		if($ext == "ani") { $info['ico'] = 'api' ; $info['type'] = "Curseur Animé"; }
		if($ext == "asa") { $info['ico'] = 'no' ; $info['type'] = "Fichier Global ASA"; }
		if($ext == "ascx") { $info['ico'] = 'ascx' ; $info['type'] = "Fichier Contrôles Utilisateur"; }
                if($ext == "asf") { $info['ico'] = 'mpg' ; $info['type'] = "Clip video format Microsoft"; }
                if($ext == "asmx") { $info['ico'] = 'asmx' ; $info['type'] = "Service Web"; }
                if($ext == "asp") { $info['ico'] = 'asp' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "aspx") { $info['ico'] = 'aspx' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "asx") { $info['ico'] = 'mpg' ; $info['type'] = "Playlist video format Microsoft"; }
		if($ext == "au") { $info['ico'] = 'mpg' ; $info['type'] = "Séquence AU"; }
                if($ext == "avi") { $info['ico'] = 'mpg' ; $info['type'] = "Clip video"; }
                if($ext == "avs") { $info['ico'] = 'avs' ; $info['type'] = "Fichier Avisynth"; }
                if($ext == "aw") { $info['ico'] = 'no' ; $info['type'] = "Fichier d'index de l'Aide Intuitive"; }
                if($ext == "axt") { $info['ico'] = 'axt' ; $info['type'] = "Fichier de distribution d'applications"; }
                if($ext == "bat") { $info['ico'] = 'bat' ; $info['type'] = "Fichier de commande MS-DOS"; }
                if($ext == "blg") { $info['ico'] = 'pmc' ; $info['type'] = "Fichier rapport BLG"; }
                if($ext == "bmp") { $info['ico'] = 'bmp' ; $info['type'] = "Image bitmap"; }
                if($ext == "bpg") { $info['ico'] = 'dpr' ; $info['type'] = "Groupe de Projet de Borland"; }
                if($ext == "bz2") { $info['ico'] = 'zip' ; $info['type'] = "Fichier compressé"; }
	        if($ext == "c") { $info['ico'] = 'txt' ; $info['type'] = "Code source C"; }
                if($ext == "c++") { $info['ico'] = 'txt' ; $info['type'] = "Code source C++"; }
                if($ext == "cab") { $info['ico'] = 'cab' ; $info['type'] = "Fichier Cabinet"; }
                if($ext == "cat") { $info['ico'] = 'cat' ; $info['type'] = "Catalogue Sécurité"; }
                if($ext == "chk") { $info['ico'] = 'dll' ; $info['type'] = "Fichier de secours"; }
                if($ext == "chm") { $info['ico'] = 'chm' ; $info['type'] = "Fichier d'aide"; }
                if($ext == "cmd") { $info['ico'] = 'bat' ; $info['type'] = "Script de Commande Windows NT"; }
                if($ext == "cnf") { $info['ico'] = 'cnf' ; $info['type'] = "SpeedDial"; }
                if($ext == "com") { $info['ico'] = 'exe' ; $info['type'] = "Application MS-DOS"; }
                if($ext == "config") { $info['ico'] = 'config' ; $info['type'] = "Fichier Configuration Web"; }
                if($ext == "cpl") { $info['ico'] = 'cpl' ; $info['type'] = "Extension panneau de controle"; }
	        if($ext == "cpp") { $info['ico'] = 'txt' ; $info['type'] = "Code source C++"; }
                if($ext == "crt") { $info['ico'] = 'crt' ; $info['type'] = "Certificat de Sécurité"; }
	        if($ext == "cs") { $info['ico'] = 'cs' ; $info['type'] = "Code source C"; }
	        if($ext == "csproj") { $info['ico'] = 'csproj' ; $info['type'] = "Code source C"; }
                if($ext == "css") { $info['ico'] = 'ini' ; $info['type'] = "Feuille de style"; }
                if($ext == "csv") { $info['ico'] = 'csv' ; $info['type'] = "Document Excel"; }
                if($ext == "cur") { $info['ico'] = 'no' ; $info['type'] = "Curseur"; }
                if($ext == "dat") { $info['ico'] = 'txt' ; $info['type'] = "Fichier DAT"; }
                if($ext == "db") { $info['ico'] = 'dll' ; $info['type'] = "Fichier Base de Donnée"; }
                if($ext == "dbp") { $info['ico'] = 'dbp' ; $info['type'] = "Base de donnée Visual Studio"; }
                if($ext == "dfm") { $info['ico'] = 'dpr' ; $info['type'] = "Fichier Delphi"; }
                if($ext == "disco") { $info['ico'] = 'disco' ; $info['type'] = "Fichier de Service Web"; }
                if($ext == "dll") { $info['ico'] = 'dll' ; $info['type'] = "Extension de l'application"; }
                if($ext == "doc") { $info['ico'] = 'doc' ; $info['type'] = "Document Word"; }
                if($ext == "dot") { $info['ico'] = 'dot' ; $info['type'] = "Document Word"; }
                if($ext == "dpk") { $info['ico'] = 'dpk' ; $info['type'] = "Fichier Delphi"; }
                if($ext == "dpr") { $info['ico'] = 'dpr' ; $info['type'] = "Fichier Delphi"; }
                if($ext == "dps") { $info['ico'] = 'dps' ; $info['type'] = "Fichier Skin DivX Player"; }
                if($ext == "drv") { $info['ico'] = 'dll' ; $info['type'] = "Pilote de péripherique"; }
                if($ext == "dtq") { $info['ico'] = 'dtq' ; $info['type'] = "Fichier requète SQL"; }
                if($ext == "dun") { $info['ico'] = 'dun' ; $info['type'] = "Paramétrage Accès Réseau"; }
                if($ext == "dvr-ms") { $info['ico'] = 'mpg' ; $info['type'] = "Enregistreur Vidéo Numérique Microsoft"; }
                if($ext == "elm") { $info['ico'] = 'prf' ; $info['type'] = "Courrier Electronique"; }
                if($ext == "eml") { $info['ico'] = 'eml' ; $info['type'] = "Fichier Message Internet E-mail"; }
                if($ext == "etp") { $info['ico'] = 'etp' ; $info['type'] = "Fichier Projet de modèle pour l'Entreprise"; }
                if($ext == "exe") { $info['ico'] = 'exe' ; $info['type'] = "Application"; }
                if($ext == "fbk") { $info['ico'] = 'fdb' ; $info['type'] = "Microsoft Business Solutions"; }
                if($ext == "fdb") { $info['ico'] = 'fdb' ; $info['type'] = "Microsoft Business Solutions"; }
                if($ext == "fla") { $info['ico'] = 'fla' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "flf") { $info['ico'] = 'fdb' ; $info['type'] = "Microsoft Business Solutions"; }
                if($ext == "fnd") { $info['ico'] = 'fnd' ; $info['type'] = "Sauvegarde Recherche de Fichier"; }
                if($ext == "fob") { $info['ico'] = 'fdb' ; $info['type'] = "Microsoft Business Solutions"; }
                if($ext == "fon") { $info['ico'] = 'ttf' ; $info['type'] = "Fichier de police"; }
                if($ext == "gif") { $info['ico'] = 'gif' ; $info['type'] = "Image au format gif"; }
	        if($ext == "gz") { $info['ico'] = 'zip' ; $info['type'] = "Fichier compressé"; }
                if($ext == "hlp") { $info['ico'] = 'hlp' ; $info['type'] = "Fichier d'aide"; }
                if($ext == "hol") { $info['ico'] = 'no' ; $info['type'] = "Fichier Microsoft Outlook"; }
                if($ext == "hta") { $info['ico'] = 'html' ; $info['type'] = "Document HTML"; }
                if($ext == "htm") { $info['ico'] = 'html' ; $info['type'] = "Document HTML"; }
                if($ext == "html") { $info['ico'] = 'html' ; $info['type'] = "Document HTML"; }
                if($ext == "htt") { $info['ico'] = 'htt' ; $info['type'] = "Document Hypertexte"; }
                if($ext == "hxc") { $info['ico'] = 'hxc' ; $info['type'] = "Fichier Aide Microsoft"; }
                if($ext == "hxi") { $info['ico'] = 'hxi' ; $info['type'] = "Fichier Aide Microsoft"; }
                if($ext == "hxk") { $info['ico'] = 'hxk' ; $info['type'] = "Fichier Aide Microsoft"; }
                if($ext == "hxs") { $info['ico'] = 'hxs' ; $info['type'] = "Fichier Aide Microsoft"; }
                if($ext == "hxt") { $info['ico'] = 'hxt' ; $info['type'] = "Fichier Aide Microsoft"; }
                if($ext == "hcm") { $info['ico'] = 'no' ; $info['type'] = "Profile ICC"; }																	
                if($ext == "ico") { $info['ico'] = 'no' ; $info['type'] = "Icône"; }
                if($ext == "inf") { $info['ico'] = 'ini' ; $info['type'] = "Information d'Installation"; }
                if($ext == "ini") { $info['ico'] = 'ini' ; $info['type'] = "Paramètre de configuration"; }
                if($ext == "iqy") { $info['ico'] = 'iqy' ; $info['type'] = "Document Excel Requète Web"; }
                if($ext == "iso") { $info['ico'] = 'iso' ; $info['type'] = "Image Iso"; }
                if($ext == "isp") { $info['ico'] = 'ins' ; $info['type'] = "Communication Internet"; }
                if($ext == "jar") { $info['ico'] = 'jar' ; $info['type'] = "Archive Java"; }
                if($ext == "jbf") { $info['ico'] = 'jbf' ; $info['type'] = "Visionneuse Paint Shop Pro"; }
	        if($ext == "jfif") { $info['ico'] = 'jpg' ; $info['type'] = "Image au format jpg"; }
	        if($ext == "jif") { $info['ico'] = 'jpg' ; $info['type'] = "Image au format jpg"; }
	        if($ext == "jpeg") { $info['ico'] = 'jpg' ; $info['type'] = "Image au format jpg"; }
	        if($ext == "jpg") { $info['ico'] = 'jpg' ; $info['type'] = "Image au format jpg"; }
                if($ext == "js") { $info['ico'] = 'js' ; $info['type'] = "Document javascript"; }
                if($ext == "jse") { $info['ico'] = 'js' ; $info['type'] = "Document javascript"; }
                if($ext == "ldf") { $info['ico'] = 'no' ; $info['type'] = "Fichier Base de Donnée"; }
                if($ext == "lex") { $info['ico'] = 'ost' ; $info['type'] = "Fichier Dictionaire"; }
                if($ext == "lnk") { $info['ico'] = 'lnk' ; $info['type'] = "Raccourcis"; }
                if($ext == "log") { $info['ico'] = 'txt' ; $info['type'] = "Journal LOG"; }
                if($ext == "m1v") { $info['ico'] = 'mpg' ; $info['type'] = " Vidéo au Format MPEG1"; }
                if($ext == "mad") { $info['ico'] = 'mad' ; $info['type'] = "Document Access"; }
                if($ext == "mat") { $info['ico'] = 'mat' ; $info['type'] = "Document Access"; }
                if($ext == "mdb") { $info['ico'] = 'mdb' ; $info['type'] = "Document Access"; }
                if($ext == "mdf") { $info['ico'] = 'no' ; $info['type'] = "Fichier Base de Donnée"; }
                if($ext == "mht") { $info['ico'] = 'mht' ; $info['type'] = "Document MHTML"; }
                if($ext == "mid") { $info['ico'] = 'mid' ; $info['type'] = "Séquence MIDI"; }
                if($ext == "midi") { $info['ico'] = 'mid' ; $info['type'] = "Séquence MIDI"; }
                if($ext == "mml") { $info['ico'] = 'mml' ; $info['type'] = "Fichier Catalogue Media"; }
                if($ext == "mmw") { $info['ico'] = 'mml' ; $info['type'] = "Fichier Catalogue Media"; }
                if($ext == "mov") { $info['ico'] = 'mov' ; $info['type'] = "Fichier video format Quick Time"; }
                if($ext == "mp2") { $info['ico'] = 'mpg' ; $info['type'] = "Fichier audio encodé en mp3"; }
                if($ext == "mp3") { $info['ico'] = 'mp3' ; $info['type'] = "Fichier audio encodé en mp3"; }
                if($ext == "mpa") { $info['ico'] = 'mpg' ; $info['type'] = "Clip video"; }
                if($ext == "mpe") { $info['ico'] = 'mpg' ; $info['type'] = "Clip video"; }
                if($ext == "mpeg") { $info['ico'] = 'mpg' ; $info['type'] = "Clip video"; }
                if($ext == "mpg") { $info['ico'] = 'mpg' ; $info['type'] = "Clip video"; }
                if($ext == "msg") { $info['ico'] = 'msg' ; $info['type'] = "Format de Message"; }
                if($ext == "msi") { $info['ico'] = 'msi' ; $info['type'] = "Microsoft Installer"; }
                if($ext == "ncd") { $info['ico'] = 'ncd' ; $info['type'] = "Nero Cover"; }
                if($ext == "nct") { $info['ico'] = 'ncd' ; $info['type'] = "Nero Cover"; }
                if($ext == "ocx") { $info['ico'] = 'dll' ; $info['type'] = "Contrôle ActiveX"; }
                if($ext == "pas") { $info['ico'] = 'no' ; $info['type'] = "Fichier Delphi"; }
                if($ext == "pdf") { $info['ico'] = 'pdf' ; $info['type'] = "Document Acrobat Reader"; }
                if($ext == "pdi") { $info['ico'] = 'pdi' ; $info['type'] = "Microsoft Visual Studio"; }
                if($ext == "php") { $info['ico'] = 'php' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "php3") { $info['ico'] = 'php' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "php4") { $info['ico'] = 'php' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "php5") { $info['ico'] = 'php' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "phps") { $info['ico'] = 'php' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "phtml") { $info['ico'] = 'php' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "pif") { $info['ico'] = 'pif' ; $info['type'] = "Raccourci Programe MS-DOS"; }
                if($ext == "png") { $info['ico'] = 'jpg' ; $info['type'] = "Image au format png"; }
                if($ext == "ppt") { $info['ico'] = 'ppt' ; $info['type'] = "Document PowerPoint"; }
                if($ext == "pps") { $info['ico'] = 'ppt' ; $info['type'] = "Document PowerPoint"; }
                if($ext == "prf") { $info['ico'] = 'prf' ; $info['type'] = "Fichier Microsoft Outlook"; }
                if($ext == "psp") { $info['ico'] = 'psp' ; $info['type'] = "Image Paint Shop Pro 7"; }
                if($ext == "pub") { $info['ico'] = 'pub' ; $info['type'] = "Document Publisher"; }
                if($ext == "ra") { $info['ico'] = 'ram' ; $info['type'] = "Fichier Real Player"; }
                if($ext == "ram") { $info['ico'] = 'ram' ; $info['type'] = "Fichier Real Player"; }
                if($ext == "rar") { $info['ico'] = 'rar' ; $info['type'] = "Fichier compressé"; }
	        if($ext == "raw") { $info['ico'] = 'bmp' ; $info['type'] = "Image au format raw"; }
                if($ext == "reg") { $info['ico'] = 'reg' ; $info['type'] = "Inscription dans le registre"; }
                if($ext == "rm") { $info['ico'] = 'ram' ; $info['type'] = "Fichier Real Player"; }
                if($ext == "rmi") { $info['ico'] = 'mid' ; $info['type'] = "Séquence MIDI"; }
                if($ext == "rpm") { $info['ico'] = 'ram' ; $info['type'] = "Fichier Real Player"; }
                if($ext == "rtf") { $info['ico'] = 'rtf' ; $info['type'] = "Document Word"; }
                if($ext == "scr") { $info['ico'] = 'exe' ; $info['type'] = "Screen Saver"; }
                if($ext == "shtm") { $info['ico'] = 'html' ; $info['type'] = "Document HTML"; }
                if($ext == "shtml") { $info['ico'] = 'html' ; $info['type'] = "Document HTML"; }
	        if($ext == "sln") { $info['ico'] = 'sln' ; $info['type'] = "Fichier Visual Studio"; }
		if($ext == "snd") { $info['ico'] = 'mpg' ; $info['type'] = "Séquence AU"; }
		if($ext == "spl") { $info['ico'] = 'fla' ; $info['type'] = "Objet Flash"; }
	        if($ext == "sql") { $info['ico'] = 'sql' ; $info['type'] = "Fichier SQL"; }
	        if($ext == "suo") { $info['ico'] = 'suo' ; $info['type'] = "Fichier Visual Studio"; }
		if($ext == "swf") { $info['ico'] = 'fla' ; $info['type'] = "Objet Flash"; }
                if($ext == "sys") { $info['ico'] = 'dll' ; $info['type'] = "Extension de programme"; }
	        if($ext == "tar") { $info['ico'] = 'zip' ; $info['type'] = "Fichier compressé"; }
                if($ext == "tgz") { $info['ico'] = 'zip' ; $info['type'] = "Fichier compressé"; }
	        if($ext == "theme") { $info['ico'] = 'no' ; $info['type'] = "Fichier Theme Windows"; }
	        if($ext == "tif") { $info['ico'] = 'tiff' ; $info['type'] = "Image au format tif"; }
	        if($ext == "tiff") { $info['ico'] = 'tiff' ; $info['type'] = "Image au format tif"; }
	        if($ext == "torrent") { $info['ico'] = 'no' ; $info['type'] = "Fichier Torrent"; }
                if($ext == "ttf") { $info['ico'] = 'ttf' ; $info['type'] = "Police True Type"; }
                if($ext == "txt") { $info['ico'] = 'txt' ; $info['type'] = "Document texte"; }
                if($ext == "url") { $info['ico'] = 'url' ; $info['type'] = "Raccourci Internet"; }
	        if($ext == "vb") { $info['ico'] = 'vb' ; $info['type'] = "Visual Basic"; }
	        if($ext == "vbproj") { $info['ico'] = 'vbproj' ; $info['type'] = "Visual Basic"; }
	        if($ext == "vbs") { $info['ico'] = 'vbs' ; $info['type'] = "Script Visual Basic"; }
	        if($ext == "vcf") { $info['ico'] = 'vcf' ; $info['type'] = "Fichier vCard"; }
	        if($ext == "vsmacros") { $info['ico'] = 'vsmacros' ; $info['type'] = "Fichier Visual Studio"; }
                if($ext == "vxd") { $info['ico'] = 'dll' ; $info['type'] = "Pilote de péripherique virtuel"; }
                if($ext == "wab") { $info['ico'] = 'wab' ; $info['type'] = "Fichier Carnet d'Adresse"; }
                if($ext == "wav") { $info['ico'] = 'mpg' ; $info['type'] = "Fichier audio"; }
                if($ext == "wax") { $info['ico'] = 'mpg' ; $info['type'] = "Fichier audio format Microsoft"; }
                if($ext == "wm") { $info['ico'] = 'mpg' ; $info['type'] = "Fichier audio/vidéo format Microsoft"; }
                if($ext == "wma") { $info['ico'] = 'mpg' ; $info['type'] = "Fichier audio format Microsoft"; }
	        if($ext == "wmf") { $info['ico'] = 'bmp' ; $info['type'] = "Image au format WMF"; }
                if($ext == "wmv") { $info['ico'] = 'mpg' ; $info['type'] = "Fichier video format Microsoft"; }
                if($ext == "wmx") { $info['ico'] = 'mpg' ; $info['type'] = "Playlist video format Microsoft"; }
                if($ext == "wpl") { $info['ico'] = 'mpg' ; $info['type'] = "Playlist Windows Media"; }
                if($ext == "wri") { $info['ico'] = 'wri' ; $info['type'] = "Document texte"; }
	        if($ext == "wsc") { $info['ico'] = 'wsc' ; $info['type'] = "Script Windows"; }
	        if($ext == "wsf") { $info['ico'] = 'vbs' ; $info['type'] = "Script Windows"; }
                if($ext == "wvx") { $info['ico'] = 'mpg' ; $info['type'] = "Playlist video format Microsoft"; }
                if($ext == "xdr") { $info['ico'] = 'xml' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "xla") { $info['ico'] = 'xla' ; $info['type'] = "Document Excel Add-In"; }
                if($ext == "xls") { $info['ico'] = 'xls' ; $info['type'] = "Document Excel"; }
                if($ext == "xml") { $info['ico'] = 'xml' ; $info['type'] = "Document internet dynamique"; }
	        if($ext == "xsd") { $info['ico'] = 'xsd' ; $info['type'] = "Format natif de The GIMP"; }
                if($ext == "xsl") { $info['ico'] = 'xsl' ; $info['type'] = "Document internet dynamique"; }
                if($ext == "xslt") { $info['ico'] = 'xslt' ; $info['type'] = "Tranformation XSL"; }
                if($ext == "xsn") { $info['ico'] = 'xsn' ; $info['type'] = "Fichier Microsoft Outlook"; }
	        if($ext == "z") { $info['ico'] = 'zip' ; $info['type'] = "Fichier compressé"; }
	        if($ext == "zip") { $info['ico'] = 'zip' ; $info['type'] = "Fichier compressé"; }
	        if($ext == "zup") { $info['ico'] = 'fdb' ; $info['type'] = "Microsoft Business Solutions"; }

                #if($ext == "extension.du.fichier") { $info['ico'] = 'nom.du.fichier.icone' ; $info['type'] = "information.sur.le.type.de.fichier"; }

                return $info;
}





function exif($file) {
                $err = FALSE;
                $string_output = '';
                $exif_array = @exif_read_data($file) or $err = TRUE;
                if(empty($exif_array['Model'])) $err = TRUE;

                if(!$err) {

                        if(!isset($exif_array['Flash'])) $exif_array['Flash'] = 'Inconnu';
                        else if($exif_array['Flash']==0) $exif_array['Flash'] = 'd&eacute;sactiv&eacute;';
                        else if($exif_array['Flash']==1) $exif_array['Flash'] = 'activ&eacute;';
                        else if($exif_array['Flash']==5) $exif_array['Flash'] = 'activ&eacute; sans mesure de lumière';
                        else if($exif_array['Flash']==7) $exif_array['Flash'] = 'activ&eacute; avec mesure de lumière';
                        else $exif_array['Flash'] = 'Inconnu';

                        if(!isset($exif_array['LightSource'])) $exif_array['LightSource'] = 'Inconnu';
                        else if($exif_array['LightSource']==0) $exif_array['LightSource'] = 'ind&eacute;termin&eacute;';
                        else if($exif_array['LightSource']==1) $exif_array['LightSource'] = 'lumière du jour';
                        else if($exif_array['LightSource']==2) $exif_array['LightSource'] = 'fluorescent';
                        else if($exif_array['LightSource']==3) $exif_array['LightSource'] = 'tungstène';
                        else if($exif_array['LightSource']==10) $exif_array['LightSource'] = 'flash';
                        else if($exif_array['LightSource']==17) $exif_array['LightSource'] = 'lampe standard A';
                        else if($exif_array['LightSource']==18) $exif_array['LightSource'] = 'lampe standard B';
                        else if($exif_array['LightSource']==19) $exif_array['LightSource'] = 'lampe standard C';
                        else if($exif_array['LightSource']==20) $exif_array['LightSource'] = 'D55';
                        else if($exif_array['LightSource']==21) $exif_array['LightSource'] = 'D65';
                        else if($exif_array['LightSource']==22) $exif_array['LightSource'] = 'D75';
                        else $exif_array['LightSource'] = 'Inconnu';

                        if(!isset($exif_array['ExposureProgram'])) $exif_array['ExposureProgram'] = 'Inconnu';
                        else if($exif_array['ExposureProgram']==1) $exif_array['ExposureProgram'] = 'contrôle manuel';
                        else if($exif_array['ExposureProgram']==2) $exif_array['ExposureProgram'] = 'programme normal';
                        else if($exif_array['ExposureProgram']==3) $exif_array['ExposureProgram'] = 'priorit&eacute; ouverture';
                        else if($exif_array['ExposureProgram']==4) $exif_array['ExposureProgram'] = 'priorit&eacute; vitesse';
                        else if($exif_array['ExposureProgram']==5) $exif_array['ExposureProgram'] = 'programme créatif (programme lent)';
                        else if($exif_array['ExposureProgram']==6) $exif_array['ExposureProgram'] = 'programme action(programme vitesse &eacute;lev&eacute;e)';
                        else if($exif_array['ExposureProgram']==7) $exif_array['ExposureProgram'] = 'mode portrait';
                        else if($exif_array['ExposureProgram']==8) $exif_array['ExposureProgram'] = 'mode paysage';
                        else $exif_array['ExposureProgram'] = 'Inconnu';

                        if(!isset($exif_array['MeteringMode'])) $exif_array['MeteringMode'] = 'Inconnu';
                        else if($exif_array['MeteringMode']==1) $exif_array['MeteringMode'] = 'ind&eacute;termin&eacute;';
                        else if($exif_array['MeteringMode']==2) $exif_array['MeteringMode'] = 'moyenne';
                        else if($exif_array['MeteringMode']==3) $exif_array['MeteringMode'] = 'moyenne pond&eacute;r&eacute;e au centre';
                        else if($exif_array['MeteringMode']==4) $exif_array['MeteringMode'] = 'spot';
                        else if($exif_array['MeteringMode']==5) $exif_array['MeteringMode'] = 'multi-spot';
                        else if($exif_array['MeteringMode']==6) $exif_array['MeteringMode'] = 'multi-segment';
                        else if($exif_array['MeteringMode']==7) $exif_array['MeteringMode'] = 'partielle';
                        else $exif_array['MeteringMode'] = 'Inconnu';

                        if(!empty($exif_array['FileName'])) $string_output .= '<b>Nom du fichier : </b>'.$exif_array['FileName'].'<br />';
                        if(!empty($exif_array['DateTime'])) $string_output .= '<b>Date de la photo : </b>'.$exif_array['DateTimeOriginal'].'<br />';
                        if(!empty($exif_array['ImageDescription'])) $string_output .= '<b>Description : </b>'.$exif_array['ImageDescription'].'<br />';
                        if(!empty($exif_array['Make'])) $string_output .= '<b>Marque : </b>'.$exif_array['Make'].'<br />';
                        if(!empty($exif_array['Model'])) $string_output .= '<b>Appareil : </b>'.$exif_array['Model'].'<br />';
                        if(!empty($exif_array['ExifImageWidth'])) $string_output .= '<b>Taille de l\'image : </b>'.$exif_array['ExifImageWidth'].'*'.$exif_array['ExifImageLength'].'<br />';
                        if(!empty($exif_array['ExposureTime'])) $string_output .= '<b>Temps d\'exposition : </b>'.$exif_array['ExposureTime'].'sec<br />';
                        if(!empty($exif_array['FocalLength'])) $string_output .= '<b>Distance focale : </b>'.$exif_array['FocalLength'].'mm<br />';
                        if(!empty($exif_array['FocalLengthIn35mmFilm'])) $string_output .= '<b>Distance focale en 24-36: </b>'.$exif_array['FocalLengthIn35mmFilm'].'mm<br />';
                        if(!empty($exif_array['FNumber'])) $string_output .= '<b>Ouverture f'.$exif_array['FNumber'].'</b><br />';
                        if(!empty($exif_array['ISOSpeedRatings'])) $string_output .= '<b>ISO : </b>'.$exif_array['ISOSpeedRatings'].'<br />';
                        if(!empty($exif_array['Flash'])) $string_output .= '<b>Flash '.$exif_array['Flash'].'</b><br />';
                        if(!empty($exif_array['ExposureProgram'])) $string_output .= '<b>Programme d\'exposition : </b>'.$exif_array['ExposureProgram'].'<br />';
                        if(!empty($exif_array['LightSource'])) $string_output .= '<b>Type lumiere : </b>'.$exif_array['LightSource'].'<br />';
                        if(!empty($exif_array['MeteringMode'])) $string_output .= '<b>Mode exposition : </b>'.$exif_array['MeteringMode'].'<br />';

                }
                else $string_output = FALSE;
                return $string_output;
}



function iSort(&$input) {

                if(!is_array($input)) return false;

                $sort = '';
                $output = '';

                for($i = 0; $i < count($input); $i++) $sort[$i] = strtolower($input[$i]);

                asort($sort);
                reset($sort);

                while(list($key,$val) = each($sort)) $output[] = $input[$key];
                $input =  $output;
                return true;
}



function resize_text($texte) {
        if (strlen($texte)>12){
                $texte = substr($texte, 0, 12);
                $texte = $texte."...";
        }
        return $texte;
}


function convertUnits($size) {
        $kb = 1024;        // Kilobyte
        $mb = 1024 * $kb;  // Megabyte
        $gb = 1024 * $mb;  // Gigabyte
        $tb = 1024 * $gb;  // Terabyte
        //if($size==0) return "0 octets";
        if($size < $kb) {
                return $size." octets";
        }
        else if($size < $mb) {
                return round($size/$kb,1)."Ko";
        } 
        else if($size < $gb) {
                return round($size/$mb,2)."Mo";
        }
        else if($size < $tb) {
                return round($size/$gb,2)."Go";
        }
        else{
                return round($size/$tb,2)."To";
        }
}

function RecursiveSize($dir){
        $h = opendir($dir);
        if(!isset($size)) $size = 0;
        while(FALSE !== ($fp = readdir($h))) {
                $link = $dir.'/'.$fp;
                if($fp != '.' && $fp != '..'){
                        if(is_dir($link)) $size+=RecursiveSize($link);
                        else $size+=filesize($link);
                }
        }
        closedir($h);
        return $size;  // in bytes
}


function SelectAffichType($link,$zone_source,$CONFIG){
#  $zone_source : nom du repertoir a scanner
#  $info[] : information sur le repertoir a scanner (donc un repertoir)
#  $link : path du repertoir courant ouvert.
#  $scan_rep : path du repertoir a scanner.
#  $scan_rep_ask : nom du fichier ou repertoir en cours de scan.
        $show_tn_val = FALSE;
        if($CONFIG['IMAGE_TN'] && is_dir($link.$zone_source)) {
                $scan_rep = AddLastSlashes($link).$zone_source;                    // creation du path du repertoir a scanner
                $handle_scan_rep = opendir($scan_rep);             // ouverture du path du repertoir a scanner

                while (false !== ($scan_rep_ask = readdir($handle_scan_rep))){   // boucle de recherche de fichier
                        if($scan_rep_ask[0] != "."){
                                //echo $scan_rep.$scan_rep_ask;
                                $info_ask = file_library(AddLastSlashes($scan_rep).$scan_rep_ask);
                                //echo AddLastSlashes($scan_rep).$scan_rep_ask;
                                //print_r($info_ask);
                                if(($info_ask['ico']=='jpg' && $CONFIG['IMAGE_JPG']) || ($info_ask['ico']=='bmp' && $CONFIG['IMAGE_BMP']) || ($info_ask['ico']=='gif' && $CONFIG['IMAGE_GIF'])) {
                                        $show_tn_val = TRUE;
                                        break;
                                }
                        }
                }
        }
        return $show_tn_val;
}

function RemoveLastSlashes($d){
        if(empty($d)) return false;
        if(($d[strlen($d)-1] == "\\") || ($d[strlen($d)-1] == "/")) $d = substr($d,0 , -1);
        return $d;
}

function AddLastSlashes($d){
        if(empty($d)) return false;
        if(!(($d[strlen($d)-1] == "\\") || ($d[strlen($d)-1] == "/"))) $d = $d.'/';
        return $d;
}

function AddFirstSlashes($d){
        if(empty($d)) return '/';
        if(!(($d[0] == "\\") || ($d[0] == "/"))) $d = '/'.$d;
        return $d;
}

function RemoveFirstChar($d,$c){
        if(empty($d)) return false;
        if($d[0] == $c) $d = substr($d,1);
        return $d;
}

if(!function_exists('fnmatch')){
function fnmatch($pattern, $file){
        for($i=0; $i<strlen($pattern); $i++) {
                if($pattern[$i] == "*") {
                        for($c=$i; $c<max(strlen($pattern), strlen($file)); $c++) {
                                if(fnmatch(substr($pattern, $i+1), substr($file, $c))) {
                                        return true;
                                }
                        }
                        return false;
                }
                if($pattern[$i] == "[") {
                        $letter_set = array();
                        for($c=$i+1; $c<strlen($pattern); $c++) {
                                if($pattern[$c] != "]") {
                                        array_push($letter_set, $pattern[$c]);
                                }
                                else break;
                        }
                        foreach ($letter_set as $letter) {
                                if(my_fnmatch($letter.substr($pattern, $c+1), substr($file, $i))) {
                                        return true;
                                }
                        }
                        return false;
                }
                if($pattern[$i] == "?") {
                        continue;
                }
                if($pattern[$i] != $file[$i]) {
                        return false;
                }
        }
        return true;
}
}

function FindRecursiv($dir,$match,$casesensitive){
        global $CONFIG;
        $fileListToHide = file("../hide.php");
        $dir = RemoveLastSlashes($dir);
        $h = opendir($dir);
        static $tab = array();
        while(FALSE !== ($fp = readdir($h))) {
                $link = $dir.'/'.$fp;
                if($fp[0] != '.' && $fp != '..' && !parseListToHide($fileListToHide,$fp,$CONFIG)){
                        if($casesensitive) { $match = strtolower($match); $fp = strtolower($fp);}
                        if (fnmatch($match, $fp)) {
                                  $tab[] = $link;
                        }
                        if(is_dir($link)) FindRecursiv($link,$match,$casesensitive);
                }
        }
        closedir($h);
        return $tab;
}
 function String2Array($str){
        $l = strlen($str);
        for($i=0;$i<$l;$i++){
                $t[$i] = $str[$i];
        }
        return $t;
}

function Array2String($t){
        $l = sizeof($t)+1;
        for($i=0;$i<$l;$i++){
                $str .= $t[$i];
        }
        return $str;
}

function Win2UnixShlash($s){
        return strtr($s, "\\", "/");
}

function EncodeForUrl($uri) {
        $parts = explode('/', $uri);
        for ($i = 0; $i < count($parts); $i++) {
                $parts[$i] = rawurlencode($parts[$i]);
        }
        return implode('/', $parts);
}

if (!function_exists('http_build_query')){

function http_build_query(&$a,$pref,$f='',$idx=''){
        $ret = '';
        foreach ($a as $i => $j){
                if ($idx != '') $i = $idx."[$i]";
                if (is_array($j)) $ret .= http_build_query($j,'',$f,$i);
                else{
                        $j=rawurlencode(stripslashes($j));
                        if (is_int($i)) $ret .= "$f$pref$i=$j";
                        else $ret .= "$f$i=$j";
                }
                $f='&';
        }
        return $ret;
}
}

function ListModules(){
        global $CONFIG,$LANGUE;
        $tListModules = array();
        $dir =  Win2UnixShlash(AddLastSlashes(dirname(__FILE__))).'modules/';

        $handle = opendir($dir);
        while (false !== ($file = readdir($handle))) {
                if(is_file($dir.$file)){
                        $file_explode = explode('.', $file);
                        $file_explode_len = count($file_explode);
                        $ext = $file_explode[$file_explode_len-1];
                        if ($ext == "php" || $ext == "php3" || $ext == "php4" || $ext == "php5") {
                                $tListModules[] = $file;
                        }
                }
        }
        closedir($handle);
        iSort($tListModules);
        
        $isAuth = false;
        if(file_exists('modules/auth/func.inc.php') && CheckAuth('modules/auth/auth.inc.php')==1) $isAuth = true;


        for($i=0;$i<count($tListModules);$i++){
                $AdminModule = true;
                $EnableModule = true;

                include_once($dir.$tListModules[$i]);

                if(!$EnableModule) continue;

                if(!(!$isAuth && $AdminModule)) echo "<tr><td class=\"titre1\"><a href=\"".'modules/'.$tListModules[$i]."\" target=\"main\"><img src=\"".'modules/'.$ModuleIco."\" alt=\"".$ModuleTitle."\" title=\"".$ModuleTitle."\" class=\"ico\"> ".$ModuleTitle."</a></td></tr>\n";

        }
}

function parseListToHide($t,$path,$CONFIG){
        $output = array();

        while(list($k,$v) = each($t)){
                $v = trim($v);
                if(empty($v)) continue;
                if($v[0] == "<") continue;
                if($v[0] == "#") continue;
                $output[] = $v;

        }

        $SiCeciEstVraisAlorsLeFichierEstCache = false;
        while(list($klth,$vlth) = each($output)){
                $comparonsca = strtolower($CONFIG['DOCUMENT_ROOT'].RemoveFirstChar(RemoveLastSlashes(Win2UnixShlash($vlth)),'/'));
                $avecca = strtolower(Win2UnixShlash($path));
                if($comparonsca == $avecca) {
                        $SiCeciEstVraisAlorsLeFichierEstCache = true;
                        break;
                }
        }
        reset($output);
        return ($SiCeciEstVraisAlorsLeFichierEstCache);
}


// cette fonction prends un chemin 'sale' et le nettoie!
// il retourne un chemin canonique.
function resolvePath($path){
        $t = explode('/',RemoveLastSlashes($path));
        $unix = false;
        if($t[0]===''){
                $unix = true;
        }
        while(list($i,)=each($t)) if(trim($t[$i])==='' || $t[$i] === '.') unset($t[$i]);
        reset($t);
        delDblPlot($t);
        if($unix) return '/'.implode('/',$t);
        else return implode('/',$t);

}


// fonction interne! non utile
// sert pour resolvePath()
function delDblPlot(&$t){
        $t = array_values($t);
        while(list($i,)=each($t)) if($t[$i] == '..'){
                unset($t[$i-1]);
                unset($t[$i]);
                delDblPlot($t);
                return false;
        }
}

// prends un fichier et generer une clee md5 pseudo unique
function checkFile($f){
        if(!file_exists($f)) return false;

        //return md5_file($f);
        return md5($f." ".sizeof($f));
}

// prends un tableau (en general $_GET) et le transforme en chemin (url)
// retourne un tableau a 3 index :
// - path               : contient le chemin complet
// - last               : contient le dernier element du chemin
// - pathwithoutlast    : contient le chemin sans le dernier element
function makePath($get){
        $buff = array();
        $out = array();
        $i =0;
        if(!isset($get)) return false;
        while(list($k,) = each($get)){
                if( ereg("^\.\.*\.$",$get[$k]) || ereg("/",$get[$k])) return false;
                $buff[] = rawurldecode($get[$k]);
                //echo $get[$k]." // ".$buff[$i++]."<br>";
        }
        $out['path'] = '/';
        $out['last'] = '/';
        $out['pathwithoutlast'] = '/';
        for($i=0;$i<count($buff);$i++){
                $out['path'] .= $buff[$i].'/';
                if($i<(count($buff)-1))
                        $out['pathwithoutlast'] .= $buff[$i].'/';
        }
        if(isset($buff[count($buff)-1]))
                $out['last'] = $buff[count($buff)-1];
        return $out;
}


// cette fonction soustrait $path2 à $path1 ( $path1 - $path2 )
// et retourne la difference sous forme d'un chemin relatif pour
// aller a $path1 en partant de $path2
function SoustractPath($path1,$path2){

        $out = '/';
        $t1 = explode('/',RemoveFirstChar(RemoveLastSlashes($path1),'/'));
        $t2 = explode('/',RemoveFirstChar(RemoveLastSlashes(Win2UnixShlash($path2)),'/'));

        $s1 = count($t1);
        $s2 = count($t2);

        $sMax = ($s1>$s2)?$s1:$s2;
        $sMin = ($s1<=$s2)?$s1:$s2;

        for($i=0;$i<$sMin;$i++){
                if($t1[$i] == $t2[$i]){
                        unset($t1[$i]);
                        unset($t2[$i]);
                }
        }
        $t1 = array_values($t1);
        $t2 = array_values($t2);
        
        $s1 = count($t1);
        $s2 = count($t2);

        for($i=0;$i<$s2;$i++) $out .= '../';
        for($i=0;$i<$s1;$i++) $out .= $t1[$i].'/';
        return $out;
}




// depreciated

function RemovShash($d){
        $debug = debug_backtrace();
        echo '<br /><b>Notice</b>:  Function Depreciated: '.$debug[0]['function'].'() ! Use RemoveLastSlashes(String $path) in <b>'.$debug[0]['file'].'</b> on line <b>'.$debug[0]['line'].'</b><br />';
        return RemoveLastSlashes($d);
}

function AddShash($d){
        $debug = debug_backtrace();
        echo '<br /><b>Notice</b>:  Function Depreciated: '.$debug[0]['function'].'() ! Use AddLastSlashes(String $path) in <b>'.$debug[0]['file'].'</b> on line <b>'.$debug[0]['line'].'</b><br />';
        return AddLastSlashes($d);
}

function AddFirstShash($d){
        $debug = debug_backtrace();
        echo '<br /><b>Notice</b>:  Function Depreciated: '.$debug[0]['function'].'() ! Use AddFirstSlashes(String $path) in <b>'.$debug[0]['file'].'</b> on line <b>'.$debug[0]['line'].'</b><br />';
        return AddFirstSlashes($d);
}

function SetRelativPath($rm, $abs){
        $debug = debug_backtrace();
        echo '<br /><b>Warning</b>:  Function Modified: '.$debug[0]['function'].'() ! Use SoustractPath(String $path1,String $path2) in <b>'.$debug[0]['file'].'</b> on line <b>'.$debug[0]['line'].'</b><br />';
        return SoustractPath($rm,$abs);
}

function TranslateUri($uri){
        $debug = debug_backtrace();
        echo '<br /><b>Notice</b>:  Function Depreciated: '.$debug[0]['function'].'() ! Use EncodeForUrl(String $path) in <b>'.$debug[0]['file'].'</b> on line <b>'.$debug[0]['line'].'</b><br />';
        return EncodeForUrl($uri);
}

/**
	* Calcul recursif du nombre de fichiers et dossiers contenus dans un dossier
	* @Private
	* @Param string $DIR		Chemin du fichier
	* @Param int $CORE		Ajout d'un nom de dossier au chemin
	* @return string		retourne en littéral X fichier(s) et Y dossier(s).
*/

$FOL = 0;
$FIL = 0;

function CountF($DIR, $CORE){
    global $FOL;
    global $FIL;
		if (is_dir($DIR)){
    if ($ODIR = opendir($DIR)){
        while ($FILE = readdir($ODIR)){
            if ( ($FILE != ".") && ($FILE != "..") && ($FILE != ".dirsys") && ($FILE != "Thumbs.db") && ($FILE != ".dirinfo")){
                $TMP = $DIR."/".$FILE ;
                if (is_dir($TMP)){
            $FOL++;
                    CountF($TMP, $FILE) ;}
                else{$FIL++;}}}}
if ($FIL <= "1") $rFIL = $FIL." fichier, ";
else $rFIL = $FIL." fichiers, ";
if ($FOL <= "1") $rFOL = $FOL." dossier";
else $rFOL = $FOL." dossiers.";
$rtn = $rFIL." ".$rFOL;
return $rtn;}}

/**
	* Convertion de la date de modification du fichier en Français
	* @Private
	* @Param string $pass		Chemin du fichier
	* @echo				Affiche directement "jour en littéral jour en chiffre mois et année" exemple "lundi 5 mars 2005".
*/

function datefixFRENCH($pass)
{
  $day = date ("w", filemtime($pass));
  $day = str_replace("1", "Lundi", $day);
  $day = str_replace("2", "Mardi", $day);
  $day = str_replace("3", "Mercredi", $day);
  $day = str_replace("4", "Jeudi", $day);
  $day = str_replace("5", "Vendredi", $day);
  $day = str_replace("6", "Samedi", $day);
  $day = str_replace("0", "Dimanche", $day);
  $month = date ("m", filemtime($pass));
  $month = str_replace("01", "Janvier", $month);
  $month = str_replace("02", "F&eacute;vrier", $month);
  $month = str_replace("03", "Mars", $month);
  $month = str_replace("04", "Avril", $month);
  $month = str_replace("05", "Mai", $month);
  $month = str_replace("06", "Juin", $month);
  $month = str_replace("07", "Juillet", $month);
  $month = str_replace("08", "Ao&ucirc;t", $month);
  $month = str_replace("09", "Septembre", $month);
  $month = str_replace("10", "Octobre", $month);
  $month = str_replace("11", "Novembre", $month);
  $month = str_replace("12", "D&eacute;cembre", $month);
  $middle = date ("d", filemtime($pass));
  $end = date ("Y, H:i", filemtime($pass));
  echo $day.' '.$middle.' '.$month.' '.$end;
}

/**
	* Création et lecture d'un fichier .dirinfo contenant le nombre de fichiers et dossiers ainsi que la taille d'un dossier
	* @Private
	* @Param string $pass		Chemin du fichier
	* @Param int $return		Afficher ou non le résultat: 1 pour afficher 0 pour ne pas afficher.
	* @return string		Renvoi deux lignes d'un tableau avec le contenu des dossiers.
*/

function DirInfoTime ($pass,$return) {
	$day=7;  	// 30 jours soit un mois.
	$hour=24; 	// 24 heures soit un jour. 
	$min=60;  	// 60 minutes soit une heure.
	$sec=60; 	// 60 secondes soit une minute.
	$comp=$day*$hour*$min*$sec;
	if (!is_file($pass)){
	if (!file_exists($pass."/.dirinfo") || ((time() - filemtime($pass."/.dirinfo")) >= $comp)) {
		$fp=@fopen($pass."/.dirinfo","w");
		$countF = CountF($pass, "/");
		$sizeF = convertUnits(RecursiveSize($pass));
                $buff = '<?php'."\r\n";		
                $buff .= '$FolderCount = \'' . $countF . '\';'."\r\n";
                $buff .= '$FolderSize = \'' . $sizeF . '\';'."\r\n";
                $buff .= '?>';	
                fwrite($fp,$buff);
		@fclose($fp);
	}
	if ($return == '1') {
	include($pass."/.dirinfo");
  $contents = "<tr><td>Contenu: $FolderCount</td></tr><tr><td>Taille: $FolderSize";
	return $contents;}
}}

?>
