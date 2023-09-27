$(document).ready(function(){


	$('body').on('click','button', function () {

	if ($(this).attr('id')=='modalButton'){
	$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
		}


		else if ($(this).attr('id')=='modalTratativa'){
	$('#modal2').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
		}


	});







	$('.ckAll').on('change', function () {
	var chk = $(this).prop( "checked");
	//alert (chk);
	if(chk==true){

	    $('input:checkbox').prop("checked", true);

	    }
	else if(chk==false){

	    $('input:checkbox').prop("checked", false);

	    }


	});

});

	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
;