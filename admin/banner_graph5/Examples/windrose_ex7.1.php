<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_windrose.php');



// Data can be specified using both ordinal index of the axis
// as well as the direction label.
$data = array(
    2 => array(1,15,7.5,2),
    5 => array(1,1,1.5,2),
    7 => array(1,2,10,3,2),
    8 => array(2,3,1,3,1,2),
    );

// First create a new windrose graph with a title
$graph = new WindroseGraph(590,580);
$graph->title->Set('Japanese locale');
#$graph->title->SetFont(FF_VERDANA,FS_BOLD,14);
$graph->title->SetColor('navy');

// Create the free windrose plot.
$wp = new WindrosePlot($data);
$wp->SetType(WINDROSE_TYPE8);

// Add some "arbitrary" text to the center
$wp->scale->SetZeroLabel("SOx\n8%%");

// Localize the compass direction labels into Japanese
// Note: The labels for data must now also match the exact
// string for the compass directions.
//
// 竊γ\xE3\xE3\xE6씝
// N竊γ\xE3\xE5뙒\xE6씝
// 竊\xAE\xE3\xE3\xE3\xE5뙒
// N竊룔\xE3\xE5뙒蜈\xBF
// 竊룔\xE3\xE3蜈\xBF
// S竊룔\xE3\xE5뜔蜈\xBF
// 竊녈\xE3\xE3\xE5뜔
// S竊γ\xE3\xE5뜔\xE6씝
$jp_CompassLbl = array('\xE6씝','','\xE5뙒\xE6씝','','\xE5뙒','','\xE5뙒蜈\xBF','',
 					   '蜈\xBF','','\xE5뜔蜈\xBF','','\xE5뜔','','\xE5뜔\xE6씝','');
$wp->SetCompassLabels($jp_CompassLbl);
#$wp->SetFont(FF_MINCHO,FS_NORMAL,15);

// Localize the "Calm" text into Swedish and make the circle
// slightly bigger than default
$jp_calmtext = '亮녕찋';
$wp->legend->SetCircleText($jp_calmtext);
$wp->legend->SetCircleRadius(20);
#$wp->legend->SetCFont(FF_MINCHO,FS_NORMAL,10);
$wp->legend->SetMargin(5,0);
$wp->SetPos(0.5, 0.5);

// Adjust the displayed ranges
$ranges = array(1,3,5,8,12,19,29);
$wp->SetRanges($ranges);

// Set the scale to always have max value of 30
$wp->scale->Set(30,10);
#$wp->scale->SetFont(FF_VERA,FS_NORMAL,12);

// Finally add it to the graph and send back to client
$graph->Add($wp);
$graph->Stroke();
?>

