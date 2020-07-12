<?php


function listing($directory, $arg, $CONFIG, $LANGUE){
        global $fileListToHide;
        $tableau = array();
        static $n = 0;
        $n++;

        // ----------- Traitement de la liste des arguments! --------------

        // dans l'url si "last" existe, sa valeur est ajouté en fin de liste et est supprimé!
        if(isset($arg['last'])){
                $_last = $arg['last'];
                unset($arg['last']);
                $arg[count($arg)] = $_last;
        }


        //------------------ ouverture du repertoire ----------------------

        $directory = RemoveLastSlashes($directory);
        $fp=@opendir($directory) or die($LANGUE['ERR_Config']);
        while (false !== ($_subdir=readdir($fp))){
                if( $_subdir[0]!='.' && is_dir($directory.'/'.$_subdir) && !parseListToHide($fileListToHide,$directory.'/'.$_subdir, $CONFIG)){
                        $tableau[] = $_subdir;
                }
        }
        
        if(file_exists($CONFIG['ICO_FOLDER'].'/rep_open.png'))
                $icoDirOpen = '/rep_open.png';
        else
                $icoDirOpen = '/rep_open.gif';
        if(file_exists($CONFIG['ICO_FOLDER'].'/rep.png'))
                $icoDir = '/rep.png"';
        else
                $icoDir = '/rep.gif"';


        //--------------- appel recursif de la fonction -------------------

        if(!empty($tableau)){
                iSort($tableau);
                while(list(,$subdir) = each($tableau)){
                        $open = false;
                        if(isset($arg[$n-1]) && (stripslashes($arg[$n-1]) === $subdir)) $open = true;


                        // creation du lien '$lienplus' pour le [+]
                        $_trelativpathplus = explode('/',RemoveLastSlashes(RemoveFirstChar(SoustractPath($directory.'/'.$subdir,$CONFIG['DOCUMENT_ROOT']),'/')));
                        $lienplus = '?'.http_build_query($_trelativpathplus,'');

                        // creation du lien '$lienmoins' pour le [-]
                        $_trelativpathmoins = $_trelativpathplus;
                        if(count($_trelativpathmoins) > 0){
                                unset($_trelativpathmoins[count($_trelativpathmoins)-1]);
                                $lienmoins = http_build_query($_trelativpathmoins,'');
                                if(!empty($lienmoins)) $lienmoins = '?'.$lienmoins;
                        }

                        if(SelectAffichType($directory,'/'.$subdir,$CONFIG)) $fileToOpen = 'showtn.php';
                        else $fileToOpen = 'list.php';

                        echo '<table border="0" cellpadding="1" cellspacing="0">';
                        echo ' <tr class="lien" align="left" valign="middle">';
                        echo ' <td style="width:'.(19*($n-1)).'px"></td>';

                        // affichage des [+] et [-]
                        if (ifSubDir($directory.'/'.$subdir,$CONFIG)){
                                echo '<td style="width:13px" align="left">';

                                if ($open) echo '<a href="arbre.php'.$lienmoins.'"><img src="'.$CONFIG['ICO_FOLDER'].'/moins.gif" alt="-" title="-"></a>';
                                else       echo '<a href="arbre.php'.$lienplus.'"><img src="'.$CONFIG['ICO_FOLDER'].'/plus.gif" alt="+" title="+"></a>';
                                
                                echo ' </td>';
                        }
                        else
                                echo '<td style="width:13px"></td>';

                        echo " <td>\n";
                        
                        
                        // affichage des dossiers
                        echo ' <a href="'.$fileToOpen.$lienplus.'" target="main"';
                        echo ' onclick="open(\'arbre.php'.$lienplus.'\',\'tree\',\'\')">';

                        echo ' <img src="'.$CONFIG['ICO_FOLDER'];

                        if ($open)
                                echo $icoDirOpen.'"';
                        else
                                echo $icoDir.'"';

                        echo ' alt="Dossier" title="Dossier" class="ico">';
                        echo '&nbsp;'.$subdir;
                        echo " </a>";
                        echo " </td>\n";
                        echo " </tr>\n";
                        echo "</table>\n";


                        if($open) listing($directory.'/'.$subdir,$arg, $CONFIG, $LANGUE);
                }
        }
        $n--;

}


function ifSubDir($directory,$CONFIG){
        global $fileListToHide;
        $directory = RemoveLastSlashes($directory);
        $fp=@opendir($directory) or die($LANGUE['ERR_Config']);

        while (false !== ($_subdir=readdir($fp))){
                if( $_subdir[0]!='.' && is_dir($directory.'/'.$_subdir) && !parseListToHide($fileListToHide,$directory.'/'.$_subdir,$CONFIG) ){
                        return true;
                }
        }
        return false;
}
?>
