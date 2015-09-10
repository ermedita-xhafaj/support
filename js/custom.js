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
		$("#notifications-info").addClass("hidden");
		$("#project_users-info").addClass("hidden");
		}
	else {
		$("#preferences-info").removeClass("hidden");
		$("#notifications-info").removeClass("hidden");
		$("#project_users-info").removeClass("hidden");
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
	if(!$("#edit-contract-info").hasClass('active')){
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



//Initialize the plugin:	
$(document).ready(function() {
	$('.multiple').multiselect({
	enableCaseInsensitiveFiltering: true,
});
});


// Check for control project_code, department_code:
$(document).ready(function() {
	$("#project-button").click(function(){
		var exist = false;
		$(".manage-projects-table tr.project-row-identification td.project-code-identification").each(function(){
			if($("#form-project-code").val()==$(this).html()){
				alert("Vendosni nje kod te ndryshem per projektin");
				exist = true;
			}
		});
		if(exist){
			return false;
		} else{
			return true;
		}
	});
});

$(document).ready(function() {
	$("#department-button").click(function(){
		var exist = false;
		$(".manage-department-table tr.department-row-identification td.department-code-identification").each(function(){
			if($("#form-department-code").val()==$(this).html()){
				alert("Vendosni nje kod te ndryshem per projektin");
				exist = true;
			}
		});
		if(exist){
			return false;
		} else{
			return true;
		}
	});
});
