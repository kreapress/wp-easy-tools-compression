<?php
class diet_image
{
	public $api_user='';
	public $api_pass='';
	public $file_path='';
	public $msg='';	
	
	public function compress()
	{
		if (file_exists($this->file_path)){
			$post=array('file'=>base64_encode(file_get_contents($this->file_path)));
			$ch = curl_init('http://service.dietimage.com/index.php/webservices/compress');
	        curl_setopt($ch, CURLOPT_POST, true);		 
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);		 
	        curl_setopt($ch, CURLOPT_USERPWD, "$this->api_user:$this->api_pass");		        
	        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_HEADER, false);	 
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
	        $resut=curl_exec ($ch);	
	        //dump($resut);
	        curl_close ($ch);
	        $resp=json_decode($resut);	        
	        if (is_object($resp)){
	        	if ($resp->code==1){
	        		return $resp->details->compress_url;	        		
	        	} else $this->msg=$resp->msg;
	        } else $this->msg="ERROR: response from api ".$resut;
		} else $this->msg='File does not exist';
		return FALSE;
	}
	
	public function get_msg()
	{
		return $this->msg;
	}
}