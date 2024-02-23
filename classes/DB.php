<?php
require_once 'core/init.php';
class DB{
	
	private static $_instance = null;
	private static $_instance2 = null;
	private $_pdo; 
	private	$_query;
	private	$_query2;
	private	$_error = false;
	private	$_results;
	private $_results2;
	public	$_count = 0;
	
	private function __construct(){
		
		try{
			$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
			//echo 'connected';
		}catch(PDOException $e){
			die($e->getMessage());
		}
		
	}
	
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
		
	}

	public static function getInstance2(){
		if(!isset(self::$_instance2)){
			self::$_instance2 = new DB();
		}
		return self::$_instance2;
	}

	public function get($table, $where){
		
		return $this->action('SELECT *', $table, $where);
	}

	public function getFromMany($columns, $tables, $where){
		//listando as tabelas
		$tabelas = '';
		for($i=0; $i<=sizeof($tables); $i++){
			$tabelas = $tabelas.','.$tables[$i];
		}
		//listando as colunas
		$colunas = '';
		for($i=0; $i<=sizeof($columns); $i++){
			$colunas = $colunas.', '.$columns[$i];
		}
		echo $tabelas.'<br>'.$colunas;

	}
	
	public function query($sql, $params = array()){
	
		$this->error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			//echo 'Scuccsess';
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			 }
			if($this->_query->execute()){
				
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				
				$this->_count = $this->_query->rowCount();
				
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}

	
	public function action($action, $table, $where = array()){
		if(count($where)===3){
			$operators = array('=', '>', '<', '>=', '<=');
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];
			//verifica se o operador escolhido esta na array
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function getAll($table){
		//$this->error = false;
		$sql = "SELECT * FROM {$table}";
		$this->_query = $this->_pdo->prepare($sql);
		if($this->_query->execute()){
			$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
			$this->_count = $this->_query->rowCount();
			return $this->_results;
		}
		return false; 
	}

	
	public function delete($table, $where){
		return $this->action('DELETE', $table, $where);
	}
	
	public function	update($table, $id, $onde, $fields){
		$set = '';
		$x = 1;
		print_r($fields);
		//die();
		foreach ($fields as $name => $value) {
			// code...
			$set .= "{$name} = ?";
			if($x < count($fields)){
				$set .=',';
			} 
			$x++;
		}
		
		$sql = "UPDATE {$table} SET {$set} WHERE {$onde} = '$id'";
		//die($sql);
		echo $sql;
		if(!$this->query($sql, $fields)->error()){
			return true;
		}

		return false;
	}

	public function results(){
		return $this->_results;
	}
	
	public function first(){
		return $this->results()[0];
	}
	
	public function count2(){
		return $this->_count;
	}
	
	public function error(){
		return $this->_error;
	}
	
	public function insert($table, $fields = array()){
		if(count($fields)){
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			
			foreach($fields as $field){
				$values .= '?';
				if($x < count($fields)){
					$values .= ', ';
				}
				$x++;
			}
			//die($values);
			
			$sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES({$values})";
			
			if(!$this->query($sql, $fields)->error()){
				
				return true;
			}
		}
		return false;
	}
	//
	
}