$(document).ready(function(){

	$(".te-drejtat").click(function(){			
		if( $(this).attr('id') == "stafi"){
			$("#options").removeClass("hidden");
			
		} else {
			$("#options").addClass("hidden");
		}
	});
	
	$('#klient').click(function(){
		 $("#stafi").prop('checked', false);
		 $("#administratori").prop('checked', false);
	});
	$('#stafi').click(function(){
		$("#klient").prop('checked', false);
	});
	$('#administraori').click(function(){
		$("#klient").prop('checked', false);
	});
});


$(document).ready(function(){
	$(".te-drejtat").click(function(){
	if( $(this).attr('id') == "klient") {
		$("#preferences-info").addClass("hidden");
		}
	else {
		$("#preferences-info").removeClass("hidden");
	}
	});

});

$(document).ready(function(){
	$(".te-drejtat").click(function(){
	if( $(this).attr('id') == "klient") {
		$("#notifications-info").addClass("hidden");
		}
	else {
		$("#notifications-info").removeClass("hidden");
	}
	});

});

$(document).ready(function(){
	$(".te-drejtat").click(function(){
	if( $(this).attr('id') == "klient") {
		$("#show-hide-optionsClient").addClass("hidden");
		}
	else {
		$("#show-hide-optionsClient").removeClass("hidden");
	}
	});

});

$(document).ready(function(){
	$(".te-drejtat").click(function(){
	if( $(this).attr('id') == "klient") {
		$("#show-hide-kontrata").removeClass("hidden");
		}
	else {
		$("#show-hide-kontrata").addClass("hidden");
	}
	});

});

$(document).ready(function(){
	$(".new_class").click(function(){
	if( $(this).attr('id') == "create-contract-info") {
		$(".endingdate_head").addClass("hidden");
		$(".createdby_head").addClass("hidden");
		$(".endingdate_info").addClass("hidden");
		$(".createdby_info").addClass("hidden");
		}
	else {
		$(".endingdate_head").removeClass("hidden");
		$(".createdby_head").removeClass("hidden");
		$(".endingdate_info").removeClass("hidden");
		$(".createdby_info").removeClass("hidden");
	}
	});

});
