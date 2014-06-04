<?php include '../html/includes/header.php' ?>
			<div id="content-wrapper" class="clearfix row" style="padding: 10px 0 0 0">
				<div style="padding-right: 5px;min-height:900px">
					<ul class="blocks">
						<li style="width:70%">
							<h2>Company Profile</h2> 
							<p>
								With an extensive industry experience of 28 years, we, have placed ourselves as a reputed supplier and trader of Galvanized Sheets, Color Coated Sheets, Perforated Sheets, Hot & Cold Rolled Sheets, Flush Door, Modular Door Panel & Door skins. All our sheets are offered in varied specification to cater to the all types of roofing requirements. The comprehensive gamut includes Galvanized Corrugated Sheet, Galvanized Plain Sheets, Color Coated Roofing Sheets, G.I Coils, Fasteners, Flush Door, Door Panels and Door Skins. Owing to their durability, light weight, water & corrosion resistance and superior strength, these sheets extensive application in varied sectors like construction, agriculture and residential. The sheets we offer are generally a ready-to-use products that can be cut, pressed, bent, roll formed, drilled, joined and lock-seamed, all without scratching the surface or the substance. The color coated sheets we offer are available in wide range which includes trapezoidal profiles, roll formed panels, plain sheets, corrugated sheets, coils and narrow slit strips. In addition to this, we offer complete customization of our products as per the needs and requirements of the patrons.
								We source our range of product from the most trusted vendors in order to provide premium quality products. Our vendors employ advanced cutting edge technologies and make use of high end machinery to manufacture these sheets. Moreover, we have constructed a spacious warehouse to store our sheets systematically in bulk volume. With the support of our warehouse, we have been able to meet the diverse requirements of our esteemed clients. Our premium quality products have allowed us to muster a huge clientele throughout the nation.
							</p>
							<br/>
							<!-- <a class="button" href="../html/profile.php">Read More...</a>-->
						</li>
											
						<li style="width:70%" style="clear:left">	
							<h2>Product Portfolio</h2> 
							<p>Our range of products</p>
							<ul>
							<ol>- Galvanized Corrugated Sheet</ol>
							<ol>- Galvanized Plain Sheets</ol>
							<ol>- Galvanized Sheets</ol>
							<ol>- Perforated Sheets</ol>
							<ol>- Hot Rolled Sheets</ol>
							<ol>- Color Coated Roofing Sheets</ol>
							<ol>- Cold Rolled Sheets</ol>
							<ol>- E I Sheets</ol>
							</ul>
							
						</li>
						
					</ul>
					
					<ul>
					<li class="wid250">	
							<div id="divCarousel-2">
								
							</div>
						</li>
	
					</ul>
					
				</div>
				
				
				
				
			</div>
			
			<div class="clear"></div>
			
		</div>
		<?php include "../html/includes/footer.php" ?>
	</body>
	
	
	<script>
	
	$(function(){
		$.ajax({
			type: 'GET',
			url: "../data/products.json",
			dataType: 'json',
			success: function(data) {
				var cats = data.prodCategory;
				var $dynaDiv = $('#divCarousel-2');
				for(var i=0; i < cats.length; i++ )
				var catId = cats[i].id;
				var products = cats[i].products;
				if (products &&  products.length > 0) {
					var len = products.length;
					for(var j=0; j < len; j++) {
						//Add images of subproducts here...This product has some products hence show those as small image below category image...	
						var prodDesc = cats[i].products[j].description;
						$dynaDiv.append("<img style='padding: 10px' width='250px' categoryId=" + cats[i].id + " productId=" + products[j].id + " src='../../images/home_decor/roofing/" + cats[i].products[j].image + "' ></img>");
					}
				}
			}
			
			$("#divCarousel-2").carouFredSel({
			circular			: true,
			infinte				: true, 
			items				: 3,
			direction			: "top",
			transition			: true,
			scroll : {
				items			: 1,
				fx				: "none",
				easing			: "swing",
				duration		: 400,
				pauseOnHover	: true,
			},
			mousewheel: {
				items			: 1,
				easing			: "swing",
				duration		: 400,
				pauseOnHover	: true
			}
		});
			
			
		},
		failure: function(dsta) {
		}
		});
	});
	</script>
	
	
</html>