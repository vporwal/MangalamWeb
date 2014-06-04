
<?php 

	function getConnetion() {
		$conn = mysqli_connect("localhost", "root", "3mQTFVmXJFfE8XLd", "online_trade"); 
		return $conn;
	}
	
	function closeConnection($conn) {}

	class Category {
		public $id = 0;
		public $displayName = '';
		public $groups = array();
		
		public function addGroup($group) {
			array_push($this->groups, $group);
		}
	}
	
	class Group {
		public $id = 0;
		public $displayName = '';
		public $template_type = '';
		public $image_path = '';
		public $image = '';
		public $shortDesc = '';
		public $description = '';
		public $infoLink = '';
		public $products = array();
		
		public function addProduct($product) {
			array_push($this->products, $product);
		}
	}
	
	class Product {
		public $group_id;
		public $product_id;
		public $product_name;
		public $prod_desc;
		public $img_name;
		public $img_path;
		public $prod_short_desc;
		public $template_type;
	}
	
	class DbHandler {
		public function getGroupProducts($groupId) {
			$conn = getConnetion();
		
			// Check connection
			if (mysqli_connect_errno($conn)) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			$query = "SELECT prod_id, prod_name, prod_desc, img, img_path, prod_short_desc FROM product WHERE group_id =" . $groupId;
			$resultSet_1 = mysqli_query($conn, $query);
			$prodArray = array();
			if ($resultSet_1) {
				while($record = mysqli_fetch_array($resultSet_1)) {
					$product = new Product;
					$product->product_id = $record["prod_id"];
					$product->product_name = $record["prod_name"];;
					$product->prod_desc = $record["prod_desc"];
					$product->img_name = $record["img"];
					$product->img_path = $record["img_path"];
					$product->prod_short_desc = $record["prod_short_desc"];
					array_push($prodArray, $product);
				}
			}
			$objRows["groupProducts"] = $prodArray;
			$objRows["groupId"] = $groupId;
			return json_encode($objRows);
		}
		
		public function populateCategories() {
			
			//if (isset($_SESSION["navigationLinks"])) {
			//	$objRows = $_SESSION["navigationLinks"];
			//} else {
				$conn = getConnetion();
		
				// Check connection
				if (mysqli_connect_errno($conn)) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				$query = "select a.group_id, a.group_name, a.group_desc, a.group_img, a.img_path, a.short_desc, b.cat_id, b.cat_name, a.template_type, a.infolink from groups a, category b where a.cat_id = b.cat_id and a.status_id = 1 and b.status_id = 1 order by b.seqNb asc, a.seqNb asc ";
				$resultSet = mysqli_query($conn, $query);

				$array_ = array();
				$categoryId = '';
				$category = new Category;
				$array_ = array();
				while($record = mysqli_fetch_array($resultSet)) {
				
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
						array_push($array_, $category);
					}				
				}
				mysqli_close($conn);
				$objRows["prodCategory"] = $array_;
			//}
			$_SESSION["navigationLinks"] = $objRows; 
			return json_encode($objRows);
			
		}
		
		public function searchProducts($searchTxt) {
			$searchQuery = "SELECT a.prod_id, a.prod_name, a.prod_desc, a.img, a.img_path, prod_short_desc, b.group_id, b.group_name, b.template_type, a.template_type tType FROM product a, groups b WHERE (prod_name like '%". $searchTxt ."%' or prod_desc like '%". $searchTxt ."%' or prod_short_desc like '%". $searchTxt ."%') and a.group_id = b.group_id order by b.group_name, a.prod_name";
			$conn = getConnetion();
		
			// Check connection
			if (mysqli_connect_errno($conn)) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			$resultSet_1 = mysqli_query($conn, $searchQuery);
			$groupMap = array();
			$finalArray = array();
			if ($resultSet_1) {
				while($record = mysqli_fetch_array($resultSet_1)) {
					if (isset($groupMap) && isset($groupMap[" ".$record["group_id"]." "])) {
					} else {
						$groupIns = new Group;
						$groupIns->displayName = $record["group_name"];
						$groupIns->id = $record["group_id"];
						$groupIns->template_type = $record["template_type"];
						
						if (isset($groupMap)) {
							$newArr = array(" ".$record["group_id"]." "=>$groupIns);
							$groupMap = array_merge($groupMap, $newArr);
						} else {
							$groupMap = array(" ".$record["group_id"]." "=>$groupIns);
						}
					}
					$product = new Product;
					$product->product_id = $record["prod_id"];
					$product->product_name = $record["prod_name"];;
					$product->prod_desc = $record["prod_desc"];
					$product->img_name = $record["img"];
					$product->img_path = $record["img_path"];
					$product->prod_short_desc = $record["prod_short_desc"];
					$product->template_type = $record["tType"];
					$groupIns->addProduct($product);
				}
			}
			
			foreach($groupMap as $key=>$value) {
				array_push($finalArray, $value);
			}
			$objRows["searchProducts"] = $finalArray;
			return json_encode($objRows);
		}
		
		public function getGroupAllProds($groupId) {
			$searchQuery = "SELECT a.prod_id, a.prod_name, a.prod_desc, a.img, a.img_path, prod_short_desc, b.group_id, b.group_name, b.template_type, a.template_type tType FROM product a, groups b WHERE a.group_id = b.group_id and a.group_id = ". $groupId ." order by b.group_name, a.prod_name";
			
			$conn = getConnetion();
		
			// Check connection
			if (mysqli_connect_errno($conn)) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			$resultSet_1 = mysqli_query($conn, $searchQuery);
			$groupMap = array();
			$finalArray = array();
			if ($resultSet_1) {
				while($record = mysqli_fetch_array($resultSet_1)) {
					if (isset($groupMap) && isset($groupMap[" ".$record["group_id"]." "])) {
					} else {
						$groupIns = new Group;
						$groupIns->displayName = $record["group_name"];
						$groupIns->id = $record["group_id"];
						$groupIns->template_type = $record["template_type"];
						
						if (isset($groupMap)) {
							$newArr = array(" ".$record["group_id"]." "=>$groupIns);
							$groupMap = array_merge($groupMap, $newArr);
						} else {
							$groupMap = array(" ".$record["group_id"]." "=>$groupIns);
						}
					}
					$product = new Product;
					$product->product_id = $record["prod_id"];
					$product->product_name = $record["prod_name"];;
					$product->prod_desc = $record["prod_desc"];
					$product->img_name = $record["img"];
					$product->img_path = $record["img_path"];
					$product->prod_short_desc = $record["prod_short_desc"];
					$product->template_type = $record["tType"];
					$groupIns->addProduct($product);
				}
			}
			
			foreach($groupMap as $key=>$value) {
				array_push($finalArray, $value);
			}
			$objRows["groupProducts"] = $finalArray;
			return json_encode($objRows);
		}

		public function getProdDetails($prodId, $groupId) {
			$searchQuery = "SELECT a.prod_id, a.prod_name, a.prod_desc, a.img, a.img_path, a.prod_short_desc, a.group_id, a.template_type FROM product a WHERE a.prod_id = " . $prodId . " and a.group_id = " . $groupId;
			$conn = getConnetion();
		
			// Check connection
			if (mysqli_connect_errno($conn)) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			$product = new Product;
			$resultSet_1 = mysqli_query($conn, $searchQuery);
			if ($resultSet_1) {
				
				while($record = mysqli_fetch_array($resultSet_1)) {
					$product->product_id = $record["prod_id"];
					$product->product_name = $record["prod_name"];;
					$product->prod_desc = $record["prod_desc"];
					$product->img_name = $record["img"];
					$product->img_path = $record["img_path"];
					$product->prod_short_desc = $record["prod_short_desc"];
					$product->template_type = $record["template_type"];
					break;
				}
			}
			$objRows["prodDetails"] = $product;
			return json_encode($objRows);
		}
		
		public function selAllProducts() {
			$searchQuery = "SELECT a.prod_id, a.prod_name, a.img, a.img_path, a.group_id, a.template_type FROM product a";
			$conn = getConnetion();
		
			// Check connection
			if (mysqli_connect_errno($conn)) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
			$product = new Product;
			$resultSet_1 = mysqli_query($conn, $searchQuery);
			if ($resultSet_1) {
				while($record = mysqli_fetch_array($resultSet_1)) {
					$product->product_id = $record["prod_id"];
					$product->product_name = $record["prod_name"];;
					$product->img_name = $record["img"];
					$product->img_path = $record["img_path"];
					$product->template_type = $record["template_type"];
					$product->group_id = $record["group_id"];
					break;
				}
			}
			$objRows["product"] = $product;
			return json_encode($objRows);
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
	
	/*if (isset($_GET['groupId']) && $_GET['groupId'] != '') {
		echo $handle->getGroupProducts($_GET['groupId']);
	} else {
		
	}*/
	
	
?>