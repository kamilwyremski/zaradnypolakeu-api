$(document).ready(function(){
	$('#select_action').change(function(){
		var val = $(this).val();
		$('.box_action').hide().find('input').prop('disabled',true);
		if(val=='show_offer'){
			$('#box_offer_id').show().find('input').prop('disabled',false);
		}else if(val=='list_offers'){
			$('#box_page').show().find('input').prop('disabled',false);
		}
	})
})