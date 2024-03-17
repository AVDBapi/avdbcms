<?php    
    $dmca_content              =   $this->db->get_where('config' , array('title'=>'dmca_content'))->row()->value;;
?>
<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase">
                        <?php echo trans('dmca'); ?>
                    </h1>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans('home'); ?></a>
                    </li>
                    <li>Page</li>
                    <li class="active"><?php echo trans('dmca'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<div id="section-opt">
	<div class="container">

	<?php echo $dmca_content;?>
	</div>
</div>