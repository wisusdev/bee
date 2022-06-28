<?php

class errorController extends Controller {

	public function index(){
		$data = [
			'title' => '404 - Pàgina no encontrada',
		];

		View::render('404', $data);
	}
}