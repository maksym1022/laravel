
    <div class="page-header">
        {{ Form::open(array('url' => 'analytics/showGraphic','class'=>'form-horizontal') ) }}
			 <h1>
			  	Analytics <small>:: Overall statistics channels.</small> <br>
			  	<small>
				  	<select style="padding: 1.2px 0;" name="channel_id" id="select_channel" required >
				  		<?php 
				  			foreach($channels as $channel){
				  				echo '<option '.((isset($channel_id) && $channel_id == $channel->id) ? 'selected="selected"' : '').' value="'.$channel->id.'">'.$channel->name.'</option>';
				  			}
				  		?>
				  	</select>
				  	<input type="submit" value="Show" class="btn btn-success">
			  	</small>
			  </h1>
		{{ Form::close() }}
	</div>