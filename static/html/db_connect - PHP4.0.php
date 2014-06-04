
<?php 
	include("JSON.php");
	
	function getConnetion() {
		$conn = odbc_connect("DRIVER={MySQL ODBC 3.51 Driver};Server=localhost;Database=online_trade", "online_trade", "online_trade");
		return $conn;
	}
	
	function closeConnection($conn) {
		odbc_close($conn);
	}
	
	class Category {
		var $id = 0;
		var $displayName = '';
		var $groups = array();
		
		function addGroup($group) {
			array_push($this->groups, $group);
		}
	}
	
	class Group {
		 var $id = 0;
		 var $displayName = '';
		 var $template_type = '';
		 var $image_path = '';
		 var $image = '';
		 var $shortDesc = '';
		 var $description = '';
		 var $infoLink = '';
		 var $products = array();
		
		 function addProduct($product) {
			array_push($this->products, $product);
		}
	}
	
	class Product {
		 var $group_id;
		 var $product_id;
		 var $product_name;
		 var $prod_desc;
		 var $img_name;
		 var $img_path;
		 var $prod_short_desc;
		 var $template_type;
	}
	
	class DbHandler {
		 function getGroupProducts($groupId) {
			$conn = getConnetion();
		
			// Check connection
			//if (mysqli_connect_errno($conn)) {
			//	echo "Failed to connect to MySQL: " . mysqli_connect_error();
			//}
			$query = "SELECT prod_id, prod_name, prod_desc, img, img_path, prod_short_desc FROM product WHERE group_id =" . $groupId;
			$resultSet_1 = odbc_exec($conn, $query);
			$prodArray = array();
			if ($resultSet_1) {
				while(odbc_fetch_row($resultSet_1)) {
					$product = new Product;
					$product->product_id = odbc_result($resultSet_1,"prod_id");
					$product->product_name = odbc_result($resultSet_1,"prod_name");;
					$product->prod_desc = odbc_result($resultSet_1,"prod_desc");
					$product->img_name = odbc_result($resultSet_1,"img");
					$product->img_path = odbc_result($resultSet_1,"img_path");
					$product->prod_short_desc = odbc_result($resultSet_1,"prod_short_desc");
					array_push($prodArray, $product);
				}
			}
			closeConnection($conn);
			$objRows["groupProducts"] = $prodArray;
			$objRows["groupId"] = $groupId;
			$json = new Services_JSON();
			return $json->encode($objRows);
		}
		
		 function populateCategories() {
			 
			//if (isset($_SESSION["navigationLinks"])) {
			//	$objRows = $_SESSION["navigationLinks"];
			//} else {
				$conn = getConnetion();
		
				// Check connection
				// if (mysqli_connect_errno($conn)) {
					// echo "Failed to connect to MySQL: " . mysqli_connect_error();
				// }
				$query = "select a.group_id, a.group_name, a.group_desc, a.group_img, a.img_path, a.short_desc, b.cat_id, b.cat_name, a.template_type, a.infolink from groups a, category b where a.cat_id = b.cat_id and a.status_id = 1 and b.status_id = 1 order by a.cat_id, b.seqNb asc, a.seqNb asc ";
				$resultSet = odbc_exec($conn, $query);

				$array_ = array();
				$categoryId = 0;
				$category = new Category;
				$array_ = array();
				while($record = odbc_fetch_array($resultSet)) {
					if ($categoryId == $record["cat_id"]) {
						$Group = new Group;
						$Group->displayName = $record["group_name"];
						$Group->id = $record["group_id"];
						$Group->template_type = $record["template_type"];
						$Group->image_path = $record["img_path"];
						$Group->image = $record["group_img"];
						$Group->shortDesc = $record["short_desc"];
						$Group->description = $record["group_desc"];
						$Group->infoLink = $record["infolink"];
						$category->addgroup($Group);
					} else {
						unset($category);
						$category = new Category;
						$category->id = $record["cat_id"];
						$category->displayName = $record["cat_name"];
						
						$Group = new Group;
						$Group->displayName = $record["group_name"];
						$Group->id = $record["group_id"];
						$Group->template_type = $record["template_type"];
						$Group->image_path = $record["img_path"];
						$Group->image = $record["group_img"];
						$Group->shortDesc = $record["short_desc"];
						$Group->description = $record["group_desc"];
						$Group->infoLink = $record["infolink"];
						$category->addgroup($Group);
						$categoryId = $record["cat_id"];
						array_push($array_, &$category);
					}				
				}
				closeConnection($conn);
				$objRows["prodCategory"] = $array_;
			//}
			
			$_SESSION["navigationLinks"] = $objRows; 
			$json = new Services_JSON();
			return $json->encode($objRows);
			
		}
		
		 function searchProducts($searchTxt) {
			$searchQuery = "SELECT a.prod_id, a.prod_name, a.prod_desc, a.img, a.img_path, prod_short_desc, b.group_id, b.group_name, b.template_type, a.template_type tType FROM product a, groups b WHERE (prod_name like '%". $searchTxt ."%' or prod_desc like '%". $searchTxt ."%' or prod_short_desc like '%". $searchTxt ."%') and a.group_id = b.group_id order by b.group_name, a.prod_name";
			$conn = getConnetion();
		
			// Check connection
			// if (mysqli_connect_errno($conn)) {
				// echo "Failed to connect to MySQL: " . mysqli_connect_error();
			// }

			$resultSet_1 = odbc_exec($conn, $searchQuery);
			$groupMap = array();
			$finalArray = array();
			if ($resultSet_1) {
				while($record = odbc_fetch_array($resultSet_1)) {
					if (isset($groupMap) && isset($groupMap[" ".$record["group_id"]." "])) {
					} else {
						unset($groupIns);
						$groupIns = new Group;
						$groupIns->displayName = $record["group_name"];
						$groupIns->id = $record["group_id"];
						$groupIns->template_type = $record["template_type"];
						
						if (isset($groupMap)) {
							$newArr = array(" ".$record["group_id"]." "=>&$groupIns);
							$groupMap = array_merge($groupMap, $newArr);
						} else {
							$groupMap = array(" ".$record["group_id"]." "=>&$groupIns);
						}
					}
					unset($product);
					$product = new Product;
					$product->product_id = $record["prod_id"];
					$product->product_name = $record["prod_name"];;
					$product->prod_desc = $record["prod_desc"];
					$product->img_name = $record["img"];
					$product->img_path = $record["img_path"];
					$product->prod_short_desc = $record["prod_short_desc"];
					$product->template_type = $record["tType"];
					$groupIns->addProduct(&$product);
				}
			}
			closeConnection($conn);
			foreach($groupMap as $key=>$value) {
				array_push($finalArray, $value);
			}
			$objRows["searchProducts"] = $finalArray;
			$json = new Services_JSON();
			return $json->encode($objRows);
		}
		
		 function getGroupAllProds($groupId) {
			$searchQuery = "SELECT a.prod_id, a.prod_name, a.prod_desc, a.img, a.img_path, prod_short_desc, b.group_id, b.group_name, b.template_type, a.template_type tType FROM product a, groups b WHERE a.group_id = b.group_id and a.group_id = ". $groupId ." order by b.group_name, a.prod_name";
			
			//$conn = mysqli_connect("roofingsolutions.co.in", "online_trade", "online_trade", "online_trade"); 
			$conn = getConnetion();
		
			// Check connection
			// if (mysqli_connect_errno($conn)) {
				// echo "Failed to connect to MySQL: " . mysqli_connect_error();
			// }

			$resultSet_1 = odbc_exec($conn, $searchQuery);
			$groupMap = array();
			$finalArray = array();
			if ($resultSet_1) {
				
				while($record = odbc_fetch_array($resultSet_1)) {
					if (isset($groupMap) && isset($groupMap[" ".$record["group_id"]." "])) {
					} else {
						unset($groupIns);
						$groupIns = new Group;
						$groupIns->displayName = $record["group_name"];
						$groupIns->id = $record["group_id"];
						$groupIns->template_type = $record["template_type"];
						
						if (isset($groupMap)) {
							$newArr = array(" ".$record["group_id"]." "=>&$groupIns);
							$groupMap = array_merge($groupMap, $newArr);
						} else {
							$groupMap = array(" ".$record["group_id"]." "=>&$groupIns);
						}
					}
					unset($product);
					$product = new Product;
					$product->product_id = $record["prod_id"];
					$product->product_name = $record["prod_name"];;
					$product->prod_desc = $record["prod_desc"];
					$product->img_name = $record["img"];
					$product->img_path = $record["img_path"];
					$product->prod_short_desc = $record["prod_short_desc"];
					$product->template_type = $record["tType"];
					$groupIns->addProduct(&$product);
				}
			}
			//var_dump($groupMap);
			foreach($groupMap as $key=>$value) {
				array_push($finalArray, $value);
			}
			
			closeConnection($conn);
			
			$objRows["groupProducts"] = $finalArray;
			$json = new Services_JSON();
			return $json->encode($objRows);
		}

		 function getProdDetails($prodId, $groupId) {
			$searchQuery = "SELECT a.prod_id as prod_id, a.prod_name, a.prod_desc, a.img, a.img_path, a.prod_short_desc, a.group_id, a.template_type FROM product a WHERE a.prod_id = " . $prodId . " and a.group_id = " . $groupId;
			//$conn = odbc_connect("roofingsolutions.co.in", "online_trade", "online_trade"); 
			$conn = getConnetion();
			// Check connection
			//if (mysqli_connect_errno($conn)) {
			//	echo "Failed to connect to MySQL: " . mysqli_connect_error();
			//}
			
			$product = new Product;
			$resultSet_1 = odbc_exec($conn, $searchQuery);
			if ($resultSet_1) {
				while(odbc_fetch_row($resultSet_1)) {
					$product->product_id = odbc_result($resultSet_1, "prod_id");
					$product->product_name = odbc_result($resultSet_1, "prod_name"); //$record["prod_name"];;
					$product->prod_desc = odbc_result($resultSet_1, "prod_desc"); //$record["prod_desc"];
					$product->img_name = odbc_result($resultSet_1, "img"); //$record["img"];
					$product->img_path = odbc_result($resultSet_1, "img_path"); //$record["img_path"];
					$product->prod_short_desc = odbc_result($resultSet_1, "prod_short_desc"); //$record["prod_short_desc"];
					$product->template_type = odbc_result($resultSet_1, "template_type"); //$record["template_type"];
					break;
				}
			}
			$objRows["prodDetails"] = $product;
			closeConnection($conn);
			$json = new Services_JSON();
			return $json->encode($objRows);
		}
		
		 function selAllProducts() {
			$searchQuery = "SELECT a.prod_id, a.prod_name, a.img, a.img_path, a.group_id, a.template_type FROM product a";
			$conn = getConnetion();
		
			// Check connection
			// if (mysqli_connect_errno($conn)) {
				// echo "Failed to connect to MySQL: " . mysqli_connect_error();
			// }
			
			$product = new Product;
			$resultSet_1 = odbc_exec($conn, $searchQuery);
			if ($resultSet_1) {
				while(odbc_fetch_row($resultSet_1)) {
					$product->product_id = odbc_result($resultSet_1,"prod_id");
					$product->product_name = odbc_result($resultSet_1,"prod_name");;
					$product->img_name = odbc_result($resultSet_1,"img");
					$product->img_path = odbc_result($resultSet_1,"img_path");
					$product->template_type = odbc_result($resultSet_1,"template_type");
					$product->group_id = odbc_result($resultSet_1,"group_id");
					break;
				}
			}
			closeConnection($conn);
			$objRows["product"] = $product;
			$json = new Services_JSON();
			return $json->encode($objRows);
		}
	}
?>

<?php
	
	$handle = new DbHandler;
	$requestType = $_GET['requestType'];
	
	if ($requestType == 'navLinks' || $requestType == 'prodGroups') {
		echo $handle->populateCategories();
	} else if ($requestType == 'search') {
		$searchTxt = $_GET["searchTxt"];
		echo $handle->searchProducts($searchTxt);
	} else if ($requestType == 'prodDetails') {
		$prodId = $_GET["prodId"];
		$groupId = $_GET["groupId"];
		echo $handle->getProdDetails($prodId, $groupId);
	} else if ($requestType == 'getGroupAllProds') {
		$catId = $_GET["categoryId"];
		$groupId = $_GET["groupId"];
		echo $handle->getGroupAllProds($groupId);
	}
	
?>