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
	$('#administratori').click(function(){
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
		if(window.location.href.indexOf("?")!=-1)
		$("#project_users-info").removeClass("hidden");
	}
	});

});


$(document).ready(function(){
	$(".te-drejtat").click(function(){
	if( $(this).attr('id') == "klient") {
		if(window.location.href.indexOf("?")!=-1){
		$("#project_users-info").removeClass("hidden");}
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
		$("#show-hide-kompani").removeClass("hidden");
		}
	else {
		$("#show-hide-kontrata").addClass("hidden");
		$("#show-hide-kompani").addClass("hidden");
	}
	});

});

$(document).ready(function(){
	if(!$("#edit-contract-info").hasClass('active')){
		$(".endingdate_head").addClass("hidden");
		$(".createdby_head").addClass("hidden");
		$(".last_modified").addClass("hidden");
		$(".createdby_info").addClass("hidden");
		}
	else {
		$(".endingdate_head").removeClass("hidden");
		$(".createdby_head").removeClass("hidden");
		$(".last_modified").removeClass("hidden");
		$(".createdby_info").removeClass("hidden");
	}
	$(".new_class").click(function(){
	if( $(this).attr('id') == "create-contract-info") {
		$(".endingdate_head").addClass("hidden");
		$(".createdby_head").addClass("hidden");
		$(".last_modified").addClass("hidden");
		$(".createdby_info").addClass("hidden");
		}
	else {
		$(".endingdate_head").removeClass("hidden");
		$(".createdby_head").removeClass("hidden");
		$(".last_modified").removeClass("hidden");
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

	$("div#contract_email_contact ul.multiselect-container li").not(":eq(0)").css("display", "none");
	
	$("#new-contract-submit-btn").click(function(){
		if($(".multiselect-selected-text:first").text()=="None selected") {alert("Ju lutem selektoni të paktën një përdorues nga stafi."); return false;}
		if($(".multiselect-selected-text:eq( 1 )").text()=="None selected") {alert("Ju lutem percaktoni të paktën një email."); return false;}
	});	
	
	$("div#contract_staff ul.multiselect-container li input").not(":first").click(function(){
		var staff_id = $(this).val();
		if($(this).parents('li').attr("class")!="active"){
			var input = $("div#contract_email_contact ul.multiselect-container li input[value='"+staff_id+"']");
			input.parents("li").removeAttr("style");
		}
		else{
			var input = $("div#contract_email_contact ul.multiselect-container li input[value='"+staff_id+"']");
			input.parents("li").attr("style", "display:none");
			if (input.is(':checked')){
				input.trigger('click');
			}
		}

	});
	
	//update contracts
	$("div#edit_contract_email_contact ul.multiselect-container li").each(function(){
		if(!($(this).attr('class') == "active")){
			$(this).attr("style", "display:none");
		}
	});
	$("#edit-contract-submit-btn").click(function(){
		if($("#edit_contract_staff .multiselect-selected-text:first").text()=="None selected") {alert("Ju lutem selektoni të paktën një përdorues nga stafi."); return false;}
		if($("#edit_contract_email_contact .multiselect .multiselect-selected-text:first").text()=="None selected") {alert("Ju lutem percaktoni të paktën një email."); return false;}
	});	
	
	$("div#edit_contract_staff ul.multiselect-container li input").not(":first").click(function(){
		var staff_id = $(this).val();
		if($(this).parents('li').attr("class")!="active"){
			var input = $("div#edit_contract_email_contact ul.multiselect-container li input[value='"+staff_id+"']");
			input.parents("li").removeAttr("style");
		}
		else{
			var input = $("div#edit_contract_email_contact ul.multiselect-container li input[value='"+staff_id+"']");
			input.parents("li").attr("style", "display:none");
			if (input.is(':checked')){
				input.trigger('click');
			}
		}

	});

	
	
	
	// company-contract-for-client profile_functions
		$("div#show-hide-kontrata ul.multiselect-container li").each(function(){
			$(this).hide();
		});
		$("#select_company_manage_users").change( function(){
			var contracts = $(this).find(":selected").attr('contracts'); 
			var contract_ids;
			if(contracts) {
				contract_ids = contracts.split(",");
			} else {
				contract_ids = ['0'];
			}
			$("div#show-hide-kontrata ul.multiselect-container li").each(function(){
				$(this).hide();
				var input = $(this).find('input');
				if (input.is(':checked')){
					input.trigger('click');
				}
			});
			for (index = 0; index < contract_ids.length; ++index) {
				var el = $("div#show-hide-kontrata ul.multiselect-container li input[value='"+contract_ids[index]+"']");
				el.parents("li").attr("style", "display:block");

			}
		});	
		
	});


// Check for control project_code, department_code:
$(document).ready(function() {
	$("#project-button").click(function(){
		var exist = false;
		$(".manage-projects-table tr.project-row-identification td.project-code-identification").each(function(){
			if($("#form-project-code").val()==$(this).html()){
				alert('Set another code for project!\n\nVendosni nje kod te ndryshem per projektin!');
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
				alert('Set another code for department!\n\nVendosni nje kod te ndryshem per departamentin!');
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
	$("#company-button").click(function(){
		var exist = false;
		$(".manage-company-table tr.company-row-identification td.company-code-identification").each(function(){
			if($("#company-row-input").val().toLowerCase()==$(this).html().toLowerCase()){
				alert('You already have a company with that NAME! Set another NAME for company!\n\nKompania me kete EMER ekziston. Vendosni nje EMER tjeter per te vazhduar!');
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
 
$(function(){
	$("div.ticket-list tr:not(:first)").addClass("hidden");
	$("div.ticket-list tr:lt(11):gt(0)").removeClass("hidden");
	var index = 0;
	$("ul.pagination li.number").click(function(){
		$("tr:not(:first)").addClass("hidden");
		index = $(this).attr("data-item");
		var lt = index*10+11; 
		var gt = index*10;
		$("tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
		$("li.number a").css("background", "white");
		$("li.number[data-item="+index+"] a").css("background", "#ccc");		
	});
	$("li.prev-pag").click(function(){
		if(index==0) return false;
		else {
			$("tr:not(:first)").addClass("hidden");
			index--;
			var lt = index*10+11; 
			var gt = index*10;
			$("tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.number a").css("background", "white");
			$("li.number[data-item="+index+"] a").css("background", "#ccc");
			
		}
	});
	$("li.next-pag").click(function(){
		if(index==$("li.number").length) { return false; }
		else {
			$("tr:not(:first)").addClass("hidden");
			index++;
			var lt = index*10+11; 
			var gt = index*10;
			$("tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.number a").css("background", "white");
			$("li.number[data-item="+index+"] a").css("background", "#ccc");
		}
	});
	
	//per faqet e tjera
	$(".add-pagination tr:not(:first)").addClass("hidden");
	$(".add-pagination tr:lt(6):gt(0)").removeClass("hidden");
	var index = 0;
	$("ul.pagination li.contract-list").click(function(){
		$(".add-pagination tr:not(:first)").addClass("hidden");
		index = $(this).attr("data-item");
		var lt = index*5+6; 
		var gt = index*5;
		$(".add-pagination tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
		$("li.contract-list a").css("background", "white");
		$("li.contract-list[data-item="+index+"] a").css("background", "#ccc");		
	});
	$("li.prev-pag-list").click(function(){
		if(index==0) return false;
		else {
			$(".add-pagination tr:not(:first)").addClass("hidden");
			index--;
			var lt = index*5+6; 
			var gt = index*5;
			$(".add-pagination tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.contract-list a").css("background", "white");
			$("li.contract-list[data-item="+index+"] a").css("background", "#ccc");
			
		}
	});
	$("li.next-pag-list").click(function(){
		if(index==$("li.contract-list").length) { return false; }
		else {
			$(".add-pagination tr:not(:first)").addClass("hidden");
			index++;
			var lt = index*5+6; 
			var gt = index*5;
			$(".add-pagination tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.contract-list a").css("background", "white");
			$("li.contract-list[data-item="+index+"] a").css("background", "#ccc");
		}
	});	
	
	
	//per klientet
	$(".add-pagination-client tr:not(:first)").addClass("hidden");
	$(".add-pagination-client tr:lt(6):gt(0)").removeClass("hidden");
	var index = 0;
	$("ul.pagination li.client-list").click(function(){
		$(".add-pagination-client tr:not(:first)").addClass("hidden");
		index = $(this).attr("data-item");
		var lt = index*5+6; 
		var gt = index*5;
		$(".add-pagination-client tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
		$("li.client-list a").css("background", "white");
		$("li.client-list[data-item="+index+"] a").css("background", "#ccc");		
	});
	$("li.prev-pag-client").click(function(){
		if(index==0) return false;
		else {
			$(".add-pagination-client tr:not(:first)").addClass("hidden");
			index--;
			var lt = index*5+6; 
			var gt = index*5;
			$(".add-pagination-client tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.client-list a").css("background", "white");
			$("li.client-list[data-item="+index+"] a").css("background", "#ccc");
			
		}
	});
	$("li.next-pag-client").click(function(){
		if(index==$("li.client-list").length) { return false; }
		else {
			$(".add-pagination-client tr:not(:first)").addClass("hidden");
			index++;
			var lt = index*5+6; 
			var gt = index*5;
			$(".add-pagination-client tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.client-list a").css("background", "white");
			$("li.client-list[data-item="+index+"] a").css("background", "#ccc");
		}
	});	
	
	//per projektet
	$(".add-pagination-project tr:not(:first)").addClass("hidden");
	$(".add-pagination-project tr:lt(6):gt(0)").removeClass("hidden");
	var index = 0;
	$("ul.pagination li.project-list").click(function(){
		$(".add-pagination-project tr:not(:first)").addClass("hidden");
		index = $(this).attr("data-item");
		var lt = index*5+6; 
		var gt = index*5;
		$(".add-pagination-project tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
		$("li.project-list a").css("background", "white");
		$("li.project-list[data-item="+index+"] a").css("background", "#ccc");		
	});
	$("li.prev-pag-project").click(function(){
		if(index==0) return false;
		else {
			$(".add-pagination-project tr:not(:first)").addClass("hidden");
			index--;
			var lt = index*5+6; 
			var gt = index*5;
			$(".add-pagination-project tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.project-list a").css("background", "white");
			$("li.project-list[data-item="+index+"] a").css("background", "#ccc");
			
		}
	});
	$("li.next-pag-project").click(function(){
		if(index==$("li.project-list").length) { return false; }
		else {
			$(".add-pagination-project tr:not(:first)").addClass("hidden");
			index++;
			var lt = index*5+6; 
			var gt = index*5;
			$(".add-pagination-project tr:lt("+lt+"):gt("+gt+")").removeClass("hidden");
			$("li.project-list a").css("background", "white");
			$("li.project-list[data-item="+index+"] a").css("background", "#ccc");
		}
	});	
});
