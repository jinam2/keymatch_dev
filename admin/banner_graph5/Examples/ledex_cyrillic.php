<?php // content="text/plain; charset=utf-8"

require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_led.php');

// By default each "LED" circle has a radius of 3 pixels. Change to 5 and slghtly smaller margin
$led = new DigitalLED74(3);
$led->SetSupersampling(2);
$text =     '\xD0\x90'.
            '\xD0\x91'.
            '\xD0\x92'.
            '\xD0\x93'.
            '\xD0\x94'.
            '\xD0\x95'.
            '\xD0\x81'.
            '\xD0\x97'.
            '\xD0\x98'.
            '\xD0\x99'.
            '\xD0\x9A'.
            '\xD0\x9B'.
            '\xD0\x9C'.
            '\xD0\x9D'.
            '\xD0\x9E'.
			'\xD0\x9F';
$led->StrokeNumber($text, LEDC_RED);

?>
