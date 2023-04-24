<?php 

/** 
* Convert colors 
* 
* Usage: 
*  color::hex2rgb("FFFFFF") 
*  color::rgb2hex(array(171,37,37)) 
* 
* @author      Tim Johannessen <root@it.dk> 
* @version     1.0.1 
*/ 

class color { 

    /** 
     * Convert HEX colorcode to an array of colors. 
     * @return      array        Returns the array of colors as array(red,green,blue) 
     */ 
     
    function hex2rgb($hexVal = "") { 
        $hexVal = eregi_replace("[^a-fA-F0-9]", "", $hexVal); 
        if (strlen($hexVal) != 6) { return "ERR: Incorrect colorcode, expecting 6 chars (a-f, 0-9)"; } 
        $arrTmp = explode(" ", chunk_split($hexVal, 2, " ")); 
        $arrTmp = array_map("hexdec", $arrTmp); 
        return array("red" => $arrTmp[0], "green" => $arrTmp[1], "blue" => $arrTmp[2]); 
    } 
     
    /** 
     * Convert RGB colors to HEX colorcode 
     * @return      string        Returns the converted colors as a 6 digit colorcode 
     */ 
    function rgb2hex($arrColors = null) { 
        if (!is_array($arrColors)) { return "ERR: Invalid input, expecting an array of colors"; } 
        if (count($arrColors) < 3) { return "ERR: Invalid input, array too small (3)"; } 
         
        array_splice($arrColors, 3); 
         
        for ($x = 0; $x < count($arrColors); $x++) { 
            if (strlen($arrColors[$x]) < 1) { 
                return "ERR: One or more empty values found, expecting array with 3 values"; 
            } 
             
            elseif (eregi("[^0-9]", $arrColors[$x])) { 
                return "ERR: One or more non-numeric values found."; 
            } 
             
            else { 
                if ((intval($arrColors[$x]) < 0) || (intval($arrColors[$x]) > 255)) { 
                    return "ERR: Range mismatch in one or more values (0-255)"; 
                } 
                 
                else { 
                    $arrColors[$x] = strtoupper(str_pad(dechex($arrColors[$x]), 2, 0, STR_PAD_LEFT)); 
                } 
            } 
        } 
         
        return implode("", $arrColors); 
    } 

} 

?> 