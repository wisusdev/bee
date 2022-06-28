<?php

class homeController extends Controller {
    public function index(){
		$data = [
			'id' => 1,
			'title' => 'Bee framework'
		];

		View::render('index', $data);
	}

	public function store(){
		try {
			$user = new userModel();
			$user->name = 'Maria Lopez Miranda';
			$user->username = 'mlopez';
			$user->email = 'mlopez@mail.com';
			$user->created_at = now();
			$id = $user->add();
			echo $id;
		} catch (Exception $exception){
			echo $exception->getMessage();
		}
		die();
	}

	public function update(){
		// Insertar nuevo usuario
		try {
			$user = new userModel();
			$user->id = 5;
			$user->name = 'Maria Lopez Miranda';
			$user->username = 'mlopez';
			$user->email = 'mlopez@mail.com';
			$id = $user->update();
			echo $id;
		} catch (Exception $exception){
			echo $exception->getMessage();
		}
		die();
	}

	public function test(){
		echo 'Hola Mundo';
		Redirect::to('/home');
	}

	public function test_db(){
		echo 'Probando consulta a la base de datos';
		echo '<pre>';
		try {
			// SELECT
			$sql = 'SELECT * FROM users WHERE id=:id AND name=:name';
			$response = Db::query($sql, ['id' => 2, 'name' => 'Karla']);
			print_r($response);

			// INSERT
			$sql = 'INSERT INTO users (name, email, created_at) VALUES (:name, :email, :created_at)';
			$record = [
				'name' 			=> 'Juan',
				'email' 		=> 'juan@mail.com',
				'created_at' 	=> now(),
			];
			//$user_id = Db::query($sql, $record);
			//print_r($user_id);

			// UPDATE
			$sql = 'UPDATE users SET name=:name WHERE id=:id';
			$update_record = [
				'name' => 'Juan Carlos',
				'id' => 4
			];
			//$update = Db::query($sql, $update_record);
			//print_r($update);

            // DELETE
            $sql = 'DELETE FROM users WHERE id=:id LIMIT 1';
            //$delete_record = Db::query($sql, ['id' => 4]);
            //print_r($delete_record);

			// ALTER TABLE
			$sql = 'ALTER TABLE users ADD COLUMN username VARCHAR(255) NULL AFTER name';
			$alter_table = Db::query($sql);
			print_r($alter_table);

		} catch (PDOException $exception) {
			die(sprintf('Ocurrio un error %s', $exception->getMessage()));
		}
		echo '</pre>';

		View::render('test');
	}

	public function flash() {
		View::render('flash');
	}

	public function csrf(){
		print_r($_SESSION);

		$toke_post = '039f87b0a2840c36a8181dd60d91ced6c4e2551134cd61c74e02e4402a28044b';

		if (Csrf::validate($toke_post, true)){
			echo 'toke valido';
		} else {
			echo 'token invalido';
		}
	}
}