<?php // content="text/plain; charset=utf-8"

require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_led.php');

// By default each "LED" circle has a radius of 3 pixels. Change to 5 and slghtly smaller margin
$led = new DigitalLED74(3);
$led->SetSupersampling(2);
$text =     '\xD0\xA0'.
            '鬼'.
            '龜'.
            '叫'.
            '圭'.
            '奎'.
            '揆'.
            '槻'.
            '珪'.
            '硅'.
            '窺'.
            '竅'.
            '糾'.
            '葵'.
            '規'.
            '赳';
$led->StrokeNumber($text, LEDC_RED);

?>
