<style type="text/css">
  .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
      color: #ffffff;
      background-color: #009688;
      border-color: transparent;
      border-radius: 0;
  }
  .table-responsive-stack tr {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
}


.table-responsive-stack td,
.table-responsive-stack th {
   display:block;
/*      
   flex-grow | flex-shrink | flex-basis   */
   -ms-flex: 1 1 auto;
    flex: 1 1 auto;
}

.table-responsive-stack .table-responsive-stack-thead {
   font-weight: bold;
}

@media screen and (max-width: 768px) {
   .table-responsive-stack tr {
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
          -ms-flex-direction: column;
              flex-direction: column;
      border-bottom: 3px solid #ccc;
      display:block;
      
   }
   /*  IE9 FIX   */
   .table-responsive-stack td {
      float: left\9;
      width:100%;
   }
}
.card{
  padding: 10px;
  border-radius: 0;
}


</style>
<div class="card">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#rest_api" role="tab">REST API</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#legacy_api" role="tab">Legacy API(for Android v1.1.4 or Old)</a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">

    <div class="tab-pane active" id="rest_api" role="tabpanel">
      <div class="form-group row">
        <label class="col-sm-3 control-label"><strong>API SERVER URL FOR APP</strong></label>
        <div class="col-sm-9">
          <textarea rows="2" id="api_v100_url" name="business_address" onclick="copyToClipboard('api_v100_url')" class="form-control"><?php echo base_url('rest-api/'); ?></textarea>
          <p><small>Copy &amp; paste this URL to App Source Code.</small></p>
        </div>
      </div>
        <div class="form-group row">
          <label class="col-sm-3 control-label"><strong>API KEY FOR APP</strong></label>
          <div class="col-sm-6">
            <input type="text"  value="<?php echo $key->key; ?>" id="api_v100_key" onclick="copyToClipboard('api_v100_key')" name="mobile_apps_api_secret_key" class="form-control" required data-parsley-length="[14, 128]" />
          </div>
            <div class="col-sm-3">
              <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/upgate_api_key/'.$key->id); ?>">Create New Key</a>
            </div>        
        </div>
    </div>
    <div class="tab-pane" id="legacy_api" role="tabpanel">
      <?php echo form_open(base_url() . 'admin/api_setting/update_legacy_api/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
      <div class="form-group row">
        <label class="col-sm-3 control-label"><strong>API URL FOR ANDROID</strong></label>
        <div class="col-sm-9">
          <input type="text"  value="<?php echo base_url('api/') ?>" readonly class="form-control" required data-parsley-length="[14, 128]" />
          <p><small>Copy &amp; paste this URL to Android Source Code.</small></p>
        </div>
      </div>          

      <div class="form-group row">
        <label class="col-sm-3 control-label"><strong>API KEY FOR ANDROID</strong></label>
        <div class="col-sm-6">
          <input type="text"  value="<?php echo $this->db->get_where('config' , array('title' =>'mobile_apps_api_secret_key'))->row()->value;?>" name="mobile_apps_api_secret_key" class="form-control" required data-parsley-length="[14, 128]" />
        </div>
        <div class="col-sm-3">
          <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/regenerate_mobile_secret_key'); ?>">Create New Key</a>
        </div>
      </div>

      <div class="col-sm-offset-3 col-sm-9 m-t-15">
        <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>save changes </button>
      </div>
     <?php echo form_close(); ?>
    </div>
  </div>           
  <!-- panel  -->    
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script> 

<!-- file select--> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script> 
<!-- file select-->


<script type="text/javascript">
  $(document).ready(function() {

   
   // inspired by http://jsfiddle.net/arunpjohny/564Lxosz/1/
   $('.table-responsive-stack').find("th").each(function (i) {
      
      $('.table-responsive-stack td:nth-child(' + (i + 1) + ')').prepend('<span class="table-responsive-stack-thead">'+ $(this).text() + ':</span> ');
      $('.table-responsive-stack-thead').hide();
   });

   
   
   
   
$( '.table-responsive-stack' ).each(function() {
  var thCount = $(this).find("th").length; 
   var rowGrow = 100 / thCount + '%';
   //console.log(rowGrow);
   $(this).find("th, td").css('flex-basis', rowGrow);   
});
   
   
   
   
function flexTable(){
   if ($(window).width() < 768) {
      
   $(".table-responsive-stack").each(function (i) {
      $(this).find(".table-responsive-stack-thead").show();
      $(this).find('thead').hide();
   });
      
    
   // window is less than 768px   
   } else {
      
      
   $(".table-responsive-stack").each(function (i) {
      $(this).find(".table-responsive-stack-thead").hide();
      $(this).find('thead').show();
   });
      
      

   }
// flextable   
}      
 
flexTable();
   
window.onresize = function(event) {
    flexTable();
};
});
</script>
<script type="text/javascript">
  function copyToClipboard(element) {
    var copyText = document.getElementById(element);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    swal("Copied!", copyText.value+'\nNow just paste into android configuration file', 'success');
    //alert("Copied the text: " + copyText.value);
  }
</script>

