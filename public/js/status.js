/**
*
* Status Controller - V1.0 (01/08/2014)
*
**/
jQuery(document).ready(function(){
	jQuery(".change-status").on("click",function(e){
		e.preventDefault();
		action=jQuery(this).attr('data-action');
		channel_id=jQuery(this).attr('data-channel');
		jQuery("#form-update-status-channel").attr('data-item',channel_id);
		jQuery.post(action,{channel_id:channel_id},
		    function(valor){
		       	jQuery("#channel-status").html(valor);
		})
		return true;
	});
	jQuery("#update-status-channel").on("click",function(e){
		e.preventDefault();
		form=jQuery("#form-update-status-channel");
		action=form.attr('action');
		link=form.attr('data-link');
		channel_id=form.attr('data-item');
		status=jQuery("#channel-status").val();
		jQuery.post(action,{channel_id:channel_id,status:status},
		    function(valor){
		    	panel = jQuery("#feedback").children("div");
		       	if(valor == 1)
		       		location.href=link;
		       	else{
		       		panel.html('Oops! The status has not been updated, check the information sent!');
		       		jQuery("#feedback").removeClass("hide").fadeIn();
		       	}
		       	
		})
	})
})