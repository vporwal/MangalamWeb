<?php include '../html/includes/header.php' ?>
			
<div id="content-wrapper" class="clearfix row">
	
	<div class="content-left twelve columns">
		<div id="subcontent">
			<div id="content-data">
				<!-- Data Added to this section dynamically using below ajax calls. -->
				
				<!--
					Structure - 
					left side image 
					right side of image following information
						a. prod name
						b. prod short desc
						c. prod desc
					below are
					2 tabs
						a. product complete information
						b. Contact details of traders / dealers...
				-->
					
					<div id="productDetailsTemplate" class="content" style="display:none">
						<div class="prod-left" style="float: left;height:350px">
							<div style="float: left;padding: 0 20px 0 0;display: inline-block">
								<img id="prodImg" class="prodImg" width="250px" height="300px" src="../../images/home_decor/venner/products/Smoked-Zebrano.jpg" data-zoom-image="../../images/home_decor/venner/products/Smoked-Zebrano.jpg" alt="Color Coated Sheets" style="float: right; display:inline-block" >
							</div>
							<div class="clear"></div>
						</div>
						<div class="prod-right" style="float: right">
							<div>
								<span class="prodHeading"><h2>Smoked-Zebrano</h2></span>
							</div>
							<div class="description">
								
							</div>
							<div class="specification">
								
							</div>
						</div>
					</div>
					
					<!--<div style="display:block;border-bottom: 1px dotted black;margin-left: 5px;padding:30px 10px 10px 20px;clear: left;font-size: 16px; font-weight: bold">
						Releated Products
					</div>-->
					
			</div>
		</div>
		<div class="adsSpace" class="widget-area" style="height: 100%;">
			Ads ..
		</div>
	</div>
	<div class="clear"></div>
</div>
</div>
<?php include "../html/includes/footer.php" ?>
</body>
	
</html>

<script>

	
	
	var prodId = '<?php echo $_GET["prodId"] ?>';
	var groupId = '<?php echo $_GET["groupId"] ?>';
	console.log('prodId');
	$.ajax({
		type: 'GET',
		url: "../html/db_connect.php?requestType=prodDetails&prodId=" + prodId + "&groupId=" + groupId,
		dataType: 'json',
		success: function(data){
			var prodData = data.prodDetails;
			
			var prodDetailDiv = $("#productDetailsTemplate");
			prodDetailDiv.attr("id", prodData.product_id);
			prodDetailDiv.css("display", "inline");
			var img = prodDetailDiv.find(".prodImg");
			img.attr("src", "../../images/"+prodData.img_path + prodData.img_name);
			img.attr("data-zoom-image", "../../images/home_decor/venner/products/zoom/American-Walnut-Qtr.jpg");
			
			$(".prodHeading").html("<h2>" + prodData.product_name + "<h2>");
			$(".description").html(prodData.prod_desc);
			$(".specification").html(prodData.prod_short_desc);
		//	$("#prodImg").elevateZoom({easing : true});
		
			$('#prodImg').elevateZoom({
				zoomType: "inner",
				cursor: "pointer",
				zoomWindowFadeIn: 500,
				zoomWindowFadeOut: 750
		   	});
		}, 
		failure: function (data) {
			console.log('---');
		}
	});
	
	
	
</script>