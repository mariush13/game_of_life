<?php 
error_reporting(E_ALL);
require'controller.php';
include 'xajax/xajax_core/xajax.inc.php';

$xajax = new xajax();
//$xajax->setFlag('debug',true);
?>
<?php 

$gol = new gameOfLife(5,5,20);

$gol->generate();

function changeState(){
	global $gol;
	
	$objResponse = new xajaxResponse();
	//$objResponse->alert('sad');
	$objResponse->assign('matrix','innerHTML',$gol->changeState());
	return $objResponse;
}
$xajax->registerFunction('changeState');
$xajax->processRequest();

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="global.css">
<?php $xajax->printJavascript(); ?>
</head>
<body>
<div id="matrix"></div>

<button onclick="xajax_changeState();" value="Zmień" class="button"></button>
</body>
</html>
