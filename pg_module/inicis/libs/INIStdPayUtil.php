

<?php

class INIStdPayUtil {

    function getTimestamp() {
        // timezone \xEC쓣 \xEC꽕\xEC젙\xED븯吏 \xEC븡\xEC쑝硫\xB4 getTimestapme() \xEC떎\xED뻾\xEC떆 \xEC삤瑜섍\xB0 諛쒖깮\xED븳\xEB떎.
        // php.ini \xEC뿉 timezone \xEC꽕\xEC젙\xEC씠 \xEB릺\xEC뼱 \xEC엲\xEC쑝硫\xB4 \xEC븘\xEB옒 肄붾뱶媛 \xED븘\xEC슂\xEC뾾\xEB떎. 
        // php 5.3 \xEC씠\xED썑濡쒕뒗 諛섎뱶\xEC떆 timezone \xEC꽕\xEC젙\xEC쓣 \xED빐\xEC빞\xED븯湲\xB0 \xEB븣臾몄뿉 \xEC븘\xEB옒 肄붾뱶媛 \xED븘\xEC슂\xEC뾾\xEC쓣 \xEC닔 \xEC엳\xEC쓬. \xEB굹以묒뿉 \xED솗\xEC씤 \xED썑 \xEC닔\xEC젙\xED븘\xEC슂.
        // \xEC씠\xEB땲\xEC떆\xEC뒪 \xED뵆濡쒖슦\xEC뿉\xEC꽌 timestamp 媛믪씠 以묒슂\xED븯寃\x8C \xEC궗\xEC슜\xEB릺\xEB뒗 寃껋쑝濡\x9C 蹂댁씠湲\xB0 \xEB븣臾몄뿉 \xEC젙\xED솗\xED븳 timezone \xEC꽕\xEC젙\xED썑 timestamp 媛믪씠 \xED븘\xEC슂\xED븯吏 \xEC븡\xEC쓣源\x8C \xED븿.
        
        /**********php5
        date_default_timezone_set('Asia/Seoul');
        $date = new DateTime();
        */
        
        putenv('TZ=Asia/Seoul');

        $milliseconds = round(microtime(true) * 1000);
        $tempValue1 = round($milliseconds / 1000);  //max integer \xEC옄由우닔媛 9\xEC씠誘濡\x9C \xEB뮘 3\xEC옄由щ\xA5\xBC 類\xEB떎
        $tempValue2 = round(microtime(false) * 1000); //\xEB뮘 3\xEC옄由щ\xA5\xBC \xEC\xA0\xEC옣
        switch (strlen($tempValue2)) {
            case '3':
                break;
            case '2':
                $tempValue2 = "0" . $tempValue2;
                break;
            case '1':
                $tempValue2 = "00" . $tempValue2;
                break;
            default:
                $tempValue2 = "000";
                break;
        }

        return "" . $tempValue1 . $tempValue2;
    }

    /*
      //*** \xEC쐞蹂議\xB0 諛⑹\xA7泥댄겕瑜\xBC signature \xEC깮\xEC꽦 ***

      mid, price, timestamp 3媛쒖쓽 \xED궎\xEC\x99 媛믪쓣
      key=value \xED삎\xEC떇\xEC쑝濡\x9C \xED븯\xEC뿬 '&'濡\x9C \xEC뿰寃고븳 \xED븯\xEC뿬 SHA-256 Hash濡\x9C \xEC깮\xEC꽦 \xEB맂媛\x92
      ex) mid=INIpayTest&price=819000&timestamp=2012-02-01 09:19:04.004

     * key湲곗\xA4 \xEC븣\xED뙆踰\xB3 \xEC젙\xEB젹
     * timestamp\xEB뒗 諛섎뱶\xEC떆 signature\xEC깮\xEC꽦\xEC뿉 \xEC궗\xEC슜\xED븳 timestamp 媛믪쓣 timestamp input\xEC뿉 洹몃뜲濡\x9C \xEC궗\xEC슜\xED븯\xEC뿬\xEC빞\xED븿
     */

    function makeSignature($signParam) {
        ksort($signParam);
        $string = "";
        foreach ($signParam as $key => $value) {
            $string .= "&$key=$value";
        }
        $string = substr($string, 1); // remove leading "&"

        $sign = hash( "sha256", $string);

        return $sign;
    }

    function makeHash($data, $alg) {
        // $s = hash_hmac('sha256', $data, 'secret', true);
        // return base64_encode($s);
        
        ///$ret = openssl_digest($data, $alg);
        $ret = hash($alg, $data);
        return $ret;
    }

}
?>