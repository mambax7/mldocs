<?php
include_once('./config.inc.php');
include_once('./showpict.inc.php');
if($CONFIG['AUTO_RESIZE'])
        $method = 'down('.$widthImg.','.$heightImg.');';
//        .'down('.$widthImg.','.$heightImg.');';
else
        $method = 'up('.$widthImg.','.$heightImg.');';
?>
<html>
<head>
<title>Slide Show</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="refresh" content="<?php echo $CONFIG['SLIDE_SHOW_INT'] ?>;URL=slideshow.php?<?php echo $queryNext ?>">
<style type="text/css">
<!--
body{overflow-y:hidden}
//-->
</style>
<link href="styles/<?php echo $CONFIG['CSS'] ?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
<!--
function loadImage(img){
        var nextpic = new Image();
        nextpic.src = img;
}

function up(imageWidth,imageHeight){
 	if (!document.all&&!document.getElementById) return

	whatcache = eval("document.images.imagetoresize");
	whatcache.style.width = imageWidth;
	whatcache.style.height = imageHeight;
}

function down(imageWidth,imageHeight){

	if (!document.all&&!document.getElementById) return

	var x2 = imageWidth;
	var y2 = imageHeight;

	whatcache = eval("document.images.imagetoresize");

	var x1 = (document.compatMode == "CSS1Compat")?document.documentElement.clientWidth : document.body.clientWidth;
	var y1 = (document.compatmode == "CSS1Compat")?document.documentElement.clientHeight : document.body.clientHeight;

	var x1 = (x1 - 20);
	var y1 = (y1 - 63);

	var ratio = (x2>y2)?(x2/x1):(y2/y1);
	var x3 = parseInt(x2/ratio);
	var y3 = parseInt(y2/ratio);

	if ((y3 > y1)) {
		var sratio = y3/y1;
		var x3 = parseInt(x3/sratio);
		var y3 = parseInt(y3/sratio);
	}
	
	if ((x3 > x1)) {
		var sratio = x3/x1;
		var x3 = parseInt(x3/sratio);
		var y3 = parseInt(y3/sratio);
	}


	if((y3 < y2) || (x3 < x2)) {
		whatcache.style.width = x3;
		whatcache.style.height = y3;
	}

}
//-->
</script>
</head>
<body class="diaporama" onresize="<?php echo $method;?>" onload="<?php echo $method;?>loadImage('<?php echo $linkNext ?>');">
   <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><a href="#" onClick="window.close()"><img name="imagetoresize" src="<?php echo $link ?>" alt="<?php echo $fileName ?>" title="<?php echo $fileName ?>" border="0" ></a></td>
  </tr>
</table>
</body>
</html>
