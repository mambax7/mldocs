<?php

function CheckAuth($authFile){

        if(!file_exists($authFile)) return -1;
        
        include($authFile);
        
                /*
                echo "\$auth[\'login\'] = ".$auth['login']." <br>";
                echo "\$auth[\'password\'] = ".$auth['password']." <br>";
                echo "\$_SESSION[\'authLogin\'] = ".$_SESSION['authLogin']." <br>";
                echo "\$_SESSION[\'authPassword\'] = ".$_SESSION['authPassword']." <br>";
                */

        if(!isset($_SESSION['authLogin']) && !isset($_SESSION['authPassword'])) return 0;
        
        if(($_SESSION['authLogin'] == $auth['login']) && ($_SESSION['authPassword'] == $auth['password']))
                return 1;
        else
                return 0;

}



function PutAuth($login,$password,$authFile){

        if(!file_exists($authFile)) return -1;
        
        include($authFile);
        
        if(($login == $auth['login']) && (md5($password) == $auth['password'])) {

                $_SESSION['authLogin'] = $login;
                $_SESSION['authPassword'] = md5($password);
                
                if(CheckAuth($authFile) == 1) return 1;
        }
        
        return 0;

}


function CreateAuthFile($login,$password,$fileName){

        $buffer  = '';
        $buffer .= '<?php '."\r\n";
        $buffer .= '/*'."\r\n";
        $buffer .= '  Pour changer le login et/ou le password, il suffit de supprimer ce fichier'."\r\n";
        $buffer .= '  Et il sera automatiquement recréé avec vos nouveaux identifiants lors de'."\r\n";
        $buffer .= '  votre prochaine identification'."\r\n";
        $buffer .= '*/'."\r\n";
        $buffer .= '$auth[\'login\'] = \''.$login.'\';'."\r\n";
        $buffer .= '$auth[\'password\'] = \''.md5($password).'\';'."\r\n";
        $buffer .= '?>';

        $fp = fopen($fileName,'w');
        if(!$fp) return false;
        fwrite($fp,$buffer,strlen($buffer));
        fclose($fp);
        return true;



}

?>
