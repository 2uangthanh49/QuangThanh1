<?php
	//Change URL to ID
        function urltoID($temp, $ID) {
            $ID = 0;
            for($x = 0; $x < strlen($temp); $x++) {
                $ID = $ID + ord($temp[$x]);
            }
            return $ID;
        };
		
		//Change ID to Digit
        function idtoDigit($num, $digits) {
            while($num > 1) {
                $remainder = $num % 62;
                array_push($digits, $remainder);
                $num = $num / 62;  
            }
            return $digits;
        };
		
		//Change Digit to short URL (shorten.me/[code])
        function digittoSURL($digits, $surl) {
            $surl = "shorten.me/";
            for ($x = 0; $x < count($digits); $x++) {
                $surl = $surl . cvert($digits[$x]);
            }
            return $surl;
        };
?>