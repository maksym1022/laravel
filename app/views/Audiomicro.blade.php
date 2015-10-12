@extends('templates.main')
@section('content') 
<div class="page-header">
	  <h1>Epidemic Music <small>:: Tracks of audio or video storages licensed to you</small></h1>
	</div>	

                            <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Royalty free music practices:</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-chevron-down"></i>
                                    
                                </div>
                            </div>
                            <div class="panel-body">
                              Remember to always put the video description the following code:<br>

"Royalty free music provided by CMS NSTV Music/Video and AudioMicro"
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Emergency cases:</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-chevron-down"></i>
                                    
                                </div>
                            </div>
                            <div class="panel-body">
                              In case of receiving copyright strikes or copyright flags, remember to notify us as soon as possible so that we can remove any irregularities in your channel.
                            </div>
                        </div>
                    </div>
                           
                               
            <table class="table table-striped table-bordered">
		      <tr class="head">
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Play / Preview</th>
                <th>Download</th>
             </tr>
            <?php if(count($musicas) > 0): 
            foreach ($musicas as $music): ?>
            <tr>
    			<td><?=$music->id;?></td>
    			<td><?=$music->title;?></td>
    			<td><?=$music->description; ?></td>
    			<td><a href="#formModal" class="play-preview" data-music="<?=$music->play_link; ?>" data-toggle="modal"><strong>Preview </strong></a></td>
    			<td><a href="<?=$music->download_link; ?>" download="<?=$music->download_link; ?>"><strong>Download</strong></a></td>
		  </tr>
             <?php endforeach; 
             endif; ?>
	</table>
    <!-- formModal email -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> Preview</h4>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="panel panel-danger hide" id="feedback">
                  <div class="panel-heading">
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery(".play-preview").on("click",function(e){
                e.preventDefault();
                jQuery('.modal-body').html('<iframe width="100%" height="100%" style="background: #000" border="0" src="'+jQuery(this).attr('data-music')+'"></iframe>');
                return true;
            });
            jQuery(".modal-footer button").on("click",function(e){
                e.preventDefault();
                jQuery('.modal-body').html('');
                return true;
             });
        });
    </script>
@stop    