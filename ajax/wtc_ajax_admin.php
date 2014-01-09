<?php
function wtc_ajax_admin()
{	
	if (isset($_GET['action'])){
		$data=$_GET;		
	} else $data=$_POST;	
	$class=new wtc_ajax_admin();
	$class->data=$data;
	if (method_exists($class,$data['do'])){
		$class->$data['do']();
	} else $class->msg='Method not exist ' . $data['do'];
	echo $class->output();
	die();
}

if (!class_exists('wtc_ajax_admin'))
{
	class wtc_ajax_admin
	{
		public $data;
		public $code=2;
		public $msg;
		public $details;
		
		public function otable_nodata()
		{
	        $feed_data['sEcho']=1;
	        $feed_data['iTotalRecords']=0;
	        $feed_data['iTotalDisplayRecords']=0;
	        $feed_data['aaData']=array();		
	        echo json_encode($feed_data);
	    	die();
		}
    
		public function otable_output($feed_data='')
		{
    	  echo json_encode($feed_data);
    	  die();
        }
        
        public function output($debug=FALSE)
		{
    	    $resp=array('code'=>$this->code,'msg'=>$this->msg,'details'=>$this->details);
    	    if ($debug){
    		    dump($resp);
    	    }
    	    return json_encode($resp);    	    
		}
		
		public function wtc_provider()
		{
			global $wtc_validator;			
			if (!isset($this->data['tinypng_apikey'])){
				$this->data['tinypng_apikey']='';
			}
			if (!isset($this->data['kraken_apikey'])){
				$this->data['kraken_apikey']='';
			}
			if (!isset($this->data['kraken_secretkey'])){
				$this->data['kraken_secretkey']='';
			}
			
			if (!isset($this->data['diet_apiusername'])){
				$this->data['diet_apiusername']='';
			}
			if (!isset($this->data['diet_apipassword'])){
				$this->data['diet_apipassword']='';
			}
			if (!isset($this->data['wtc_media_compress'])){
				$this->data['wtc_media_compress']='';
			}
			
			$req=array(
			   'wtc_provider'=>'Image provider is required'
			);
			$wtc_validator->required($req,$this->data);
			if ($wtc_validator->validate()){
				update_option('diet_apiusername',$this->data['diet_apiusername']);
				update_option('diet_apipassword',$this->data['diet_apipassword']);
				update_option('wtc_provider',$this->data['wtc_provider']);
				update_option('tinypng_apikey',$this->data['tinypng_apikey']);
				update_option('kraken_apikey',$this->data['kraken_apikey']);
				update_option('kraken_secretkey',$this->data['kraken_secretkey']);
				update_option('wtc_media_compress',$this->data['wtc_media_compress']);
				$this->code=1;
				$this->msg='Successfully updated.';
			} else $this->msg=$wtc_validator->getErrorAsHTML();
		}
		
		public function wtc_list_file()
		{			
			//dump($this->data);
			$upload_dir = wp_upload_dir();
			$file_list='';			
			if (isset($this->data['folder']) && !empty($this->data['folder'])){
			    $default_image_path=stripslashes($this->data['folder']);			    
			    $parent_folder=dirname($default_image_path);			    
			    $t1=explode("/",$parent_folder);
			    $t1_count=count($t1);
			    if (!empty($parent_folder)){
			    	$file_list[]=array(
	   	   	   	     'file_type'=>'directory',
	   	   	   	     'file_path'=>$parent_folder,
	   	   	   	     'filename'=>$t1[$t1_count-1],
	   	   	   	     'editable'=>'',
	   	   	   	     'filesize'=>'',
	   	   	   	     'compress_size'=>'',
	   	   	   	     'restore'=>''
		   	   	   	);
			    }
			} else $default_image_path=get_template_directory(); //$default_image_path=$upload_dir['basedir'];
			//ABSPATH."/wp-content/uploads";
			
			$upload_dir = wp_upload_dir();		    		    
		    
			$ext_allowed=array('jpg','jpeg','png','gif','folder');			
			$restore='';
	        $scanned_directory = array_diff(scandir($default_image_path), array('..', '.'));
		    if (is_array($scanned_directory) && count($scanned_directory)>=1){
		   	   foreach ($scanned_directory as $val) {	  
		   	   			   	   	   
		   	   	  $path_parts = pathinfo($default_image_path."/".$val);			   	   	  		   	   	  		   	   	  
		   	   	  if (!isset($path_parts['extension'])){
		   	   	  	  $path_parts['extension']='folder';
		   	   	  }
		   	   	  if (in_array($path_parts['extension'],$ext_allowed)):
		   	   	   if (is_dir($default_image_path."/".$val)){
		   	   	   	   if ($val!='wtc_images'){
		   	   	   	   $file_list[]=array(
		   	   	   	     'file_type'=>'directory',
		   	   	   	     'file_path'=>$default_image_path."/".$val,
		   	   	   	     'filename'=>$val,
		   	   	   	     'editable'=>'',
		   	   	   	     'filesize'=>'',
		   	   	   	     'compress_size'=>'',
		   	   	   	     'restore'=>''
		   	   	   	   );
		   	   	   	   }
		   	   	   } else {		   	   	   	   
		   	   	   	
		   	   	   	   $path_parts = pathinfo($default_image_path."/".$val);		   	   	   	   
		   	   	   	   $file_path=$default_image_path."/".$val;
		   	   	   	   if (in_array($path_parts['extension'],$ext_allowed)){		   	   	   	   	   
		   	   	   	       $editable="<input class=\"wtc_chek_all_child\" name=\"wtc_chk_images[]\" type=\"checkbox\" value=\"$file_path\" >";
		   	   	   	   } else {
		   	   	   	   	 $restore='';
		   	   	   	   	 $editable='';
		   	   	   	   }
		   	   	   	   
		   	   	   	    $file_compress_path='';		   	   	   	   
		   	   	   	    $compress_size='';
		   	   	   	    if (file_exists(WTC_FILE_DIR."/$val")){
		   	   	   	   	   $file_compress_path=WTC_FILE_DIR."/$val";
		   	   	   	   	   //$compress_size=$this->file_size_convert(@filesize($file_compress_path));	   	   
		   	   	   	   	   $compress_size=$this->file_size_convert(@filesize($file_path));
		   	   	   	   	   //$editable.="<a target=\"blank\" href=\"".WTC_FILE_URL."/$val\">View</a>";
		   	   	   	   	   //$editable.="<a target=\"blank\" href=\"".WTC_FILE_URL."/$val\">View</a>";
		   	   	   	   	   $file_size=$this->file_size_convert(@filesize($file_compress_path));
		   	   	   	   	   $editable='';
		   	   	   	   	   $restore="<input class=\"wtc_restore_chek_child\" name=\"wtc_restore_chk_images[]\" type=\"checkbox\" value=\"$file_path\" >";
		   	   	   	    } else {		   	   	
		   	   	   	    	$file_size=$this->file_size_convert(filesize($file_path));	
		   	   	   	    	$restore='';
		   	   	   	    }		   	   	   
		   	   	   	    
		   	   	   	    $image_prev=str_replace($upload_dir['basedir'],$upload_dir['baseurl'], str_replace("//","/",$file_path));	    
		   	   	   	    $image_preview="		   	   	   	    
		   	   	   	    <a href=\"$image_prev\" target=\"_blank\">
		   	   	   	    <img src=\"$image_prev\" alt=\"\" title=\"\" >
		   	   	   	    </a>
		   	   	   	    ";
		   	   	   	    
		   	   	   	    $file_list[]=array(
		   	   	   	     'file_path'=>$file_path,
		   	   	   	     'file_type'=>mime_content_type($file_path),
		   	   	   	     'filename'=>$val,
		   	   	   	     'editable'=>$editable,
		   	   	   	     //'filesize'=> $this->file_size_convert(filesize($file_path)),
		   	   	   	     'filesize'=>$file_size,
		   	   	   	     'compress_size'=>$compress_size,
		   	   	   	     'restore'=>$restore,
		   	   	   	     'image_preview'=>$image_preview
		   	   	   	   );
		   	   	   }
		   	   	   endif;
		   	   }	   	   
		    }		    
		    //dump($file_list);
		    $body='';
		    $header='';
		    $file='';
		    $x=0;
		    if (is_array($file_list) && count($file_list)){
		    	foreach ($file_list as $val_file) {		
		    		    		
		    		if ($val_file['file_type']=='directory'){		    			
		    			$file="<a href=\"javascript:;\" rev=\"$default_image_path\" class=\"wtc_directory\" rel=\"$val_file[file_path]\">".$val_file['filename']."</a>";			    			
		    		} else $file=$val_file['filename'];
		    				    		
		    		if (!isset($val_file['image_preview'])){
		    			$val_file['image_preview']='';
		    		}
		    		$body.="<tr class=\"wtc_data\">";
		    		$body.="<td align=\"center\">$val_file[image_preview]</td>";
		    		$body.="<td>$file</td>";
		    		$body.="<td>".$val_file['file_type']."</td>";
		    		$body.="<td>".$val_file['filesize']."</td>";
		    		$body.="<td class=\"index$x index_row\">".$val_file['compress_size']."</td>";
		    		$body.="<td class=\"center\">$val_file[editable]</td>";
		    		$body.="<td class=\"center\">$val_file[restore]</td>";		    		
		    		$body.="</tr>";
		    		$x++;
		    	}
		    }	    		    
		    if (!empty($body)){
		    	$this->code=1;
		    	$this->msg=$body;
		    }
		}

		public function file_size_convert($bytes)
		{
			if ($bytes<=0){
				return '';
			}
		    $bytes = floatval($bytes);
		        $arBytes = array(
		            0 => array(
		                "UNIT" => "TB",
		                "VALUE" => pow(1024, 4)
		            ),
		            1 => array(
		                "UNIT" => "GB",
		                "VALUE" => pow(1024, 3)
		            ),
		            2 => array(
		                "UNIT" => "MB",
		                "VALUE" => pow(1024, 2)
		            ),
		            3 => array(
		                "UNIT" => "KB",
		                "VALUE" => 1024
		            ),
		            4 => array(
		                "UNIT" => "B",
		                "VALUE" => 1
		            ),
		        );
		
		    foreach($arBytes as $arItem)
		    {
		        if($bytes >= $arItem["VALUE"])
		        {
		            $result = $bytes / $arItem["VALUE"];
		            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
		            break;
		        }
		    }
		    return $result;
		}	
						
		public function compress_single_image()
		{
			
            if( !ini_get('safe_mode') ){	            
                 set_time_limit(900);
                 ini_set("memory_limit","128M");
            }
            $upload_dir = wp_upload_dir();
                                    
            if(!file_exists(WTC_FILE_DIR)) {         	
               @mkdir($upload_dir['basedir'],0777);
               @mkdir("$upload_dir[basedir]/wtc_images",0777);               
		    }		                    

		    $img_id='';		    
            if (isset($this->data['img_id'])){
                $img_id=$this->data['img_id']."-";
            }
		       		    
			global $wtc_db;			
			$t1=explode("/",$this->data['file_path']);			
			$t1_count=count($t1);
			$filename=$t1[$t1_count-1];
			
			$wtc_provider=get_option('wtc_provider');			
						
			if ($wtc_provider==1){  /*TINYPNG*/
				$tinypng_apikey=get_option('tinypng_apikey');				
				$tinyorg=new tinyorg;			
				$tinyorg->input=$this->data['file_path'];
				//$tinyorg->output=ABSPATH."/wp-content/uploads";	
				$tinyorg->output=$upload_dir['basedir'];
				$tinyorg->output_filename=$filename;		
				$tinyorg->key=$tinypng_apikey;
				$tinyorg->img_id=$img_id;			
											
				if ($resp=$tinyorg->compress()){								
					$this->code=1;						
					$this->msg='Compression Successful. New size '.$this->file_size_convert($resp->output->size);
					$params=array(
					  'provider'=>$wtc_provider,
					  'file_name'=>$filename,
					  'original_size'=>$resp->input->size,
					  'crank_size'=>$resp->output->size,
					  'ratio'=>$resp->output->ratio,
					  'status'=>'OK',
					  'json_resp'=>json_encode($resp),
					  'date_created'=>date('c'),
					  'ip_address'=>$_SERVER['REMOTE_ADDR']
					);
					$wtc_db->insert_data('wtc_compress',$params);
				} else $this->msg=$tinyorg->get_msg();
				
			} elseif ($wtc_provider==2) { /*Kraken.io*/
				 
				 $kraken_apikey=get_option('kraken_apikey');
				 $kraken_secretkey=get_option('kraken_secretkey');				 
                 $kraken = new Kraken($kraken_apikey,$kraken_secretkey);
                 
                 $params = array(
                    "file" => $this->data['file_path'],
                    "wait" => true
                 ); 
                                                                    
                 $data = $kraken->upload($params);                
                 
                 if ($data["success"]){                 
                 	 $file_name=$this->get_filename($this->data['file_path']);       	 
                 	 @copy($this->data['file_path'],WTC_FILE_DIR."/$img_id$file_name");
                 	 file_put_contents($this->data['file_path'], fopen($data["kraked_url"],"rb", false));
                 	                  	 
                     $this->msg="Compression Successful. New size:" . $this->file_size_convert($data['kraked_size']);
                     $this->code=1;
                     $params=array(
                      'provider'=>$wtc_provider,
					  'file_name'=>$filename,
					  'original_size'=>$data['original_size'],
					  'crank_size'=>$data['kraked_size'],
					  'ratio'=>$data['saved_bytes'],
					  'status'=>'OK',
					  'json_resp'=>json_encode($data),
					  'date_created'=>date('c'),
					  'ip_address'=>$_SERVER['REMOTE_ADDR']
					);
					$wtc_db->insert_data('wtc_compress',$params);              
                 } else {
                 	 $err='';
                 	 if (array_key_exists('error',$data)){
                 	 	 $err.=$data['error'];
                 	 }
                 	 if (array_key_exists('message',$data)){
                 	 	 $err.=$data['message'];
                 	 }
                     $this->msg='Fail. Error message: ' . $err;
                 }
                 
            } elseif ($wtc_provider==3) { /*DIE IMAGE*/
            	            	            	               	             	 
            	 $original_size='';            	      
            	 $diet=new diet_image;
            	 $diet->api_user=get_option('diet_apiusername');
            	 $diet->api_pass=get_option('diet_apipassword');
            	 $diet->file_path=$this->data['file_path'];       
            	 $file_name=$this->get_filename($this->data['file_path']);
            	 if ($res=$diet->compress()){
            	 	
            	 	@copy($this->data['file_path'],WTC_FILE_DIR."/$img_id$file_name"); 
            	 	file_put_contents($this->data['file_path'],fopen($res,"rb", false));            	 	            	 
            	 	$original_size=$this->file_size_convert(filesize(WTC_FILE_DIR."/$img_id$file_name"));                     
                     $params=array(
                      'provider'=>$wtc_provider,
					  'file_name'=>$filename,
					  'original_size'=>$original_size,
					  'crank_size'=>$this->file_size_convert(filesize($this->data['file_path'])),
					  //'ratio'=>$data['saved_bytes'],
					  'status'=>'OK',
					  'json_resp'=>json_encode($res),
					  'date_created'=>date('c'),
					  'ip_address'=>$_SERVER['REMOTE_ADDR']
					);
					$wtc_db->insert_data('wtc_compress',$params);              
					
					$this->msg="Compression Successful. New size:" . 
					$this->file_size_convert(filesize($this->data['file_path']));
					$this->code=1;
            	 	
            	 } else $this->msg=$diet->get_msg();
			} else {
				$this->msg='No Image provider has been selected. Fixed this by going to the settings area.';
			}
		} /*END compress_single_image*/
				
		function restore_single_image()
		{						
			$img_id='';
			if (isset($this->data['img_id'])){
				$img_id=$this->data['img_id']."-";
			}			
			if (!empty($this->data['file_path'])){
				$file_name=$this->get_filename($this->data['file_path']);
				if (file_exists(WTC_FILE_DIR."/$img_id$file_name")){
					copy(WTC_FILE_DIR."/$img_id$file_name",$this->data['file_path']);
					unlink(WTC_FILE_DIR."/$img_id$file_name");
					$this->code=1;
					$this->msg='Image has been succesfully restored.';
				} else $this->msg='ERROR: Original file cannot locate.';
			} else $this->msg='ERROR: FilePath is empty';
		}
		
		public function get_filename($file_path)
		{
			$t1=explode("/",$file_path);
			$t1_count=count($t1);
			return $t1[$t1_count-1];
		}
		
		public function wtc_media_list()
		{
			$body='';
			$x='';
			$preview='';
			$compress_chckbox='';			
			$file_size_compress='';
			
		    $args = array(
              'post_type' => 'attachment',
              'post_mime_type' =>'image',
              'post_status' => 'inherit',
              'posts_per_page' => -1,
            );			
			$query_images = new WP_Query( $args );
            $images = array();
            foreach ( $query_images->posts as $image) { 
            	            	
            	$file_size_compress='';
            	$restore_chckbox='';
            	
            	$preview="
            	<a href=\"$image->guid\" target=\"_blank\">
            	<img src=\"$image->guid\" alt=\"\" title=\"\" >
            	</a>
            	";
            	$path=get_attached_file($image->ID); 
            	$img_id="$image->ID-";           	            	
            	
            	$file_size=$this->file_size_convert(filesize($path));	
            	$compress_chckbox="<input id=\"$image->ID\" class=\"wtc_media_images\" type=\"checkbox\" value=\"$path\" name=\"wtc_media_images[]\" >";            	
            	
            	$file_name=$this->get_filename($path);
            	if ( file_exists(WTC_FILE_DIR."/$img_id$file_name") ){     
            		$compress_chckbox='';
            		$restore_chckbox="<input id=\"$image->ID\" class=\"wtc_media_images_restore\" type=\"checkbox\" value=\"$path\" name=\"wtc_media_images_restore[]\" >";
            		$file_size_compress=$this->file_size_convert(filesize($path));
            		$file_size=$this->file_size_convert(filesize(WTC_FILE_DIR."/$img_id$file_name"));
            	} 
            	
            	$body.="<tr class=\"wtc_data\">";
            	$body.="<td>$preview</td>";
		        $body.="<td>$image->post_title</td>";
		        $body.="<td>".$image->post_mime_type."</td>";
		        $body.="<td>".$file_size."</td>";
		        $body.="<td class=\"index_row\">".$file_size_compress."</td>";
		        $body.="<td class=\"center\">$compress_chckbox</td>";
		    	$body.="<td class=\"center\">$restore_chckbox</td>";
		    	$body.="</tr>";
            }			 
            if (!empty($body)){
		    	$this->code=1;
		    	$this->msg=$body;
		    } else $this->msg="No media attachments found.";
		}
		
		public function wtc_compress_settings()
		{			
			if (!isset($this->data['wtc_compress_css'])){
				$this->data['wtc_compress_css']='';
			}
			if (!isset($this->data['wtc_compress_html'])){
				$this->data['wtc_compress_html']='';
			}
			if (!isset($this->data['wtc_compress_js'])){
				$this->data['wtc_compress_js']='';
			}
			
			update_option('wtc_compress_css',$this->data['wtc_compress_css']);
			update_option('wtc_compress_html',$this->data['wtc_compress_html']);
			update_option('wtc_compress_js',$this->data['wtc_compress_js']);
		    $this->code=1;
            $this->msg='Successfully updated.';			
		}
		
		public function wtc_compress_main_css()
		{
			if (!isset($this->data['wtc_compress_main_css'])){
				$this->data['wtc_compress_main_css']='';
			}
			update_option('wtc_compress_main_css',$this->data['wtc_compress_main_css']);
		    $this->code=1;
            $this->msg='Successfully updated.';			
		}
				
	} /*END CLASS*/
}