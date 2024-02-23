<?php

class Validation{
	
	private $_passed = false;
	private $_errors = array();
	private $_db;
		
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	
	public function check($source, $items = array()){
		foreach($items as $item => $rules){
			foreach($rules as $rule => $rule_value){
				//echo "{$item} {$rule} must be {$rule_value} </br>";
				$value = trim($source[$item]);
				//echo $value;
				
				//$item = escape($item);
				if($rule === 'required' && empty($value)){
					$this->addError("{$item} is required");
				}else if(!empty($value)){
					switch($rule){
						case 'min':
						if(strlen($value) < $rule_value){
							$this->addError("{$item} must be minimum of {$rule_value} characters");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be max of {$rule_value} characters");
							}
							break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item} characters");
							}
							break;
						case 'unique':
							$this->_db->get($rule_value, array($item, '=', $value));
							if($this->_db->count2()){
								$this->addError("{$item} alread exists");
							}
							break;
					}
					
				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}
	
	public function addError($error){
		$this->_errors[] = $error;
	}
	
	public function errors(){
		return $this->_errors;
	}
	
	public function passed(){
		return $this->_passed;
	}
}