<?php

class userModel extends Model {
	public $id;
	public $name;
	public $username;
	public $email;
	public $created_at;
	public $updated_at;

	/**
	 * @throws Exception
	 */
	public function add() {
  		$sql = 'INSERT INTO users (name,username,email,created_at) VALUES (:name,:username,:email,:created_at)';
		$user = [
            'name' => $this->name,
			'username' => $this->username,
			'email' => $this->email,
			'created_at' => $this->created_at,
		];
		
        try{
		    return($this->id = parent::query($sql, $user)) ? $this->id : false;
		} catch(Exception $e) {
			throw $e;
		}
	}

	/**
	 * Metodo para actualizar un registro
	 */
	public function update() {
		$sql = 'UPDATE users SET name=:name,username=:username, email=:email WHERE id=:id';
		$user = [
			'id' => $this->id,
			'name' => $this->name,
			'username' => $this->username,
			'email' => $this->email,
		];

		try{
			return (bool)parent::query($sql, $user);
		} catch(Exception $e) {
			throw $e;
		}
	}
}
