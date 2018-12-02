$(document).ready(function(){
	$('#select_action').change(function(){
		var val = $(this).val();
		$('.box_action').hide().find('input,textarea').prop('disabled',true);
		if(val=='show_offer'){
			$('#box_offer_id').show().find('input,textarea').prop('disabled',false);
		}else if(val=='list_offers'){
			$('#box_page').show().find('input,textarea').prop('disabled',false);
		}else if(val=='add_offer'){
			$('#box_add').show().find('input,textarea').prop('disabled',false);
		}else if(val=='edit_offer'){
			$('#box_add').show().find('input,textarea').prop('disabled',false);
			$('#box_offer_id').show().find('input,textarea').prop('disabled',false);
		}else if(val=='remove_offer'){
			$('#box_offer_id').show().find('input,textarea').prop('disabled',false);
		}else if(val=='list_categories'){
			$('#box_category_id').show().find('input,textarea').prop('disabled',false);
		}else if(val=='list_states'){
			$('#box_state').show().find('input,textarea').prop('disabled',false);
		}
	})
})