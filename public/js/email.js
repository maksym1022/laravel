/**
*
* E-mail Controller - V1.0 (17/08/2014)
*
**/
jQuery(document).ready(function(){
	jQuery(".send-email").on("click",function(e){
		e.preventDefault();
		channel_id=jQuery(this).attr('data-channel');
		//VERIFICAR SE ESTÁ INSERINDO O NÚMERO COM ISNAN()
		if(!isNaN(channel_id)){
			form=jQuery('#form-send-email');
			action=form.attr('action');
			form.attr('action',action+channel_id);
			form.attr('data-channel',channel_id);
			return true;
		}else{
			alert('Error! Invalid Channel Id');
		}
	});
	jQuery("#send-email-start").on("click",function(e){
		e.preventDefault();
		form=jQuery('#form-send-email');
		action=form.attr('action');
		link=form.attr('data-link');
		//Data
		channel_id=form.attr('data-channel');
		subject=jQuery("#subject").val();
		//message=jQuery("#message").val();
		message = CKEDITOR.instances['message'].getData();
		jQuery.post(action,{channel_id:channel_id,subject:subject,message:message},
		    function(valor){
		    	panel = jQuery("#feedback").children("div");
		    	console.log(valor);
		       	if(valor == 1)
		       		location.href=link;
		       	else{
		       		panel.html('Oops! The e-mail was not sent, check the information and try again!');
		       		jQuery("#feedback").removeClass("hide").fadeIn();
		       	}
		       	
		})
	})
	jQuery(".generate-csv").on("click",function(e){
		e.preventDefault();
		parent=jQuery(this).parent().parent();
		container=parent.parent();
		jQuery('.btn-group a.btn-danger').removeClass('btn-danger');
		jQuery.get(jQuery(this).attr('href'), function(data) {
			if(data != 0){
				parent.append('<li><a href="'+data+'" target="_blank" class="btn btn-success"><span class="glyphicon glyphicon-download"></span> Download File</a></li>');
				container.addClass('open');
				parent.fadeIn();
				container.children(".btn-sm").removeClass('btn-success').addClass('btn-danger');
				jQuery(this).parent().click();
			}else alert('Error! The export file was not generated!');
		});
	})
	/**
	*
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
	*
	**/	
	
})