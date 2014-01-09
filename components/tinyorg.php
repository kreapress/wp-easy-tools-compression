<?php
class tinyorg
{
	public $key='';
	public $input='';
	public $output='';
	public $output_filename;
	public $msg='';
	public $img_id='';
	
	public function compress()
	{
		//$response='{"input":{"size":74530},"output":{"size":1744,"ratio":0.0234,"url":"https://api.tinypng.com/output/5vv5u9i8lra6hkhp.png"}}';
		
		$request = curl_init();
        curl_setopt_array($request, array(
            CURLOPT_URL => "https://api.tinypng.com/shrink",
            CURLOPT_USERPWD => "api:" . $this->key,
            CURLOPT_POSTFIELDS => file_get_contents($this->input),
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,            
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($request);
        //dump($response);
        $resp=json_decode($response);        
        if (curl_getinfo($request, CURLINFO_HTTP_CODE) === 201) {
            if (!file_exists($this->output)){
            	mkdir($this->output,0777);
            }                       
        	if (!file_exists($this->output."/wtc_images")){
        		mkdir($this->output."/wtc_images",0777);
        	}        	        
        	//file_put_contents($this->output."/wtc_images/$this->output_filename", fopen($resp->output->url,"rb", false));        	
        	@copy($this->input,$this->output."/wtc_images/$this->img_id$this->output_filename"); 
        	file_put_contents($this->input,fopen($resp->output->url,"rb", false));      	
        	return $resp;        	
        } else {              	
        	$this->msg='Compression failed Reason :' .$resp->message;
        }
        return FALSE;
	}
	
	public function get_msg()
	{
		return $this->msg;
	}
}