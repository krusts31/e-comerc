<?php
Class user {
	private $_db,
		$_data,
		$sessioName,
		$_isLoggedIn,
		$cookieName;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();	
		$this->sessionName = config::get('session/session_name');
		$this->cookieName = config::get('remember/cookie_name');
		if(!$user) {
			if(session::exists($this->sessionName)) {
				$user = session::get($this->sessionName);
				if($this->find($user)) {
					$this->_isLoggedIn = true;
				}else {
					$this->_isLoggedIn = false;	
				}
			}
		} else {
			$this->find($user);
		}

	}

	public function data() {
		return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function logout() {

		$this->_db->delete('users_sessions', array('user_id', '=', $this->data()->id));
		session::delete($this->sessionName);
		cookie::delete($this->cookieName);
	}

	public function hasPremisson($key) {
		$group = $this->_db->get('gruops', array('id', '=', $this->data()->breed));
			if($group->count()) {
				$premissons = json_decode($group->first()->premissons, true);
				print_r($premissons);
				if($premissons[$key] == true){
					return true;
				}
		}
	}

	public function exists() {
		return (!empty($this->_data))? true : false;
	}
	
	public function update($fields = array(), $id = null) {

		if(!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if(!$this->_db->update('info', $id, $fields)) {
			throw new exception('there was a problem');
		
		}
	}

	public function create($table, $fields = array()) {
		if(!$this->_db->insert($table, $fields)) {
			throw new exception('There was a problem creating an account');
		}
	}

	public function find($user = null) {
		if($user) {
			$field =(is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('info', array($field, '=', $user));
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false) {
		if(!$username && !$password && $this->exists()) {
			session::put($this->sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);
			
			if($user){
			if(password_verify($password ,$this->data()->password)){
				session::put($this->sessionName, $this->data()->id);
				if($remember) {
					$hash = hash::unique();
					$hashCheck = $this->_db->get('users_sessions', array('user_id', '=', $this->data()->id));

					if(!$hashCheck->count()) {
						$this->_db->insert('users_sessions', array(
							'id' => null,
							'user_id' => $this->data()->id,
							'hash' => $hash
						));
					} else {
						$hash = $hashCheck->first()->hash;
					}
					cookie::put($this->cookieName, $hash, config::get('remember/cookie_expiry'));
				}
				return true;
			}
		}
		}
		return false;
	}
}
