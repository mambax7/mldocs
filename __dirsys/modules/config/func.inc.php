<?php
function listToHide($t){
        global $CONFIG;

        $output = array();

        while(list($k,$v) = each($t)){
                $v = trim($v);
                if(empty($v)) continue;
                if($v[0] == "<") continue;
                if($v[0] == "#") continue;
                $output[] = $v;

        }
        return $output;
}
?>
