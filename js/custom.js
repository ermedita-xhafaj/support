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
	$("#old-name-category").change(function(){
		if($(".manage-categories-table tr."+$(this).val()+" td.cat-status-identifier input").attr("checked")){
			$("#new-category-status").prop("checked",true);
		}
		else{
			$("#new-category-status").prop("checked", false);
		}
	});
});


