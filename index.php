<?php 
error_reporting( E_ALL & ~E_DEPRECATED); 
ini_set( 'display_errors', 1);

require'controller.php';
include 'xajax/xajax_core/xajax.inc.php';

$xajax = new xajax();
$xajax->configure('debug',false);

?>
<?php 

$gol = new gameOfLife($xajax);


$xajax->register(XAJAX_CALLABLE_OBJECT,$gol);
$xajax->processRequest();

?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="global.css">
        <?php $xajax->printJavascript(); ?>
        <script type="text/JavaScript">
            function generate() {
                x = document.getElementById('x').value;
                y = document.getElementById('y').value;
                fill = document.getElementById('fill').value;
                xajax_GameOfLife.generate(x,y,fill);
            }  
        </script>
    </head>
    <body>
        <div id="matrix"></div>
        <div id="buttons">
            <input type="text" id="x" value="20">
            <input type="text" id="y" value="20">
            <input type="text" id="fill" value="20">
            <button onclick="generate();" class="button">Generuj</button>
            <button onclick="xajax_GameOfLife.changeState();" class="button" id="c">Zmien</button>
        </div>
    </body>
</html>
