var gloablEnquiryCart = [];
var popupStatus = 0;



$(function(){
	$('#openEnquiryCart').on('click', function(e) {
		var $popUpDiv = $('div#popupContainer');
		$popUpDiv.load('../html/enquiryCart.php');
		centerPopup(e);
		openPopup();
		});
	
	$("#popupCloseAnchor").on('click', function(){
		disablePopup();
	});
	
	//Click out event!
	$("#backgroundPopup").on('click', function(){
		disablePopup();
	});
	
	//Press Escape event!
	$(document).on('keypress', function(e){
		if(e.keyCode==27 && popupStatus==1) {
			disablePopup();
		}
	});

});	



/* centering popup */
function centerPopup(e){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContainer").height();
	var popupWidth = $("#popupContainer").width();
	
	//centering
	$("#popupContainer").css({
		"position": "absolute",
		"top": windowHeight/6.5 - popupHeight/2,
		"left": windowWidth/8.5 - popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
}

//loading popup with jQuery magic!
function openPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({"opacity": "0.7"});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContainer").fadeIn("slow");
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupContainer").fadeOut("slow");
		popupStatus = 0;
	}
}