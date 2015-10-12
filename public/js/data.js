/**
*
* Data Controller - V1.0 (27/06/2014)
* Data Controller - V2.0 (04/07/2014)
*
**/
jQuery(document).ready(function(){
	jQuery("#generate-button").on("click",function(e){
		e.preventDefault();
		parent=jQuery(this).parent();
		jQuery.get(jQuery(this).attr('href'), function(data) {
			if(data != 0){
				parent.append('<a href="'+data+'" target="_blank" class="btn btn-success"><span class="glyphicon glyphicon-download"></span> Download File</a>');
			}else alert('Error! The export file was not generated!');
		});
	})
	jQuery(".dataTables_filter label input").addClass("form-control");
	jQuery(".dataTables_filter label input").attr("placeholder","Enter value to search");
	jQuery(".finished").on("click",function(e){
		e.preventDefault();
	});
	jQuery(".finished").dblclick(function(e){
		e.preventDefault();
		alert("Oops! Payment already finalized");
	});
	jQuery(".finish-channel,.finish-hub").on("click",function(e){
		e.preventDefault();
		parent=jQuery(this).closest("td");
		place=parent.next();
		jQuery.get(jQuery(this).attr('href'), function(data) {
			if(data != 0){
				parent.html('<a href="javascript:;" class="btn btn-sm btn-success finished">Finished</a>');
				place.html('<span class="label label-success">Paid</span><br />'+data);
			}else alert('Error! Payment not finished!');
		});
	});
})