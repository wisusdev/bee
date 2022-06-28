<?php

class Db {
	private $link;
	private $host;
	private string $engine;
	private string $name;
	private string $user;
	private string $pass;
	private string $charset;

	public function __construct() {
		$this->engine = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
		$this->engine = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
		$this->name  = IS_LOCAL ? LDB_NAME : DB_NAME;
		$this->user = IS_LOCAL ? LDB_USER : DB_USER;
		$this->pass = IS_LOCAL ? LDB_PASS : DB_PASS;
		$this->charset = IS_LOCAL ? LDB_CHARSET : DB_CHARSET;

		return $this;
	}

	private function connect(){
		try {
			$this->link = new PDO($this->engine. ':host='.$this->host. ';dbname='.$this->name.';charset='.$this->charset, $this->user, $this->pass);
			return $this->link;
		} catch (PDOException $exception){
			die(sprintf('Ocurrió un error: %s', $exception->getMessage()));
		}
	}

	/**
	 * @throws Exception
	 */
	public static function query($sql, $params = []){
		$db = new self();
		$link = $db->connect();
		$link->beginTransaction();
		$query = $link->prepare($sql);

		// Manejando errores en el query o la petición
		// SELECT * FROM usuarios WHERE id=:cualquier AND name = :name;
		if(!$query->execute($params)){
			$link->rollBack();
			$error = $query->errorInfo();
			// index 0 es el tipo de error
			// index 1 es el código de error
			// index 2 es el mensaje de error al usuario
			throw new Exception($error[2]);
		}

		// SELECT | INSERT | UPDATE | DELETE | ALTER TABLE
		// Manejando el tipo de query
		// SELECT * FROM usuarios;

		if(strpos($sql, 'SELECT') !== false) {

			return $query->rowCount() > 0 ? $query->fetchAll() : false; // no hay resultados

		} elseif(strpos($sql, 'INSERT') !== false) {

			$id = $link->lastInsertId();
			$link->commit();
			return $id;

		} elseif(strpos($sql, 'UPDATE') !== false) {

			$link->commit();
			return true;

		} elseif(strpos($sql, 'DELETE') !== false) {

			if($query->rowCount() > 0) {
				$link->commit();
				return true;
			}

			$link->rollBack();
			return false; // Nada ha sido borrado

		} else {
			// ALTER TABLE | DROP TABLE
			$link->commit();
			return true;
		}
	}
}