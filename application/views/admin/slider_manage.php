<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <button data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/slider_add';?>" id="menu" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Slider</button>
            <br>
            <br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Sort Order</th>                        
                        <th>Action</th>
                        <th>Action Button Text</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sl = 1; foreach ($sliders as $slider):?>
                    <tr id='row_<?php echo $slider['slider_id'];?>'>
                        <td><?php echo $sl++;?></td>
                        <td><strong><?php echo $slider['title'];?></strong></td>
                        <td><?php echo $slider['description'];?></td>
                        <td><?php echo $slider['order'];?></td>                       
                        <td>
                            <?php 
                                if($slider['action_type'] == 'movie'):
                                    echo "Movie: " .$this->common_model->get_title_by_videos_id($slider['action_id']);
                                elseif($slider['action_type'] == 'tvseries'):
                                    echo "TVSeries: " .$this->common_model->get_title_by_videos_id($slider['action_id']);
                                elseif($slider['action_type'] == 'tv'):
                                    echo "TV Channel: " .$this->live_tv_model->get_live_tv_title_by_id($slider['action_id']);
                                elseif($slider['action_type'] == 'external_browser'):
                                    echo "External URL: " .$slider['action_url'];
                                elseif($slider['action_type'] == 'webview'):
                                    echo "WebView URL: " .$slider['action_url'];
                                endif;
                            ?>
                                
                        </td>
                        <td><?php echo $slider['action_btn_text'];?></td>
                        <td>
                            <?php
                            if($slider['publication']=='1'){
                                echo '<span class="label label-primary label-xs">Published</span>';
                            }
                            else{
                                echo '<span class="label label-warning label-mini">Unublished</span>';
                            }

                                ?>
                        </td>                                    
                        <td>
                            <div class="btn-group m-b-20"> <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/slider_edit/'. $slider['slider_id'];?>" id="menu" title="Edit" class="btn btn-icon"><i class="fa fa-pencil"></i></a> <a title="Delete" class="btn btn-icon" onclick="delete_row(<?php echo " 'slider' ".','.$slider['slider_id'];?>)" class="delete"><i class="fa fa-remove"></i></a> </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
    });
</script>
