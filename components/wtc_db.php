<?php
class wtc_db
{
		
	var $cdb;	
	
	public function __construct($config=array()){
		self::connect($config);
	}
	
	public function connect($config=array())
	{						
	    $this->cdb=new wpdb($config['username'],$config['password'],$config['database'],$config['host']);	    
	    if (!$this->cdb){
	    	throw new Exception('Cannot connect to db');
	    }		
	}
	
	public function rst($sql='')
	{		
		if (!empty($sql)){
			return $this->cdb->get_results($sql);
		} else return false;
	}
	
	public function qry($sql='')
	{
		if (!empty($sql)){
			if ($this->cdb->query($sql)) {
			    return true;
		    } else return false;
		} else return false;
	}
	
	
	public function insert_data($table='' ,$data=array()){		
		$sql = "INSERT INTO 
			        $table
			        SET
		";		
		if (is_array($data)) {			
			foreach ($data as $key => $value) {
				$sql .= $key ."='" . addslashes($value) ."' ,";
			}
			$sql = substr($sql,0,strlen($sql)-1);			
			if ($this->cdb->query($sql)) {
				return true;
			} else return false;
		} else return false;
	}
	
	
	public function update_data($table='' ,$data=array() , $wherefield='', $whereval=''){
		global $wpdb;
		$sql = "UPDATE
			     $table
			     SET
		";		
		if (is_array($data)) {			
			foreach ($data as $key => $value) {
				$sql .= $key ."='" . addslashes($value) ."' ,";
			}	
			$sql = substr($sql,0,strlen($sql)-1);
			$sql .= " 
			        WHERE
			        $wherefield ='".$whereval."'
			        ";			
			if ($this->cdb->query($sql)) {
				return true;
			} else return false;
		} else return false;
	}	
		
	
	static function dump($data='')
	{
		echo '<pre>';print_r($data);echo '</pre>';
	}
	
}
/*END: Cdb*/