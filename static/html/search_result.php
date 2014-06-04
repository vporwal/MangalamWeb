<?php include '../html/includes/header.php' ?>

<div id="content-wrapper" class="clearfix row">
	
	<div class="content-left twelve columns">
		<div id="subcontent">
			<div id="content-data">
				<div style="padding: 5px 0 10px 20px"> <h4>Results found for search item '<i><?php echo $_GET["searchTxt"] ?></i>' <h4></div>
				<div class="sort" style="padding: 0 0 10px 20px; display: inline-block">
					<div class="sortHeading" style="margin-left:0px !important">Sort By : </div>
					<div class="sortByValue selected">Group</div>
					<div class="sortByValue">Product Name</div>
					<div class="sortByValue">Price</div>
				</div>
				<!-- Data Added to this section dynamically using below ajax calls. -->
				<div id="productDescTemplate" class="content" style="display:none;">
					<h4><span id="groupHeader" style="padding: 0 0 0 20px;font-size: 14px">Venner<span></h4>
					<ul class="blocks">
						<li class="widall subheadingClass">	
							<div style="padding: 0 40px 0 0; border-bottom:#ffffff">
								<h4 style="border-bottom: 1px dotted;"><span id="subgroupHeader"></span></h4> 
							</div>
							<div id="dynaDiv" class="prodRendering" style="padding: 0 0 10px 0">
																		
							</div>
							<!-- for showing produtct category as listing..-->
						</li>
					</ul>
				</div>
			</div>
		</div>
				
		<div id="searchbar" class="widget-area" style="height: 100%;">
			<!-- Left Nav Links added dynamically using ajax call...  -->
			<?php 
				include '../html/search_includes/decor_search_criteria.html'
			?>
				<div class="clear"></div>
				<div class="line"></div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div></div>
<?php include "../html/includes/footer.php" ?>
</body>
	
	
	
	<div id="prodImageDiv" class="rowimage" style="float:left;display:none"> 
		<a href="#">
			<img src="" border="0" data="description" width="220px" height="250px" style="display:inline-block"/>
		</a>
		<div id="shortDesc" style="font-size: 12px;font-weight:bold;border-bottom:1px solid #e2e2e2;border-top:1px solid #e2e2e2;background:none repeat scroll 0 0 #f3f3f3">
			<span class="prodName"></span>
			<span class="prodPrice"></span>
		</div>
		<div class="addInfo" style="display: none">
			<span class="addInfo_">Additional contents</span>
			
		</div>
	</div>
	
	
	<script type="text/javascript">
	
		$("div").delegate(".rowimage", "mouseover",function() {
			$(this).find(".addInfo").css("display", "inline");
			$(this).find(".addInfo").css("position", "absolute");
		});
		
		$("div").delegate(".rowimage", "mouseout",function() {
			$(this).find(".addInfo").css("display", "none");
			$(this).find(".addInfo").css("position", "");
		});
		
		//process the incoming request parameters and show the details.... 
		var searchStr = '<?php echo $_GET["searchTxt"] ?>';
		$.ajax({
	        type: 'GET',
	        url: "../html/db_connect.php?requestType=search&searchTxt=" + searchStr,
	        dataType: 'json',
	        success: function(data){
				var searchProds = data.searchProducts;
				if (searchProds && searchProds.length) {
					var len = searchProds.length;
					for (var i =0; i<len; i++) {
						var prodTemp = $("#productDescTemplate").clone();
						prodTemp.attr("id", "prod_"+searchProds[i].id);
						prodTemp.css({"display": "inline"});
						prodTemp.css({"clear": "both !important"});
						gHeader = prodTemp.find("#groupHeader");
						//gHeader.html(searchProds[i].displayName);
						$("#content-data").append(prodTemp);
						
						var products = searchProds[i].products;
						if (products && products.length > 0) {
							gHeader.html(searchProds[i].displayName + " <span style='font-size: 12px;font-weight:normal'>(" + products.length + " Item (s) found. )</span>");
							
							var dynamicDiv = prodTemp.find("#dynaDiv");
							dynamicDiv.attr("id","gp_" + searchProds[i].id);
							dynamicDiv.css({"display": "inline"});
							var pLen = products.length;
							for (var j = 0; j < pLen; j++) {
								//create div for image and add to main div content area.
								var prodImgDiv = $("#prodImageDiv").clone();
								prodImgDiv.attr("id", "p_" + products[j].product_id);
								prodImgDiv.css({"display": "inline"});
								var imgTag = prodImgDiv.find("img");;
								imgTag.attr('src', "../../images/"+products[j].img_path + products[j].img_name);
								
								var aTag = prodImgDiv.find("a");;
								aTag.attr('href', '../html/' + products[j].template_type + ".php?groupId=" + searchProds[i].id + "&prodId=" + products[j].product_id);
								
								//prodImgDiv.find("#shortDesc").html(products[j].product_name + " " + "<br>Avg. Price 100 - 500 / sq mtr.");
								prodImgDiv.find("#shortDesc > .prodName").html(products[j].product_name);
								prodImgDiv.find("#shortDesc > .prodPrice").html("Avg. Price 100 - 500 / sq mtr.");
								console.log(imgTag.attr("src"));
								dynamicDiv.append(prodImgDiv);
							}
							console.log('products ' + products.length);
						}
					}
				}
			}, 
			failure: function(data) {
				alert('failed.');
			}
				
		});
		
	
	
	
</script>
	
</html>

