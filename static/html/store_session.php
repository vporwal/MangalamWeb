<?php session_start(); ?>
<?php 
	
		class SessionDataHandler {
			function addItemToSession($productId, $prodDesc) {
				$prodData = $_SESSION["prodData"];
				$count = count($prodData);
				if ($count <= 0 ) {
					$prodData = array($productId=>$_GET["productDesc"]);
				} else {
					if (!array_key_exists($productId, $prodData)) {
						$prodData[$productId] = $_GET["productDesc"];
					}
				}
				$_SESSION["prodData"] = $prodData;
			}
			
			function removeItemFromSession($productId) {
				//$productId = $_GET["productId"];
				$prodData_1 = array();
				$prodData = $_SESSION["prodData"];
				$count = count($prodData);
				if ($count > 0 ) {
					foreach($prodData as $x=>$x_value) {
						if ($productId != $x) {
							$prodData_1[$x] = $prodData[$x];
						}
					}
				}
				$_SESSION["prodData"] = $prodData_1;
			}
			
		}
	
?>


<?php
	
	$sessionHandler = new SessionDataHandler;
	$productId = $_GET["productId"];
	$action = $_GET["action"];
	if ($action == 'remove') {
		$sessionHandler->removeItemFromSession($productId);

	} else {
		/*$prodDesc = $_GET["productDesc"];
		$prodData = $_SESSION["prodData"];
		$count = count($prodData);
		if ($count <= 0 ) {
			$prodData = array($productId=>$_GET["productDesc"]);
		} else {
			if (!array_key_exists($productId, $prodData)) {
				$prodData[$productId] = $_GET["productDesc"];
			}
		}
		$_SESSION["prodData"] = $prodData;*/
		$sessionHandler->addItemToSession($productId, $prodDesc);
	}
	
?>