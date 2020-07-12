<?php
        $arg_table = $_GET;
        $chaine_post = '';
        $chaine_url = '';
        $link = '';
        $fileListToHide = file("hide.php");

        if(isset($arg_table['last'])) {
                $size_arg_table = sizeof($arg_table);
                $arg_table[$size_arg_table-1] = $arg_table['last'];
                unset($arg_table['last']);
        }
        if(empty($arg_table))
                $link = $CONFIG['DOCUMENT_ROOT'];
        else {
                while (list($key,$val) = each($arg_table)) {
                        if(!is_numeric($key)) continue;
                        $val = stripslashes($val);
                        $link .= $val.'/';

                        if( ereg("^\.\.*\.$",$val) || ereg("/",$val)) die($LANGUE['ERR_Violation']);
                        $val = rawurlencode($val);
                        $chaine_post .= "$key=$val&";
                        $chaine_url .= "$val/";
                }
                $link = $CONFIG['DOCUMENT_ROOT'].$link;
        }
        reset($arg_table);
if (isset($hack_module['GestFiles']) and $gf_isauth) gf_do_action($link); //~~<HACK_MODULE_GESTFILES>~~

        $handle_source=@opendir($link) or die($LANGUE['ERR_Config']);
        $tableaufile = '';
        $tableaudir = '';
        $tabg = '';

        while (false !== ($zone_source=readdir($handle_source))){
                if( $zone_source!=".." && $zone_source[0]!='.' ){
                        if(is_file($link.$zone_source)) $tableaufile[]=$zone_source;
                        if(is_dir($link.$zone_source)) $tableaudir[]=$zone_source;
                }
        }
        closedir($handle_source);

        $indextab=0;
        if(is_array($tableaudir)){
                iSort($tableaudir);
                $tabg[$indextab] = $tableaudir;
                $indextab++;
        }
        if(is_array($tableaufile)){
                iSort($tableaufile);
                $tabg[$indextab] = $tableaufile;
                $indextab++;
        }
//print_r($tableau);
?>
