<?php
    /*$LGD_RESPCODE               = $HTTP_POST_VARS["LGD_RESPCODE"];
    $LGD_RESPMSG                = $HTTP_POST_VARS["LGD_RESPMSG"];        	                        
	$LGD_PAYKEY                = $HTTP_POST_VARS["LGD_PAYKEY"];        	     
	*/
	
	$LGD_RESPCODE               = $_POST["LGD_RESPCODE"];
    $LGD_RESPMSG                = $_POST["LGD_RESPMSG"];        	                        
	$LGD_PAYKEY                = $_POST["LGD_PAYKEY"];  
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<script type="text/javascript">
		function setLGDResult() {
			try {
				var RESP = document.getElementById("LGD_RESPCODE").value;
				var MSG = document.getElementById("LGD_RESPMSG").value;
				var LGD_PAYKEY = document.getElementById("LGD_PAYKEY").value;
				opener.payment_return(RESP, MSG, LGD_PAYKEY);
			} catch (e) {
				alert(e.message);
			}
			window.close();
		}
		
	</script>
</head>
<body onload="setLGDResult()">
	<form method="post" name="LGD_RETURNINFO" id="LGD_RETURNINFO">
		<input type="hidden" id="LGD_RESPCODE" name="LGD_RESPCODE" value='<?= $LGD_RESPCODE ?>' />
		<input type="hidden" id="LGD_RESPMSG" name="LGD_RESPMSG" value='<?= $LGD_RESPMSG ?>' />
		<input type="hidden" id="LGD_PAYKEY" name="LGD_PAYKEY" value='<?= $LGD_PAYKEY ?>' />
	</form>
</body>
</html>
