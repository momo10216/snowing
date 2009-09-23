<?php
/**
* @version		0.3
* @package		Joomla
* @subpackage	Module nok_snow
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined( '_JEXEC' ) or die( 'Restricted Access.' );

// Settings
$JPATH_IMAGES = $JPATH_ROOT . DS . 'media';
$SNOW_PATH = $JPATH_IMAGES . DS . 'nok_snow';
$SNOW_AMOUNT_PICS = 10;

// Get Configuration
$config = array($SNOW_AMOUNT_PICS);
for ($i=1 ; $i <= $SNOW_AMOUNT_PICS ; $i++)
{
	$file = $params->get('pic'.$i.'_file');
	if ($file == '-1')
	{
		$config[$i-1] = array('',0);
	}
	else
	{
		$config[$i-1] = array($file,intval($params->get('pic'.$i.'_amount')));
	}
}
$speed = intval($params->get('speed'));
$duration = intval($params->get('duration'));
?>

<SCRIPT LANGUAGE="JavaScript1.2">

<!-- Begin
<?php
$sumall = "";
for ($i=1 ; $i <= $SNOW_AMOUNT_PICS ; $i++)
{
	echo "var no".$i." = ".$config[$i-1][1]."; // Amount picture ".$i."\n";
	echo "var file".$i." = '".$SNOW_PATH.DS.$config[$i-1][0]."'; // File picture ".$i."\n";
	$sumall .= "no".$i."+";
}
$sumall .= "0";
?>
var no = <?php echo $sumall; ?>; // Total amount of pictures
var speed = <?php echo $speed; ?>; // Speed of falling (smaller = faster).
var duration = <?php echo $duration; ?>; // Duration of playing.
var ns4up = (document.layers) ? 1 : 0;  // Browser is Netscape Version 4.0 or higher
var ie4up = (document.all) ? 1 : 0;  // Browser is IE Version 4.0 or higher
var dx, xp, yp;    // Coordinate and position variables
var am, stx, sty;  // Amplitude and step variables
var i, doc_width = 1800, doc_height = 900;
var now = new Date();
var endtime = now.getTime() + (duration*1000);

if (ie4up)
{
	doc_width = document.body.clientWidth;
	doc_height = document.body.clientHeight;
} 
else
{
	doc_width = self.innerWidth;
	doc_height = self.innerHeight;
} 
dx = new Array();
xp = new Array();
yp = new Array();
am = new Array();
stx = new Array();
sty = new Array();
for (i = 0; i < no; i++)
{
	dx[i] = 0; // Set coordinate variables
	xp[i] = Math.random()*(doc_width-50);  // Set position variables
	yp[i] = Math.random()*doc_height;
	am[i] = Math.random()*20; // Set amplitude variables
	stx[i] = 0.02 + Math.random()/10; // Set step variables
	sty[i] = 0.7 + Math.random(); // Set step variables

	picture = file<?php echo $SNOW_AMOUNT_PICS; ?>   // Set file<?php echo $SNOW_AMOUNT_PICS; ?> as default
<?php
for ($i=$SNOW_AMOUNT_PICS-1 ; $i >= 1 ; $i--)
{
	$sumall="";
	for ($j=1 ; $j<=$i ; $j++)
	{
		$sumall .= "no".$j."+";
	}
	$sumall .= "0";	
	echo "	if (i<".$sumall.")\n";
	echo "	{    // Picture ".$i."\n";
	echo "		picture = file".$i."\n";
	echo "	}\n";
}
?>

	if (ns4up)
	{  // IE
		if (i == 0) {
			document.write("<layer name=\"dot"+ i +"\" left=\"15\" ");
			document.write("top=\"15\" visibility=\"show\"><img src=\"");
			document.write(picture + "\" border=\"0\"></layer>");
		} 
		else
		{
			document.write("<layer name=\"dot"+ i +"\" left=\"15\" ");
			document.write("top=\"15\" visibility=\"show\"><img src=\"");
			document.write(picture + "\" border=\"0\"></layer>");
		}
	}
	else
	{ // Netscape & other
		if (i == 0)
		{
			document.write("<div id=\"dot"+ i +"\" style=\"POSITION: ");
			document.write("absolute; Z-INDEX: "+ i +"; VISIBILITY: ");
			document.write("visible; TOP: 15px; LEFT: 15px;\"><img src=\"");
			document.write(picture + "\" border=\"0\"></div>");
		}
		else
		{
			document.write("<div id=\"dot"+ i +"\" style=\"POSITION: ");
			document.write("absolute; Z-INDEX: "+ i +"; VISIBILITY: ");
			document.write("visible; TOP: 15px; LEFT: 15px;\"><img src=\"");
			document.write(picture + "\" border=\"0\"></div>");
		}
	}
} 

function snowNS()
{  // Netscape main animation function
	var now = new Date();
	for (i = 0; i < no; i++)
	{  // iterate for every dot
		yp[i] += sty[i];
		if (yp[i] > doc_height-50)
		{
			xp[i] = Math.random()*(doc_width-am[i]-30);
			yp[i] = 0;
			stx[i] = 0.02 + Math.random()/10;
			sty[i] = 0.7 + Math.random();
			doc_width = self.innerWidth;
			doc_height = self.innerHeight;
		}
		dx[i] += stx[i];
		document.layers["dot"+i].top = yp[i];
		document.layers["dot"+i].left = xp[i] + am[i]*Math.sin(dx[i]);
		if ((duration != 0) && (now.getTime() >= endtime))
		{
			document.layers["dot"+i].visible = 'hidden';
		}
	}
	if ((duration == 0) || (now.getTime() < endtime))
	{
		setTimeout("snowNS()", speed);
	}
}

function snowIE()
{  // IE main animation function
	var now = new Date();
	for (i = 0; i < no; i++)
	{  // iterate for every dot
		yp[i] += sty[i];
		if (yp[i] > doc_height-50)
		{
			xp[i] = Math.random()*(doc_width-am[i]-30);
			yp[i] = 0;
			stx[i] = 0.02 + Math.random()/10;
			sty[i] = 0.7 + Math.random();
			doc_width = document.body.clientWidth;
			doc_height = document.body.clientHeight;
		}
		dx[i] += stx[i];
		document.all["dot"+i].style.pixelTop = yp[i];
		document.all["dot"+i].style.pixelLeft = xp[i] + am[i]*Math.sin(dx[i]);
		if ((duration != 0) && (now.getTime() >= endtime))
		{
			document.all["dot"+i].style.visibility = 'hidden';
		}
	}
	if ((duration == 0) || (now.getTime() < endtime))
	{
		setTimeout("snowIE()", speed);
	}
}

function snowOther()
{
	var now = new Date();
	for (i = 0; i < no; i++)
	{  // iterate for every dot
		yp[i] += sty[i];
		if (yp[i] > doc_height-50)
		{
			xp[i] = Math.random()*(doc_width-am[i]-30);
			yp[i] = 0;
			stx[i] = 0.02 + Math.random()/10;
			sty[i] = 0.7 + Math.random();
		}
		dx[i] += stx[i];
		document.getElementById("dot"+i).style.top = yp[i]+'px';
		document.getElementById("dot"+i).style.left = (xp[i] + am[i]*Math.sin(dx[i]))+'px';
		if ((duration != 0) && (now.getTime() >= endtime))
		{
			document.getElementById("dot"+i).style.visibility = 'hidden';
		}
	}
	if ((duration == 0) || (now.getTime() < endtime))
	{
		setTimeout("snowOther()", speed);
	}
}

if (ns4up)
{
	snowNS();
} 
else if (ie4up)
{
	snowIE();
}
else
{
	snowOther();
}
// End -->
</script>
