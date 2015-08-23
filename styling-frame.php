<?php

	try{
		switch ($_SESSION["security-level"]){
			case "0": // This code is insecure
			case "1": // This code is insecure
				$lProtectAgainstMethodTampering = FALSE;
				$lEncodeOutput = FALSE;
				break;
		   
			case "2":
			case "3":
			case "4":
			case "5": // This code is fairly secure
				$lProtectAgainstMethodTampering = TRUE;
				$lEncodeOutput = TRUE;
				break;
		};//end switch
	
		$lParameterSubmitted = FALSE;
		if (isset($_GET["page-to-frame"]) || isset($_POST["page-to-frame"]) || isset($_REQUEST["page-to-frame"])) {
			$lParameterSubmitted = TRUE;
		}// end if
	
		$lPageToFrame = "styling.php?page-title=Styling+with+Mutillidae";
		if ($lParameterSubmitted){
			if ($lProtectAgainstMethodTampering) {
				$lPageToFrame = $_GET["page-to-frame"];
			}else{
				$lPageToFrame = $_REQUEST["page-to-frame"];
			};// end if $lProtectAgainstMethodTampering
	
			if($lEncodeOutput){
				$lPageToFrame = $Encoder->encodeForHTML($lPageToFrame);
			};// end if
		};// end if $lFormSubmitted

		try {
			$LogHandler->writeToLog("Styling Frame: Framing URL " . $lPageToFrame . " based on user choice.");
		} catch (Exception $e) {
			//Do nothing. Do not interrupt page for failed log attempt.
		}//end try
		
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, $lQueryString);
	};// end try;

	try{
   		$lPathRelativeStylesheetInjectionAreaBallonTip = $BubbleHintHandler->getHint("PathRelativeStylesheetInjectionArea");
 	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try	
?>

<script type="text/javascript">
	$(function() {
		$('[PathRelativeStylesheetInjectionArea]').attr("title", "<?php echo $lPathRelativeStylesheetInjectionAreaBallonTip; ?>");
		$('[PathRelativeStylesheetInjectionArea]').balloon();
	});
</script>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-menu-wrapper.inc'); ?>
<!-- Note: To encourage IE into compatibility mode add the following
	meta tag into the HTML head section -->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<iframe src="<?php echo $lPageToFrame; ?>"
		PathRelativeStylesheetInjectionArea="1"
		seamless="seamless" frameborder="0" 
		marginheight="0px" marginwidth="0px" 
		width="100%" height="600px" 
		scrolling="auto"></iframe>
<?php
	if ($_SESSION["showhints"] == 2) {
		include_once (__ROOT__.'/includes/hints-level-2/cross-site-scripting-tutorial.inc');
	}// end if
?>
