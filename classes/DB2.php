<?php
require_once 'core/init.php';
class DB2{
	
	private static $_instance = null;
	private static $_instance2 = null;
	private $_pdo; 
	private	$_query;
	private	$_query2;
	private	$_error = false;
	private	$_results;
	private $_results2;
	public	$_count = 0;
	private $_lastId;
	
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
			self::$_instance = new DB2();
		}
		return self::$_instance;
		
	}

	public static function getInstance2(){
		if(!isset(self::$_instance2)){
			self::$_instance2 = new DB2();
		}
		return self::$_instance2;
	}

	public function get($table, $where){
		
		return $this->action('SELECT *', $table, $where);
	}

	public function getCount($table, $function, $where){
		return $this->action("SELECT COUNT('{$function}') AS total" , $table, $where);
	}

	function getFromMany($tabelas, $where = array()){
		$sql = "SELECT * FROM ";
		$operators = array('=', '>', '<', '>=', '<=');
		$campos = array();
		$operadores = array();
		$valores = array();
		$valido = 0;

		for($i=0; $i<sizeof($where); $i++){
			$filtro[$i] = new Filtro($where[$i][0], $where[$i][1], $where[$i][2]);
		}
		for($i=0; $i<sizeof($where); $i++){

			if(count($where[$i])===3){
				
				$valido++;
				//echo $valido."<br>";
			}
			$campos[$i] = $filtro[$i]->campo;
			$operadores[$i] = $filtro[$i]->operador;
			$valores[$i] = $filtro[$i]->valor;
	
		}
		//print_r($valores);
		for($i=0; $i<sizeof($tabelas); $i++){
			if($i>=1){
				$sql = $sql.', ';   
			}
			$sql = "{$sql} ".$tabelas[$i];
			
		}
		$sql = $sql.' WHERE ';
		for($j=0; $j<sizeof($campos); $j++){
			
			if($j>=1){
				$sql = $sql.' AND ';
			}
			$sql = $sql." ".$campos[$j]." ".$operadores[$j]." ".$valores[$j];
		}
		//echo $sql;
		//die();
		$this->_query = $this->_pdo->prepare($sql);
		if($this->_query->execute()){
			$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
			$this->_count = $this->_query->rowCount();
			return $this->_results;
		}
		return false; 
	}
	

	function action($action, $tabelas, $where = array()){

		$operators = array('=', '>', '<', '>=', '<=');
		$sql = $action.' FROM ';
		$campos = array();
		$operadores = array();
		$valores = array();
		$valido = 0;

		for($i=0; $i<sizeof($where); $i++){
			$filtro[$i] = new Filtro($where[$i][0], $where[$i][1], $where[$i][2]);
		}
		for($i=0; $i<sizeof($where); $i++){
	
			if(count($where[$i])===3){
				
				$valido++;
				//echo $valido."<br>";
			}
			$campos[$i] = $filtro[$i]->campo;
			$operadores[$i] = $filtro[$i]->operador;
			$valores[$i] = $filtro[$i]->valor;
			//echo $campos[$i]." ".$operadores[$i]." ".$valores[$i]."<br>";
			
		}
	
		for($i=0; $i<sizeof($tabelas); $i++){
			if($i>=1){
				$sql = $sql.', ';   
			}
			$sql = "{$sql} ".$tabelas[$i];
			
		}
		$sql = $sql.' WHERE ';
		for($j=0; $j<sizeof($campos); $j++){
			
			if($j>=1){
				$sql = $sql.' AND ';
			}
			$sql = $sql." ".$campos[$j]." ".$operadores[$j]." ?";
		}
		//echo "sql: {$sql}";
		if(!$this->query($sql, $valores)->error()){
			return $this;
		}
	
	}
	public function query($sql, $params = array()){
		$this->error = false;
		//print_r($params);
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					//$this->_query->bindParam($x, $param, PDO::PARAM_STR);
					$x++;
				}
			 }
			 //echo $sql;
			 //echo "<br>".$param;
			
			if($this->_query->execute())
			{
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_lastId = $this->_pdo->lastInsertId();
				$this->_count = $this->_query->rowCount();
				
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}
	public function	update($table, $id, $onde, $fields){
		$set = '';
		$x = 1;
		//print_r($fields);
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

		if(!$this->query($sql, $fields)->error()){
			return true;
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
	
	
	public function delete($tables, $where = array()){
		//print_r($where);
		
		return $this->action('DELETE', $tables, $where);
	}
	
	public function results(){
		return $this->_results;
	}

	public function getLastId(){
		return $this->_lastId;
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
			
			$sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES({$values})";
			//echo $sql;
			if(!$this->query($sql, $fields)->error()){
				
				return true;
			}
		}
		return false;
	}

	
}