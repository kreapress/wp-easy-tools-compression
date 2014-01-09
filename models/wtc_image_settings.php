<?php
function wtc_image_settings()
{
	global $wtc_form;
	?>
	<div class="wrap" id="wtc_main_wrap">
	<div class="icon32" id="icon-options-general"><br></div>
	<h2>Image Compression</h2>
	
	<input type="hidden" name="current_tab" id="current_tab" value="0">
	<div id="wtc_tabs">
	<ul>
	 <li><a href="#tabs-1">Media Library</a></li>
	 <li><a href="#tabs-2">Themes</a></li>	 
	</ul>
	  <div id="tabs-2">
	   <form method="POST" onsubmit="return false;" id="wtc_list_file">
	     <input type="hidden" name="do" value="wtc_list_file">
	     <input type="hidden" name="current_folder" id="current_folder">
	     <table id="wtc_list_file_table" border="0" cellpadding="0" cellspacing="0">	
	     <thead>
	     <tr>	
	      <th></th>      
	      <th>Name</th>
	      <th>Type</th>
	      <th>Original Size</th>
	      <th>Compress Size</th>
	      <th class="center">Compress<br/><input type="checkbox" id="wtc_chek_all_parent"></th>
	      <th class="center">Restore<br/><input type="checkbox" id="wtc_restore_all_parent"></th>
	     </tr>  
	     </thead>   	     
	     </table>
	     <div style="padding-top:10px;">
	     <input type="submit" value="Compress Image" id="wtc_compress_img" class="button button-primary">
	     <input type="submit" value="Restore Image" id="wtc_restore_img" class="button button-primary">
	     </div>
	  </form>
	  </div> <!--END TAB2-->	
	  
	  <div id="tabs-1">
	   <form method="POST" onsubmit="return false;" id="wtc_media_list">
	     <input type="hidden" name="do" value="wtc_media_list">	     
	     <table id="wtc_media_list_table" border="0" cellpadding="0" cellspacing="0">	
	     <thead>
	     <tr>
	      <th></th>
	      <th>Name</th>
	      <th>Type</th>
	      <th>Original Size</th>
	      <th>Compress Size</th>
	      <th align="center" class="center">Compress<br/><input type="checkbox" id="wtc_compress_all"></th>
	      <th align="center" class="center">Restore<br/><input type="checkbox" id="wtc_restore_all"></th>
	     </tr>  
	     </thead>   	     
	     </table>
	     <div style="padding-top:10px;">
	     <input type="submit" value="Compress Image" id="compress_btn"  class="button button-primary">
	     <input type="submit" value="Restore Image"  id="restore_btn" class="button button-primary">
	     </div>
	  </form>
	  </div> <!--END TAB 1-->
	  	  	    
	</div> <!--wtc_tabs-->
    
	</div> <!--END wrap-->	
	<?php		
}