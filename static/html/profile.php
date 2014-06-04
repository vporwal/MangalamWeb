<?php include '../html/includes/header.php' ?>
		<script>
		
		$("#divCarousel-2").carouFredSel({
		
			circular			: true,
			infinte				: true, 		
			items				: 3,
			direction			: "bottom",
			transition			: true,
			scroll : {
				items			: 1,
				easing			: "swing",
				duration		: 1000,
				pauseOnHover	: true
			},
			mousewheel: {
				items			: 1,
				easing			: "swing",
				duration		: 1000,
				pauseOnHover	: true
			}
		});
		
		$.ajax({
	        type: 'GET',
	        url: "/static/data/products.json",
	        dataType: 'json',
	        success: function(data){
	        	var cats = data.prodCategory;
	        	
	        	var $ul = $("#profileImageRolling");
	        	
	        	for(var i = 0; i < cats.length; i++) {
	        		var products = cats[i].products;
	        		for(var j=0; j<products.length; j++) {
	        			var $li = $("#rollingImage").clone();
	        			$li.attr("id",products[j].id);
	        	       	var $imgTag = $li.find('img');
		        		$imgTag.attr('src', "${pageContext.request.contextPath}/images/roofing/" + products[j].image);
		        		$imgTag.attr('alt', products[j].displayName);
		        		$imgTag.attr('title', products[j].displayName);
	        	       	
		        		var $anchorTag = $li.find('a');
		        		$anchorTag.attr('href', $anchorTag.attr('href') + "?categoryid=" + cats[i].id + "&amp;productId=" + products[j].id);
		        		$ul.append($li);
	        		}
	        	}
	        }
		});
		</script>
		
			<div class="content">
				<div>
					<ul class="blocks">
						
						<li style="width:80%">
							<h2>About Us</h2> 
							<p>
								Established in the year 1984, we, <b>Mangalam</b> are a distinguished supplier and trader of MS Round Pipes, MS Angles, MS Channel, Fasteners, Mild Steel Products, Galvanized Sheets, Perforated Sheets and Hot & Cold Rolled Sheets. Ours is a sole proprietorship (individually Held) firm, which is located at Pune, (Maharashtra, India). Catering all types of roofing requirements by offering customized range of sheets. All our sheets are obtained from reputed manufacturers, who employ cutting edge technology and high end machinery in the production process. Our products find their extensive application in varied sectors like construction, agriculture and residential. These products are also demanded for vehicles manufacturer, packing vessels and manufacturing container. The sheets we offer are known for their attributes like durability, light weight, water resistance, non-toxic and eco-friendly.
							</p>
							<div class="features" style="padding-top: 15px;">
								<p class="subSection subSection_ext">Our Strength</p>
								<p>
									We have achieved a commendable position in the market owing to the high quality sheets. Moreover, we have gained a goodwill in the industry because of our ethical and transparent business policies. The offered sheets are in accordance with set industry norms and standards. These products are offered at reasonable price, suiting the budgetary constraints of the clients. Our timely delivery of products are highly appreciated in the market by our patrons. In addition, there are also varied other factors, which are cited to be the USPs of our enterprise. These factors are listed below:
									
									<ol>Reliable vendor base</ol>
									<ol>Committed professionals</ol>
									<ol>High quality products</ol>
									<ol>Timely delivery</ol>
									<ol>Wide reach</ol>
								</p>
							</div>
							<div style="padding-top: 15px;">
								<p class="subSection subSection_ext">Product Portfolio</p>
								<p>
									We are an illustrious supplier and trader of Galvanized Sheets, Perforated Sheets and Hot & Cold Rolled Sheets. Owing to their durability, light weight and superior strength, these sheets extensive application in varied sectors like construction, agriculture and residential. All our products are procure from the well established vendors of the market. The wide assortment offered to our clients is listed below:
									
									<ol>Galvanized Corrugated Sheet</ol>
									<ol>Galvanized Plane Sheets</ol>
									<ol>Galvanized Sheets</ol>
									<ol>Perforated Sheets</ol>
									<ol>Hot Rolled Sheets</ol>
									<ol>Color Coated Roofing Sheets</ol>
									<ol>Cold Rolled Sheets</ol>
									<ol>E I Sheets</ol>
								</p>
							</div>
							<div style="padding-top: 15px">
								<p class="subSection subSection_ext">Quality Standards Delivered</p>
								<p>
									With a quality oriented firm, we always strive to provide our patrons with premium quality products. For this, we source our entire range of products from the trustworthy vendors of the market who employ all the advanced cutting edge technology and high grade raw material in the production process. The products offered by us are in line with the specific requirements and demands of our valued clients. In addition, we have appointed efficient quality inspectors to examine the quality of our products. Before delivering these products, our quality controllers conduct varied tests on the grounds of varied parameters listed below:
 
									<ol>Corrosion & abrasion resistance</ol>
									<ol>Durability</ol>
									<ol>Sturdy construction</ol>
									<ol>Dimensional accuracy</ol>
								</p>
							</div>
							<div style="padding-top: 15px">
								<p class="subSection subSection_ext">Our Team</p>
								<p>
									The immense experts we have appointed are the backbone of our enterprise. These highly skilled and experienced professionals efficiently assist us in all the phases of our trade. Owing to their qualification, sincerity and dedication, we have been able to achieve the goals and targets of our enterprise. Our professionals hold immense expertise in this domain which enables us to provide flawless range of products within prescribed time frame. In addition, these professionals work in close-coordination with the clients to cope up with the increasing requirements of our patrons. Our team of diligent professionals include the following members:
 
									<ol>Procuring agents</ol>
									<ol>Research professionals</ol>
									<ol>Quality controllers</ol>
									<ol>Sales & marketing executives</ol>
								</p>
							</div>
							<div style="padding-top: 15px">
								<p class="subSection subSection_ext">Client Satisfaction</p>
								<p>
									The prime objective of our enterprise is to attain utmost client satisfaction. Owing to our client-centric approach, our aim is to offer finest quality products to our patrons. All our products are offered at reasonable prices to suit the diverse budget of our patrons. In addition, we also make sure that the offered array is in tandem with international quality standards. Furthermore, customization of our products are also provided as per the specifications given by our clients. Due to the premium quality of our products, we have been highly accepted by our patrons from various nook and corner of the nation.
								</p>
							</div>
							<div style="padding-top: 15px">	
								<p class="subSection subSection_ext">Vendor Base</p>
								<p>
									We source our entire range of products from the most trusted vendors of the industry. These vendors make use of high end machinery and employ cutting edge technology to manufacture these products. They also use premium quality raw material to manufacture these products in compliance with industry norms and standards. These vendors supply the superior quality sheets to us and that too within short span of period. Moreover, we have appointed a team of procuring agents to source our products from well established vendors. These professionals conduct thorough study and analysis of the market before choosing our vendors. From the day of our commencement, our professionals maintain a close interaction with our vendors. With the support of our vendors, we have been able to win the trust and confidence of our valued patrons. The factors on which our procuring agents select the right vendor are: 
									<ol>Market position</ol>
									<ol>Infrastructure</ol>
									<ol>Clientele</ol>
									<ol>Trade requirements</ol>
									<ol>Goodwill</ol>
								</p>
							</div>
						</li>
					</ul>
				</div>
				
				
					<!--//Carousel Two--> 
					<div id="divCarousel-2">
						<ul>
						 
						</ul> 
					</div> 
				<div class="clear"></div>
			</div>
		</div>
		<?php include "../html/includes/footer.php" ?>
	</body>
</html>