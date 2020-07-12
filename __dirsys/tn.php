<?php
include_once('./config.inc.php');
header("content-type: image/jpeg");

#-----------------------------------------------------

        $forbidden = false;
        $arg_table = $_GET;
        $last = $arg_table['last'];
        unset($arg_table['last']);

#-----------------------------------------------------

        $link = '';
        while (list($key,$val) = each($arg_table)) {
                if($val[0] == '.') $forbidden = true;
                $val = stripslashes($val);
                $link .= $val.'/';
        }
        reset($arg_table);
        $relatif_link = $link.stripslashes($last);
        $absolut_link = $CONFIG['DOCUMENT_ROOT'].$relatif_link;


#-----------------------------------------------------

        $png = false;

                           $handle = @imagecreatefromjpeg($absolut_link);
        if(empty($handle)) $handle = @imagecreatefrompng($absolut_link);
        if(empty($handle)) $handle = @imagecreatefromgif($absolut_link);
        if(empty($handle)) $handle = @imagecreatefromwbmp($absolut_link);
        if(empty($handle)) $handle = @imagecreatefromjpeg("img/notfoundwhite.jpg");


         if(empty($handle)) {
                $handle = imagecreate(100, 100);
                $blanc  = imagecolorallocate($handle, 255, 255, 255);
                $rouge  = imagecolorallocate($handle, 255, 0, 0);
                $noir   = imagecolorallocate($handle, 0, 0, 0);
                imagestring($handle, 5, 25, 30, $LANGUE['TN_Erreur1'], $rouge);
                imagestring($handle, 1, 2, 48, $LANGUE['TN_Erreur2'], $noir);
                imagestring($handle, 1, 2, 55, $LANGUE['TN_Erreur3'], $noir);
                $CONFIG['IMAGE_TN_COMPRESSION'] = 100;
                imagejpeg($handle,'', 100);
                imagedestroy($handle);
                exit;
        }


        $x=imagesx($handle);
        $y=imagesy($handle);
        //echo "X:$x  |  Y:$y<br />";
                                                   #       100
        if($x>$y){                                 #  |-------------|
                $max=$x;                           #  +-------------+ - -
                $min=$y;                           #  |             |   |
        }                                          #  |             |   |
        if($x<=$y){                                #  |     img     |   |100
                $max=$y;                           #  |             |   |
                $min=$x;                           #  |             |   |
        }                                          #  +-------------+ - -
        //echo "max : $max <br />";

        $qq=$max/$CONFIG['IMAGE_TN_SIZE'];

        $dest_x=$x/$qq;
        $dest_y=$y/$qq;


        if($dest_x > $x) {
                $dest_x = $x;
                $dest_y = $y;
        }

        $dest_y = ceil($dest_y);
        $dest_x = ceil($dest_x);

        if($CONFIG['GD2']) {
                $dst_img = imageCreatetruecolor($dest_x,$dest_y);
                imagefill($dst_img,0,0,imagecolorallocate($dst_img, 255, 255, 255));
                imagecopyresampled($dst_img, $handle, 0, 0, 0, 0,$dest_x, $dest_y, $x, $y);
        }
        else {
                $dst_img = imageCreate($dest_x,$dest_y);
                imagecopyresized($dst_img, $handle, 0, 0, 0, 0,$dest_x, $dest_y, $x, $y);
        }

        if($CONFIG['WRITE_TN'] && !$forbidden)
                if(!@imagejpeg($dst_img,'temp/'.checkFile($absolut_link).'.jpg', $CONFIG['IMAGE_TN_COMPRESSION']))
                        imagestring($dst_img, 1, $dest_x-4, $dest_y-8, ".", imagecolorallocate($dst_img,0,0,0));

        imagejpeg($dst_img,'', $CONFIG['IMAGE_TN_COMPRESSION']);
        imagedestroy($handle);
        imagedestroy($dst_img);

#-----------------------------------------------------
?>

