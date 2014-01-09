<?php
add_filter( 'wp_generate_attachment_metadata', 'wtc_after_upload', 10, 2 );

function wtc_after_upload($metadata, $attachment_id) {    
	$wtc_ajax_admin=new wtc_ajax_admin;
    $upload_dir = wp_upload_dir();
    $params='';
    $wtc_media_compress='';
        
    $wtc_media_compress=get_option('wtc_media_compress');
    
    $img_id='';
    if (!empty($attachment_id)){
        $img_id=$attachment_id;
    } 
        
    if ($wtc_media_compress==1):    
	    if (is_array($metadata) && count($metadata)>=1){
	    	$main_image=$metadata['file']; 
	    	  	
	    	$params['file_path']=$upload_dir['basedir']."/".$main_image;
	    	$params['img_id']=$img_id;	    	
	    	$wtc_ajax_admin->data=$params;
	    	$wtc_ajax_admin->compress_single_image();  
	    	$params='';
	    	    	
	    	$filename=$wtc_ajax_admin->get_filename($main_image);    	
	    	$path=str_replace($filename,'',$main_image); 
	    	    	    	
	    	if (isset($metadata['sizes']['thumbnail']['file'])){
	    	   $img_crop=$metadata['sizes']['thumbnail']['file'];    	
	    	   $image_crop=$upload_dir['basedir']."/$path".$img_crop; 		    	   
	    	   
	    	   $params='';
	    	   $params['file_path']=$image_crop;
	    	   $params['img_id']=$img_id;	    	
	    	   $wtc_ajax_admin->data=$params;
	    	   $wtc_ajax_admin->compress_single_image();  
	    	   
	    	}    	
	    	
	    	if (isset($metadata['sizes']['medium']['file'])){
	    		$image_crop=$metadata['sizes']['medium']['file'];
	    		$image_crop=$upload_dir['basedir']."/$path".$image_crop; 		    		
	    		
	    		$params='';
	    	    $params['file_path']=$image_crop;
	    	    $params['img_id']=$img_id;	    	
	    	    $wtc_ajax_admin->data=$params;
	    	    $wtc_ajax_admin->compress_single_image();  
	    	}	    	
	    	
	    	if (isset($metadata['sizes']['large']['file'])){
	    		$image_crop=$metadata['sizes']['large']['file'];
	    		$image_crop=$upload_dir['basedir']."/$path".$image_crop; 		    		
	    		
	    		$params='';
	    	    $params['file_path']=$image_crop;
	    	    $params['img_id']=$img_id;	    	
	    	    $wtc_ajax_admin->data=$params;
	    	    $wtc_ajax_admin->compress_single_image();  
	    	}	    	
	    	
	    	if (isset($metadata['sizes']['post-thumbnail']['file'])){
	    		$image_crop=$metadata['sizes']['post-thumbnail']['file'];
	    		$image_crop=$upload_dir['basedir']."/$path".$image_crop; 		    		
	    		
	    		$params='';
	    	    $params['file_path']=$image_crop;
	    	    $params['img_id']=$img_id;	    	
	    	    $wtc_ajax_admin->data=$params;
	    	    $wtc_ajax_admin->compress_single_image();  
	    	}
	    }
    endif;
    return $metadata;    
}

add_filter( 'manage_media_columns', 'wtc_column' );
add_action( 'manage_media_custom_column', 'wtc_value', 10, 2 );

function wtc_column( $cols ) {
        $cols["dimensions"] = "Compress Result";
        return $cols;
}

function wtc_value( $column_name, $id ) {
	$img_id='';
	if (!empty($id)){
		$img_id="$id-";
	}		
	$wtc_ajax_admin=new wtc_ajax_admin;
	$upload_dir = wp_upload_dir();
    $meta = wp_get_attachment_metadata($id);
    $file_path=$upload_dir['basedir']."/".$meta['file']; 
    $file_name=$wtc_ajax_admin->get_filename($file_path);
    if (file_exists(WTC_FILE_DIR."/$img_id$file_name")){
    	print "Original Size:".$wtc_ajax_admin->file_size_convert(filesize(WTC_FILE_DIR."/$img_id$file_name"));
    	print '<br/>';
    	print "Compress Size: ".$wtc_ajax_admin->file_size_convert(filesize($file_path));
    	print "<p><a id=\"$id\" class=\"wtc_media_restore\" rev=\"$file_path\" href=\"javascript:;\">Restore Image</a></p>";    	
    } else {    
    	print "<a id=\"$id\" class=\"wtc_media\" rev=\"$file_path\" href=\"javascript:;\">Compress Image</a>";    	
    }
}

/*add_action('add_attachment', 'attachment_manipulation');

function attachment_manipulation($id)
{	
}*/

add_action('delete_attachment','wtc_delete_attachment');

function wtc_delete_attachment($id='')
{	
	$wtc_ajax_admin=new wtc_ajax_admin;
	$path=get_attached_file($id); 
	$file_name=$wtc_ajax_admin->get_filename($path);		
	//echo WTC_FILE_DIR."/$id-$file_name";
	if (file_exists(WTC_FILE_DIR."/$id-$file_name")){
		@unlink(WTC_FILE_DIR."/$id-$file_name");
	}	
}