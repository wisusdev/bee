<?php

class View {
	public static function render($view, $data = []){
		// Convertir el array asociativo en un objeto
		$d = to_object($data); // $data es un array y $d es un objeto

		if (!is_file(VIEWS . CONTROLLER . DS . $view . 'View.php')){
			die(sprintf('No existe la vista %sView en el directorio %s', $view, CONTROLLER));
		}

		require_once VIEWS . CONTROLLER . DS . $view . 'View.php';

		exit();
	}
}