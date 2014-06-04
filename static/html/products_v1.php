<?php include '../html/includes/header.php' ?>
			<div id="content-wrapper" class="clearfix row">
				<div class="content-left twelve columns">
					<div id="subcontent">
						<div id="content-data" style="padding: 0 0 0 10px">
							<!-- Data Added to this section dynamically using below ajax calls. -->
						</div>
					</div>
					<!-- <div id="sidebar" class="widget-area" style="height: 100%;"> -->
					<div id="searchbar" class="widget-area" style="padding-top:0 !important;height: auto;">
						<!-- Left Nav Links added dynamically using ajax call...  
						-->
						
						<!-- show image with product name showing below part of the image. -->
						
						<div id="#"><h3>Most Viewed Products<h3></div>
						<div class="line"></div>
						<div class="mostviewedprods">
							<a href="../html/product_detail_v1_t4.php?groupId=109&prodId=116"><img src="../../images/home_decor/venner/products/Ebony.jpg" width="220px" height="220"/></a>
							<div style="width:220px;">
								<p class="label_">American Walnut Qtr</p>
								<p class="label_">Avg. Price </p>
							</div>
						</div>
						<div class="mostviewedprods">
							<a href="../html/product_detail_v1_t4.php?groupId=109&prodId=116"><img src="../../images/home_decor/venner/products/Sucupira-Crotch.jpg" width="220px" height="220"/></a>
							<div style="width:220px;">
								<p class="label_">American Walnut Qtr</p>
								<p class="label_">Avg. Price </p>
							</div>
						</div>
						
						
						<div id="#" style="padding-top: 30px"><h3>Most Enquired Products<h3></div>
						<div class="line"></div>
						<div class="mostviewedprods">
							<a href=""><img src="../../images/home_decor/venner/products/TT-16.jpg" width="220px" height="220"/></a>
							<div style="width:220px;">
								<p class="label_">American Walnut Qtr</p>
								<p class="label_">Avg. Price </p>
							</div>
						</div>
						<div class="mostviewedprods">
							<a href=""><img src="../../images/home_decor/venner/products/Polka-White-Ash.jpg" width="220px" height="220"/></a>
							<div style="width:220px;">
								<p class="label_">American Walnut Qtr</p>
								<p class="label_">Avg. Price </p>
							</div>
						</div>
						
						
					</div>
					<div class="clear"></div>
				</div>
			
			</div>	
		</div>
		<?php include "../html/includes/footer.php" ?>
		
	</body>
	
	
	<div class="collapsible" id="categoryId" style="clear:left;display:none;padding:0px"><span></span></div>	
	<div id="groupId" style="height:auto;position:relative">
		<div id="dynaDiv" class="imagehovering" style="display:none">
			<div class="rowimage animate1">
					<img src="../../images/loading.gif" border="0" class="lazy" data-original="" width="220px" height="250px" style="display:inline" title="1. On mouse hover should show the small desc of group. 2. On click will show the slide show of best  products within category"/>
					<div data="info" style="display: none;position:absolute;background-color: whitesmoke;margin-top:-45px;width:220px">
					</div>
			</div>
			<div class="subImg" style="padding-top:10px;width:220px">
				<!-- <img class="" src="../../images/laminates/9506-Zebrano.jpg" height="60px" width="60px" /> -->
			</div>
			<div style="padding:5px;">
			</div>
			
			<div class="viewprod">
				<span class="allprodview" style="font-size:11px;font-weight:bold"><a href=""></a></span>
				<a href="#" class="infoLink" style="float:right;margin-top:-5px" target="_new"><img src="../../images/info.ico" alt="Explore Product Group" title="Explore Product Group"></a>				
			</div>
		</div>
	</div>

<script>
	
	
		
	$(function(){
		$.ajax({
	        type: 'GET',
	        url: "../html/db_connect.php?requestType=prodGroups",
	        dataType: 'json',
	        success: function(data){
	        	var cats = data.prodCategory;
				catLen = cats.length;
				var ids = "";
	        	for(var i = 0; i < catLen; i++) {
	        		
					var $catDiv = $('#categoryId').clone();
					$catDiv.attr("id", "cat_"+cats[i].id);
					ids = ids + "cat_"+cats[i].id+',';
					$catDiv.append("<h3>"+cats[i].displayName+"</h3>");
					$catDiv.css({"display": "block"});
					$('#content-data').append($catDiv);
					$('#content-data').append("<div class='line'></div>");
					
					$groupDiv = $('#groupId').clone();	
					$groupDiv.attr("id", "group_" + cats[i].id);
					
					var groups = cats[i].groups;
					if (groups && groups.length > 0) {
						for(var j=0; j<groups.length;j++) {
							$dynaDiv = $('#dynaDiv').clone();
							$dynaDiv.attr('id', 'dn_' + groups[j].id);
							$dynaDiv.css({"float": "left"});
							$dynaDiv.css({"display": "inline-block"});
							
							var $imgTag = $dynaDiv.find('img.lazy');
							$imgTag.attr('src', "../../images/"+groups[j].image_path + groups[j].image);
							$imgTag.attr("data-original", "../../images/"+groups[j].image_path + groups[j].image);
							//$imgTag.attr("title", groups[j].shortDesc);
							//$imgTag.attr("alt", groups[j].shortDesc);
							
							$imgTag.next().html(groups[j].shortDesc);
							$dynaDiv.children("div.subImg").append("<img src='' ");
							$dynaDiv.children("div.viewprod").find(".allprodview").html('<a style="color: black;" href="../html/' + groups[j].template_type + '.php?categoryid=' + cats[i].id + '&groupId='+groups[j].id + '">View All ' + groups[j].displayName + ' >>>&nbsp;</a>');
							
							$dynaDiv.children("div.viewprod").find("a.infoLink").attr("href", groups[j].infoLink);
							$groupDiv.append($dynaDiv);
							
							
							//make ajax call to fetch the products belonging to main products...
							
						}
					}
					
					$('#content-data').append($groupDiv).append("<div style='clear:left;padding-bottom:15px'></div><div class='line'></div><div style='padding-bottom:15px'></div>");
	      		}
	      		
				$('.collapsible').collapsible({
					defaultOpen: ids
				});
	        }, 
	        failure: function(dsta) {
	        	alert('failure');
	        }
		});
	});
	
	$(document).ajaxStop(function(event){
		$("div.rowimage").mouseenter(function(event) {			
			$(this).find("div").css("display", "block").slideUp();
			$(this).find("div").css("display", "block").slideDown();
		});
		
		$("div.rowimage").mouseleave(function(event) {			
			$(this).find("div").css("display", "none");
			$(this).find("div").css("display", "none");
		})
		
		$("div.rowimage").click(function(event) {			
			window.open('../html/slideshow.php');
		});
		
	});
	
</script>					

</html>