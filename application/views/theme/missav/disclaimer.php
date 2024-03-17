<?php
	$disclaimer_text_enable                        	=   $this->db->get_where('config' , array('title'=>'disclaimer_text_enable'))->row()->value; 
	$disclaimer_text                        		=   $this->db->get_where('config' , array('title'=>'disclaimer_text'))->row()->value;
	if($disclaimer_text_enable == '1'):
?>
<div class="alert alert-success m-t-10"><?php echo $disclaimer_text; ?></div>
<?php endif; ?>