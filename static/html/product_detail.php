<?php include '../html/includes/header.php' ?>

		<script type="text/javascript">
		var selProductId ='';
			var selCategoryId = '<?php echo $_GET["categoryid"] ?>';
			 selProductId =  '<?php echo $_GET["productId"] ?>';
		
			$(function() {
				
				$(".enquiryBtn").live('click', function() {
					console.log('storing data in session..');
					var productCode = $(this).attr('productCode');
					var productDesc = $(this).attr('productDesc');
					console.log('productDesc ' + productDesc);
					//make ajax call to store the info in session.
					
						$.ajax({
							type: 'GET',
							url: "../html/store_session.php?action=add&productId="+productCode + "&productDesc="+productDesc,
							dataType: 'json',
							success: function(data){
								console.log('success..');
							},
							failure: function() {
								console.log("failure.");
							}
						});
					
					
					
				});
			});
			
		</script>
	

			
						
			<div id="content-wrapper" class="clearfix row">
				<div class="content-right twelve columns">
					<div id="">				
						<div id="content-data">				
							<!-- Data Added to this section dynamically using below ajax calls. -->
							
							
						</div>
					</div>
					<!--<ul class="categoryHeadingLabel"><li>All Products</li></ul>
						<input name='selCategory' id="selCategory" type='hidden' value=''/>
						<div id="sidebar" class="widget-area">
							
						</div>-->
					<!-- </form> -->
				</div>
			</div>
		</div>
		<?php include "../html/includes/footer.php" ?>
	</body>
	
	<div style="display: none">
		<div id="productDescTemplate" class="content">
				<ul class="blocks">
					<li class="widall">	
						<h3>Color Coated Sheets</h3> <img src=""
						alt="Color Coated Sheets" style="float: right; padding-left: 30px;">
						<p class="desc">
														
						</p>
						<p class="features">
						<b>The product is offered in numerous forms which are listed below:</b></p>
						<p class="usage"><b>The product is usage is listed below:</b>
						</p>
						<p class="variety"><b>The product is available in below listed measurements:</b>
						</p>
					</li>
				</ul>
				
				<div class="clear"></div>
				<div class="line"></div>
			</div>
	</div>
	
	<div style="display: none">		
		<div id="productDetailsTemplate" class="content">
			<ul class="blocks">
				<li class="widall">	
					<h3>Color Coated Sheets</h3> 
					<img src=""
						alt="Color Coated Sheets" style="float: right; padding-left: 30px;">
					<p class="desc">cc
					</p>
					<p class="features">
					<b>The product is offered in numerous forms which are listed below:</b></p>
					<p class="usage"><b>The product is usage is listed below:</b>
					</p>
					<p class="variety"><b>The product is available in below listed measurements:</b>
					</p>
				</li>
				<li style="clear: left; float: right"><a href="#" class="button enquiryBtn" productCode="1" productDesc="1">Add For Enquiry</a></li>
			</ul>
	
			<div class="clear"></div>
		</div>
	</div>
	
	<script type="text/javascript">
		//process the incoming request parameters and show the details.... 
		
		$.ajax({
	        type: 'GET',
	        url: "../data/products.json",
	        dataType: 'json',
	        success: function(data){
	        	var cats = data.prodCategory;
	        	for(var i = 0; i < cats.length; i++) {
	        		if(cats[i].id == selCategoryId) {
	        			//Get the data..
	        			
	        			var $prodDescDiv = $('#productDescTemplate').clone();
	        			$prodDescDiv.attr("id", cats[i].id);
	        			$('#content-data').append($prodDescDiv);
	        			
	        			//Change the image path...
		        		var $imgTag = $prodDescDiv.find('img');
		        		$imgTag.attr('src', "../../images/"+cats[i].image_path+"/" + cats[i].image);
		        		$imgTag.attr('alt', cats[i].displayName);
		        		$imgTag.attr('title', cats[i].displayName);
		        		
		        		//displayName -- change the heading 
		        		var $title = $prodDescDiv.find('h3');
		        		$title.html(cats[i].displayName);
		        		
		        		
		        		var $desc = $prodDescDiv.find('p[class="desc"]');
		        		$desc.html(cats[i].description);
		        		
		        		var $features = $prodDescDiv.find('p[class="features"]');
		        		var features = cats[i].features;
		        		if (features != undefined && features != '') {
		        			var arr = features.split('#');
		        			var txt = $features.html()
		        			for(var k=0; k<arr.length;k++) {
		        				txt += "<ol>" + arr[k] + "</ol>";
		        			}
		        			$features.html(txt);
		        		} else {
		        			$features.html('');
		        		}
		        		
		        		var $usage = $prodDescDiv.find('p[class="usage"]');
		        		var usage = cats[i].usage;
		        		if (usage != undefined && usage != '') {
		        			var arr = usage.split('#');
		        			var txt = $usage.html();
		        			for(var k=0; k<arr.length;k++) {
		        				txt += "<ol>" + arr[k] + "</ol>";
		        			}
		        			$usage.html(txt);
		        		} else {
		        			$usage.html('');
		        		}
		        		
		        		var $variety = $prodDescDiv.find('p[class="variety"]');
		        		var variety = cats[i].variety;
		        		if (variety != undefined && variety != '') {
		        			$variety.html($variety.html() + variety);
		        		} else {
		        			$variety.html('');
		        		}
		        		
	        			var products = cats[i].products;
		        		if (products &&  products.length > 0) {
		        			for(var j=0; j < products.length; j++) {
		        				if (selProductId == null || selProductId == '') {
		        					var $prodDetailDiv = $('#productDetailsTemplate').clone();
			        				$prodDetailDiv.attr("id", products[j].id);
			        				
			        				var $imgTag = $prodDetailDiv.find('img');
					        		$imgTag.attr('src', "../../images/"+products[j].image_path+"/" + products[j].image);
					        		$imgTag.attr('alt', products[j].displayName);
					        		$imgTag.attr('title', products[j].displayName);
					        		
					        		$('#content-data').append($prodDetailDiv);
					        		
					        		var $title = $prodDetailDiv.find('h3');
					        		$title.html(products[j].displayName);
					        		
					        		
					        		var $desc = $prodDetailDiv.find('p[class="desc"]');
					        		$desc.text(products[j].description);
					        		
					        		var $features = $prodDetailDiv.find('p[class="features"]');
					        		var features = products[j].features;
					        		if (features != undefined && features != '') {					        			
					        			var arr = features.split('#');
					        			var txt = $features.html();
					        			for(var k=0; k<arr.length;k++) {
					        				txt += "<ol>" + arr[k] + "</ol>";
					        			}
					        			$features.html(txt);
					        		} else {
					        			$features.html('');
					        		}
					        		
					        		var $usage = $prodDetailDiv.find('p[class="usage"]');
					        		var usage = products[j].usage;
					        		if (usage != undefined && usage != '') {
					        			var arr = usage.split('#');
					        			var txt = $usage.html();
					        			for(var k=0; k<arr.length;k++) {
					        				txt += "<ol>" + arr[k] + "</ol>";
					        			}
					        			$usage.html(txt);
					        		} else {
					        			$usage.html('');
					        		}
					        		
					        		var $variety = $prodDetailDiv.find('p[class="variety"]');
					        		var variety = products[j].variety;
					        		if (variety != undefined && variety != '') {
					        			$variety.html($variety.html() + variety);
					        		} else {
					        			$variety.html('');
					        		}
					        		var $enqBut = $prodDetailDiv.find('a');
									$enqBut.attr("productCode", products[j].id);
									$enqBut.attr("productDesc", products[j].displayName);
									console.log($enqBut.attr("productDesc"));
		        				} else {
		        					if (selProductId == products[j].id) {
			        					var $prodDetailDiv = $('#productDetailsTemplate').clone();
			        					$prodDetailDiv.attr("id", products[j].id);
			        					
			        					var $imgTag = $prodDetailDiv.find('img');
						        		$imgTag.attr('src', "../../images/"+products[j].image_path+"/" + products[j].image);
						        		$imgTag.attr('alt', products[j].displayName);
						        		$imgTag.attr('title', products[j].displayName);
						        		
			        					$('#content-data').append($prodDetailDiv);	
			        					
			        					
						        		var $title = $prodDetailDiv.find('h3');
						        		$title.text(products[j].displayName);
						        		
						        		
						        		var $desc = $prodDetailDiv.find('p[class="desc"]');
						        		$desc.text(products[j].description);
						        		
						        		var $features = $prodDetailDiv.find('p[class="features"]');
						        		var features = products[j].features;
						        		if (features != undefined && features != '') {					        			
						        			var arr = features.split('#');
						        			var txt = $features.html();
						        			for(var k=0; k<arr.length;k++) {
						        				txt += "<ol>" + arr[k] + "</ol>";
						        			}
						        			$features.html(txt);
						        		} else {
						        			$features.html('');
						        		}
						        		
						        		var $usage = $prodDetailDiv.find('p[class="usage"]');
						        		var usage = products[j].usage;
						        		if (usage != undefined && usage != '') {
						        			var arr = usage.split('#');
						        			var txt = $usage.html();
						        			for(var k=0; k<arr.length;k++) {
						        				txt += "<ol>" + arr[k] + "</ol>";
						        			}
						        			$usage.html(txt);
						        		} else {
						        			$usage.html('');
						        		}
						        		
						        		var $variety = $prodDetailDiv.find('p[class="variety"]');
						        		var variety = products[j].variety;
						        		if (variety != undefined && variety != '') {
						        			$variety.html($variety.html() + variety);
						        		} else {
						        			$variety.html('');
						        		}
										
										var $enqBut = $prodDetailDiv.find('a');
										$enqBut.attr("productCode", products[j].id);
										$enqBut.attr("productDesc", products[j].displayName);
			        					break;
		        					}
		        					
		        				}
		        			}
		        		}
	        			break;
	        		}	
	        	}
	        }
		});
		
	</script>
	
</html>