<?php
function wtc_settings()
{
	global $wtc_form;
	?>
	<div class="wrap" id="wtc_main_wrap">
	<div class="icon32" id="icon-options-general"><br></div>
	<h2>Settings</h2>
	
	<div id="wtc_tabs">
	<ul>
	 <li><a href="#tabs-1">Image Compression</a></li>
	 <li><a href="#tabs-2">HTML Compression</a></li>
	 <li><a href="#tabs-3">CSS Compression</a></li>
	</ul>
	  <div id="tabs-1">
	   <form method="POST" onsubmit="return false;" id="frm_wtc_provider">
	   <input type="hidden" name="do" value="wtc_provider">
	   
	   <h2>Media Library</h2>	
	   <div class="input_block">
	   <label>Auto compress media image?</label>
	   <?php echo $wtc_form->checkboxes('wtc_media_compress',1,(array)get_option('wtc_media_compress'))?>
	   <span>When check if will auto compress the media files when there is new upload.</span>
	   </div>	   
	   	   
	   <hr></hr>
	   
	   <h2>DietImage</h2>	
	   <div class="input_block">
	   <label>API Username</label>
	   <?php echo $wtc_form->text('diet_apiusername',get_option('diet_apiusername'))?>
	   </div>	   
	   	   
	   <div class="input_block">
	   <label>API Password</label>
	   <?php echo $wtc_form->text('diet_apipassword',get_option('diet_apipassword'))?>
	   </div>	   
	   
	   <div class="input_block">
	   <label>Set As Provider</label>
	   <?php echo $wtc_form->radioButton2('wtc_provider',3,get_option('wtc_provider'))?>
	   </div> 	   	   
	   
	   <div class="input_block">
	   <span class="info">	     
	     <b>DietImage</b> Free account. convert up to 500 images per month. Supports JPEG and PNG files.
	     <a  href="http://dietimage.com" target="_blank">Signup Now</a>
	   </span>
	   </div>  
	   
	   <hr></hr>
	   	   
	   
	   <div class="input_block">
	    <label></label>	 	 
	    <input type="submit" value="Save Changes" class="button button-primary">	 	 
	  </div>
	  </form>
	  </div> <!--END TAB1-->	
	  
	  <div id="tabs-2">
	  
	   <form method="POST" onsubmit="return false;" id="frm_wtc_compress">
	    <input type="hidden" name="do" value="wtc_compress_settings">
	   
	    <div class="input_block">
	    <label>Compress HTML</label>
	    <?php echo $wtc_form->checkboxes('wtc_compress_html',1,(array)get_option('wtc_compress_html'),
	    array('id'=>'wtc_compress_html'))?>
	    <span>When check it will compress your page HTML</span>
	    </div>
	    
	    <div class="input_block">
	    <label>Compress Inline CSS</label>
	    <?php echo $wtc_form->checkboxes('wtc_compress_css',1,(array)get_option('wtc_compress_css'),
	    array('id'=>'wtc_compress_css'))?>
	    <span>When check it will compress the inline CSS in your page.</span>
	    </div>
	    
	    <div class="input_block">
	    <label>Compress Inline Javascript</label>
	    <?php echo $wtc_form->checkboxes('wtc_compress_js',1,(array)get_option('wtc_compress_js'),
	    array('id'=>'wtc_compress_js'))?>
	    <span>When check it will compress your inline javascript.
	    Note: compressing inline javascript some javascript might not work properly.
	    </span>
	    </div>
	    	    	    
	    	    
	    <div class="input_block">
	    <label></label>	 	 
	    <input type="submit" value="Save Changes" class="button button-primary">	 	 
	    </div>
	    </form>
	    
	  </div> <!--END TAB2-->
	  
	  
	 <div id="tabs-3">
	  
	   <form method="POST" onsubmit="return false;" id="frm_wtc_compress_main_css">
	    <input type="hidden" name="do" value="wtc_compress_main_css">
	   
	    <div class="input_block">
	    <label>Compress CSS</label>
	    <?php echo $wtc_form->checkboxes('wtc_compress_main_css',1,(array)get_option('wtc_compress_main_css'),
	    array('id'=>'wtc_compress_html'))?>
	    <span>This will compress the style.css of your template.</span>
	    </div>
	    	    
	    	    
	    <div class="input_block">
	    <label></label>	 	 
	    <input type="submit" value="Save Changes" class="button button-primary">	 	 
	    </div>
	    </form>
	    
	  </div> <!--END TAB3-->
	    
	</div> <!--wtc_tabs-->
    
	</div> <!--END wrap-->	
	<?php	
}