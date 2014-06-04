$(function(){
	if ($('#sidebar').attr('id') != undefined) {

		//Communicate with db to fetch the all subcategory heading and their products.
		$.ajax({
			type: 'GET',
			url: "../html/db_connect.php?requestType=navLinks",
			dataType: 'json',
			success: function(data) {
				
				var cats = data.prodCategory;
				leftNav = '<ul id="accordion" class="topmost">';
				for(var i = 0; i < cats.length; i++) {
					var groups = cats[i].groups;
					leftNav += '<li class="categorylinks"><div style="border-bottom: 1px dotted black">' +  cats[i].displayName + '</div><ul style="display:" >';
					for(var k = 0; k < groups.length; k++) {
						leftNav += '<li><a  class="pickCategory" href="../html/'+groups[i].template_type+'.php?categoryid=' + cats[i].id + '&amp;groupId=' + groups[k].id + '">' + groups[k].displayName + '</a></li>';
					}
					leftNav += '</ul></li>';
				}
				
				leftNav += '</ul>';
				if (document.getElementById('sidebar') != null) {
					document.getElementById('sidebar').innerHTML = leftNav;	
				}
				
				$("#accordion > li > div").bind('click', function(){
					if(false == $(this).next().is(':visible')) {
						$('#accordion ul').slideUp(300);
					}
					$(this).next().slideToggle(300);
				});
				 
				$('#accordion ul:eq(0)').show();
				
			}, 
			failure: function() {
				console.log('error.');
			}
		});
		// $.ajax({
			// type: 'GET',
			// url: "../data/products.json",
			// dataType: 'json',
			// success: function(data) {
				// var cats = data.prodCategory;
				// leftNav = '<ul id="accordion" class="topmost">';
				
				// for(var i = 0; i < cats.length; i++) {
					// var products = cats[i].products;
					// leftNav += '<li class="categorylinks"><div style="border-bottom: 1px dotted black">' +  cats[i].displayName + '</div><ul style="display:" >';
					
					// for(var k = 0; k < products.length; k++) {
						// leftNav += '<li><a  class="pickCategory" href="../html/'+cats[i].template_type+'.php?categoryid=' + cats[i].id + '&amp;productId=' + products[k].id + '">' + products[k].displayName + '</a></li>';
					// }
					// leftNav += '</ul></li>';
				// }
				
				// leftNav += '</ul>';
				// if (document.getElementById('sidebar') != null) {
					// document.getElementById('sidebar').innerHTML = leftNav;	
				// }
				
				
			// }, 
			// failure: function(dsta) {
				// alert('failure');
			// }
		// });
	}
	
	
		



});
$(document).ajaxStop(function(){
		$("img.lazy").lazyload({ 
			effect: "fadeIn" ,appear : function(elements_left, settings) {
			},
			load : function(elements_left, settings) {
			}
		});
	});