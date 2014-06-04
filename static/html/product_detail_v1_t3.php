<?php include '../html/includes/header.php' ?>
			
<div id="content-wrapper" class="clearfix row">
		
	<div class="content-left twelve columns">
		<div id="subcontent">
			<div id="content-data">
				<!-- Data Added to this section dynamically using below ajax calls. -->
			
				<div id="productDescTemplate" class="content" style="display:none;">
					<h4><span id="groupHeader" style="padding: 0 0 0 20px;font-size: 20px">Venner<span></h4>
					<ul class="blocks">
						<li class="widall subheadingClass">	
							<div style="padding: 0 40px 0 0; border-bottom:#ffffff">
								<h4><span id="subgroupHeader"></span></h4> 
								<div class="line"></div>
							</div>
							<div id="dynaDiv" class="prodRendering" style="padding: 0 0 10px 0">
															
							</div>
							<!-- for showing produtct category as listing..-->
						</li>
					</ul>
				</div>
			</div>
		</div>
				
		<div id="searchbar" class="widget-area" style="height: 100%;margin-top:10px">
			<?php 
			//	include '../html/search_includes/decor_search_criteria.html'
			?>
			
				<div class="clear"></div>
				<div class="line"></div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div></div>
<?php include "../html/includes/footer.php" ?>
	
	<!-- template structure for rendering product -->
	<div id="prodImageDiv" class="rowimage" style="float:left;display:none"> 
		<a href="#">
			<img src="../../images/loading.gif" border="0" class="lazy" data="description" data-original="" style="display:inline-block" width="220px" height="250px"/>
		</a>
		<div class="addToCart" style="display:none;">
			<img src="../../images/cart_add.png" />
		</div>
		
		<div id="shortDesc" style="font-size: 12px;font-weight:bold;border-bottom:1px solid #e2e2e2;border-top:1px solid #e2e2e2;background:none repeat scroll 0 0 #f3f3f3">
			<span class="prodName" style="padding:5px"></span>
			<span class="prodPrice" style="padding:5px"></span>
		</div>
		<div class="addInfo" style="display: none;width: 220px">
			<span class="addInfo_" style="padding:5px">Additional contents</span>
		</div>
		
	</div>
</body>
</html>

<script>
	
	$("div").delegate(".addToCart", "click", function(event) {
		
		$.ajax({
			type: 'GET',
			url: "../html/store_session.php?action=add&productId="+$(this).parent("div.rowimage").attr("id") + "&productDesc="+$(this).next("#shortDesc").children(".prodName").html(),
			dataType: 'json',
			success: function(data){
				console.log('success..');
			},
			failure: function() {
				console.log("failure.");
			}
		});
	});
	
	$("div").delegate(".rowimage", "mouseover",function(event) {
		$(this).find(".addInfo").css("display", "inline");
		$(this).find(".addInfo").css("position", "absolute");
		$(this).find(".addToCart").css("display", "inline");
	});
	
	$("div").delegate(".rowimage", "mouseout",function(event) {
		$(this).find(".addInfo").css("display", "none");
		$(this).find(".addInfo").css("position", "");
		$(this).find(".addToCart").css("display", "none");
	});

	//make ajax call to get the all products belonging to select group of category.
	var catId = '<?php echo $_GET["categoryid"] ?>';
	var groupId = '<?php echo $_GET["groupId"] ?>';
	$.ajax({
		type: 'GET',
		url: "../html/db_connect.php?requestType=getGroupAllProds&categoryId=" + catId + "&groupId=" + groupId,
		dataType: 'json',
		success: function(data){
			var searchProds = data.groupProducts;
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
							gHeader.html(searchProds[i].displayName + " <span style='font-size: 14px;font-weight:normal'>(" + products.length + " Items found for selected category. )</span>");
							var dynamicDiv = prodTemp.find("#dynaDiv");
							dynamicDiv.attr("id","gp_" + searchProds[i].id);
							dynamicDiv.css({"display": "inline"});
							var pLen = products.length;
							for (var j = 0; j < pLen; j++) {
								//create div for image and add to main div content area.
								var prodImgDiv = $("#prodImageDiv").clone();
								prodImgDiv.attr("id", "p_" + products[j].product_id);
								prodImgDiv.css({"display": "inline"});
								var imgTag = prodImgDiv.find("img.lazy");;
								imgTag.attr('src', "../../images/"+products[j].img_path + products[j].img_name);
								imgTag.attr('data-original', "../../images/"+products[j].img_path + products[j].img_name);
								
							
								var aTag = prodImgDiv.find("a");;
								aTag.attr('href', '../html/' + products[j].template_type + ".php?groupId=" + searchProds[i].id + "&prodId=" + products[j].product_id);
								
								prodImgDiv.find("#shortDesc > .prodName").html(products[j].product_name);
								prodImgDiv.find("#shortDesc > .prodPrice").html(" Request for price. ");
								dynamicDiv.append(prodImgDiv);
							}
							console.log('products ' + products.length);
						} else {
							gHeader.html(searchProds[i].displayName + " <span style='font-size: 14px;font-weight:normal'>( No Items found for selected category. )</span>");
						}
					}
					
				}
		}, 
		failure: function (data) {
			console.log('---');
		}
	});
	
	
	
</script>