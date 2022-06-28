<?php

// Clase encargada de procesar todo (capa superior)
class Bee {

	// Propiedades del framework
	private $framework = 'Bee';
	private $version = '1.0.0';
	private $uri = [];

	// Funcion principal al instanciar la clase
	function __construct() {
		$this->init();
	}

	/**
	 * Metodo para ejecutar otros metodos de forma subsecuente
	 * @return void
	 */
	private function init() {
		// Todos los metodos que se ejecutaran consecutivamente
		$this->init_session();
		$this->init_load_config();
		$this->init_load_functions();
		$this->init_autoload();
		$this->init_csrf();
		$this->dispatch();
	}

	/**
	 * Metodo para iniciar la sesion en el sistema
	 * @return void
	*/
	private function init_session() {
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}

		return;
	}

	/**
	 * Metodo para cargar la configuracion del sistema
	*/
	private function  init_load_config() {
		$file = 'bee_config.php';
		if (!is_file('app/config/' . $file)){
			die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione', $file, $this->framework));
		}

		// Cargamos el archivo de configuracion
		require_once 'app/config/' . $file;

		return;
	}

	/*
	 * Metodo para cargar todas las funciones del sistema y del usuario
	 **/
	private function init_load_functions() {
		$file = 'bee_core_functions.php';
		if (!is_file(FUNCTIONS . $file)){
			die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione', $file, $this->framework));
		}

		// Cargamos el archivo de funciones Core
		require_once FUNCTIONS. $file;

		$file = 'bee_custom_functions.php';
		if (!is_file(FUNCTIONS . $file)){
			die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione', $file, $this->framework));
		}

		// Cargamos el archivo de funciones Custom
		require_once FUNCTIONS . $file;

		return;
	}

	/*
	 * Metodo para cargar todos los archivos de forma autimatica
	 * */
	private function init_autoload() {
		require_once CLASSES . 'Autoloader.php';
		Autoloader::init();
	}

	/*
	 * Metodo para crear un nuevo token de la session del usuario
	 * */
	private function init_csrf(){
		$csrf = new Csrf();
	}

	/*
	 * Metodo para filtrar y descomponer los elemtos de la URL y URI
	 * */
	private function filter_url() {
		if (isset($_SERVER['REQUEST_URI'])){
			$this->uri = $_SERVER['REQUEST_URI'];
			$this->uri = ltrim($this->uri, '/');
			$this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
			$this->uri = explode('/', strtolower($this->uri));

			return $this->uri;
		}
	}

	/*
	 * Metodo para ejecutar y cargar automatica el controlador solicitado por el usuario
	 * Llamado al metodo y pasar parametros
	 * */
	private function dispatch(){
		// Filtrar la URL y separar la URI
		$this->filter_url();

		// Obtenemos el Controlador ($this->>uri[0])
		if (!empty($this->uri[0])){
			$current_controller = $this->uri[0];
			unset($this->uri[0]);
		} else {
			$current_controller = DEFAULT_CONTROLLER; // home
		}

		// Ejecucion del controlador
		// Comprobamos si existe una clase con el controlador solicitado
		$controller = $current_controller.'Controller';
		if (!class_exists($controller)){
			$current_controller = DEFAULT_ERROR_CONTROLLER; // para que el controller sea error
			$controller = DEFAULT_ERROR_CONTROLLER.'Controller'; // errorController
		}

		// Ejecutar metodo solicitado
		if (isset($this->uri[1])) {
			$method = str_replace('-', '_', $this->uri[1]);

			//Validamos si existe el metodo en el controlador
			if(!method_exists($controller, $method)) {
				$controller         = DEFAULT_ERROR_CONTROLLER.'Controller'; // errorController
				$current_method     = DEFAULT_METHOD; // index
				$current_controller = DEFAULT_ERROR_CONTROLLER;
			} else {
				$current_method = $method;
			}

			unset($this->uri[1]);
		} else {
			$current_method = DEFAULT_METHOD;
		}

		// creando constantes
		define("CONTROLLER", $current_controller);
		define("METHOD", $current_method);

		// Ejecutando controlador y metodo segun peticion
		$controller = new $controller;

		// Obteniendo parametros de nuestra URI
		$params = array_values(empty($this->uri) ? [] : $this->uri);

		// Llamada al metodo que solicita el usuario
		if (empty($params)){
			call_user_func([$controller, $current_method]);
		} else {
			call_user_func_array([$controller, $current_method], $params);
		}

		// finalizamos con un return
		return;

	}

	/*
	* Corre nuestro framework
	*/
	public static function fly(){
		$bee = new Bee();
		return;
	}
}