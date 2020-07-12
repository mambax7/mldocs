<?php
include_once('./config.inc.php');
include_once('./showpict.inc.php');

if($CONFIG['AUTO_RESIZE'])
        $method = 'down('.$widthImg.','.$heightImg.');'
        .'down('.$widthImg.','.$heightImg.');';
else
        $method = 'up('.$widthImg.','.$heightImg.');';
        
        
if($CONFIG['EXIF_READER'])
        $exifMethod = 'onmouseover="show();" onmouseout="hide();"';
else
        $exifMethod = '';
?>
<html>
<head>
<title>Affichage image</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="imagetoolbar" content="no">
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
	var y1 = (y1 - 60);

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

function fullwin(page){
        var largeur = screen.width;
        var hauteur = screen.height;
	var top=0;
	var left=0;
	window.open(page,"slideshow","top="+top+",left="+left+",width="+largeur+",height="+hauteur+",menubar=no,scrollbars=yes,statusbar=no,resizable=yes");
}

isShow = false;

function show(){
        if (<?php if($exif==false) echo "false"; else echo "true";?>){
                document.getElementById("exif").innerHTML = "<?php echo $exif; ?>";
                isShow = true;
        }
}

function hide(){
        isShow = false
}

function getPosition(p){
        x = (navigator.appName.substring(0,3) == "Net") ? p.pageX : event.x+document.body.scrollLeft;
        y = (navigator.appName.substring(0,3) == "Net") ? p.pageY : event.y+document.body.scrollTop;
        if(isShow){
                document.getElementById("exif").style.top = y+25;
                document.getElementById("exif").style.left = x-120;
                document.getElementById("exif").style.visibility = "visible";
        }
        else{
                document.getElementById("exif").style.visibility = "hidden";
                document.getElementById("exif").style.top = 0;
                document.getElementById("exif").style.left = 0;
        }
}

if(navigator.appName.substring(0,3) == "Net")
        document.captureEvents(Event.MOUSEMOVE);

document.onmousemove = getPosition;

document.write('<div id="exif" style="z-index:500;'+
                                                'position:absolute;'+
                                                'width: 250px;'+
                                                //'height: 100px;'+
                                                'border-top-width: 1px;'+
                                                'border-right-width:1px;'+
                                                'border-bottom-width:1px;'+
                                                'border-left-width:1px;'+
                                                'border-top-style:solid;'+
                                                'border-right-style:solid;'+
                                                'border-bottom-style:solid;'+
                                                'border-left-style:solid;'+
                                                'border-top-color:#EAEAEA;'+
                                                'border-right-color:#808080;'+
                                                'border-bottom-color:#808080;'+
                                                'border-left-color:#EAEAEA;'+
                                                'background-color:#D4D0C8;'+
                                                'cursor:default;'+
                                                'visibility:hidden;'+
                                                'opacity: 0.6;'+
                    /* Top delire :D   */       'filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=60, FinishOpacity=0, Style=0, StartX=0,  FinishX=10, StartY=0, FinishY=10);'+
                    /* Trop Cool :p    */       //'filter:progid:DXImageTransform.Microsoft.Shadow(color=\'black\', Direction=135, Strength=4);'+
                                                'padding:1"></div>');

//-->
</script>
</head>
<body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10" onresize="<?php echo $method;?>" onload="<?php echo $method;?>loadImage('<?php echo $linkNext ?>');" >
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="middle" align="center">
    <a href="showpict.php?<?php echo $queryNext ?>">
    <img name="imagetoresize" src="<?php echo $link ?>" border="0" alt="<?php echo $fileName ?>" title="<?php echo $fileName ?>" <?php echo $exifMethod; ?> >
    </a>
    </td>
  </tr>
  <tr>
    <td height="1">
<table border="0" align="center">
  <tr>
    <td ><a href="showpict.php?<?php echo $queryPrevious ?>"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/precedent.gif" alt="<?php echo $LANGUE['Precedent'] ?>"  title="<?php echo $LANGUE['Precedent'] ?>"  border="0"></a></td>
    <td ><a href="showpict.php?<?php echo $queryNext ?>"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/suivant.gif" alt="<?php echo $LANGUE['Suivant'] ?>"   title="<?php echo $LANGUE['Suivant'] ?>"  border="0"></a></td>
    <td >&nbsp;<img border="0" src="<?php echo $CONFIG['ICO_FOLDER'] ?>/espaceur.gif">&nbsp;</td>
    <td ><a href="#" onclick="<?php echo 'up('.$widthImg.','.$heightImg.');' ?>"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/size_up.gif" alt="<?php echo $LANGUE['Taille_reelle'] ?>" title="<?php echo $LANGUE['Taille_reelle'] ?>" border="0" ></a></td>
    <td ><a href="#" onclick="<?php echo $method ?>"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/size_down.gif" alt="<?php echo $LANGUE['Ajuste'] ?>" title="<?php echo $LANGUE['Ajuste'] ?>" border="0" ></a></td>
    <td >&nbsp;<img border="0" src="<?php echo $CONFIG['ICO_FOLDER'] ?>/espaceur.gif">&nbsp;</td>
    <?php if($CONFIG['SLIDE_SHOW']) { ?>
    <td ><a href="#" onclick="fullwin('slideshow.php?<?php echo $query ?>')"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/slideshow.gif" alt="<?php echo $LANGUE['Slide_Show'] ?>" title="<?php echo $LANGUE['Slide_Show'] ?>" border="0"></a></td>
    <td >&nbsp;<img border="0" src="<?php echo $CONFIG['ICO_FOLDER'] ?>/espaceur.gif">&nbsp;</td>
    <?php } ?>
    <td ><a href="showtn.php?<?php echo $queryDir ?>"><img src="<?php echo $CONFIG['ICO_FOLDER'] ?>/up.gif" alt="<?php echo $LANGUE['Retour'] ?>" title="<?php echo $LANGUE['Retour'] ?>" border="0"></a></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
