<?php

class Redirect {
	private $location;

	# Metodo para redirigir al usuario a una seccion de terminada
	public static function to($location){
		$self = new self();
		$self->location = $location;

		if (headers_sent()){
			echo '<script type="text/javascript">';
				echo 'window.location.href="'.URL.$self->location.'";';
			echo '</script>';

			echo '<noscript>';
				echo '<meta http-equiv="refresh" content="0;url='.URL.$self->location.'" />';
			echo '</noscript>';

			die();
		}

		// Cuando pasamos una url externa a nuestro sitio
		if (strpos($self->location, 'http') !== false) {
			header('Location: '.$self->location);
			die();
		}

		// Redirigir al usuario a otra sección
		header('Location: '.URL.$self->location);
		die();
	}
}