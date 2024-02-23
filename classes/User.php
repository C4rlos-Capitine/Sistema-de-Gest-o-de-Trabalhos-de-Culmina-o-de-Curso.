<?php
class User{
	private $_db;
	private $_data;
	private $_sessionName;
	private $_cookieName;
	private $_isLoggedIn;
	
	public function __construct($user = null){
		$this->_db = DB2::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isLoggedIn = true;
				}else{
					//logout
				}
			}

		}else{
			$this->find($user);
		}
	}
	
	public function create($fields = array()){
		if(!$this->_db->insert('user', $fields)){
			throw new Exception('There was a problem creating an account');
		}
	}

	public function find($user = null){
		if($user){
			//die("user true");
			$field = (is_numeric($user)) ? 'id' : 'username';
			//var_dump($field);
			//$data var represents the that we get from the table
			//name of the table is user, and fields that we have to compare are id and username 
			$data = $this->_db->get(array('user'), array(array($field, '=', $user)));
			
			if($data){
				//die("data true");
				$this->_data = $data->first();
				return true;
			}

		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false){
	
		if(!$username && !$password && $this->exists()){
			//log user in
			
			Session::put($this->_sessionName, $this->data()->id);
		}else{
			$user = $this->find($username);
			var_dump($user);
			if($user){
				
				if($this->data()->password === Hash::make($password, $this->data()->salt)){
					Session::put($this->_sessionName, $this->data()->id);
					//echo 'ok';
					if($remember){
						
						$hash = Hash::unique();
						$hashCheck = $this->_db->get(array('user_session'), array(array('user_id', '=', $this->data()->id)));
						if(!$hashCheck->count2()){
							
							$this->_db->insert('user_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						}else{
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}
		}
		return false;
	}

	public function exists(){
		//check weather _data hasn't been defined 
		return (!empty($this->_data)) ? true : false;
	}
	public function data(){
		return $this->_data;
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;	
	}

	public function logOut(){
		//$this->_db->delete(array('user_session'), array(array()))
		$this->_db->delete(array('user_session'), array(array('user_id', '=', $this->data()->id)));

		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}

	public function update($fields = array(), $id = null){
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}

		if (!$this->_db->update('user', $id, 'id', $fields)) {
			
			throw new Exception ("There was a problem updating.");
		}
	}

	public function update2($table, $fields=array(), $id=null){
		
	}

	public function insertKey($table, $fields, $id){
		
	}

	public function hasPermission($key){
		$group = $this->_db->get(array('groups'), array(array('id_group', '=', $this->data()->group_id)));
		//print_r($group->first()->name);
		if($group->count2()){
			$permissions = json_decode($group->first()->permissoes, true);
			//print_r($permissions);
			
			if($permissions[$key] == true){
				return true;
			}
	
		}
		return false;
	}
}