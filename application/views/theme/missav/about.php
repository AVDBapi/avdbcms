<?php    
    $about_us_enable                =   $this->db->get_where('config' , array('title'=>'about_us_enable'))->row()->value;
    $about_us_title                 =   $this->db->get_where('config' , array('title'=>'about_us_title'))->row()->value;
    $about_us_text                  =   $this->db->get_where('config' , array('title'=>'about_us_text'))->row()->value;
?>
<?php if($about_us_enable =='1'): ?>
<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase">
                        <?php echo $about_us_title;?>
                    </h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url();?>">
                            <i class="fi ion-ios-home"></i><?php echo trans('home'); ?>
                        </a>
                    </li>
                    <li class="active"><?php echo trans('about_us'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->


<div class="container m-t-50 m-b-50">
    <?php echo $about_us_text;?>
</div>
<?php else: redirect('error'); endif; ?>