<?php
class Flasher {
	private $valid_type = ['primary','secondary','success','danger','warning','info','light','dark'];
	private $default = 'primary';
	private $type;
	private $msg;

    /**
     * Mètodo para guardar una notificacòn flash
     */
	public static function new($msg, $type = null){
		$self = new self();

		// Tipo de notificaciòn
		if ($type == null){
			$self->type = $self->default;
		}

		$self->type = in_array($type, $self->valid_type) ? $type : $self->default;

		// Guardar la notificaciòn en un arreglo de sesion
		if (is_array($msg)){
			foreach ($msg as $message){
				$_SESSION[$self->type][] = $message;
			}

			return true;
		}

		// $_SESSION['primary']['notification']
		$_SESSION[$self->type][] = $msg;

		return true;
	}

	/*
	 *
	 * */
	public static function flash() {
		$self = new self();
		$output = '';

		foreach ($self->valid_type as $type){
			if (isset($_SESSION[$type]) && !empty($_SESSION[$type])){
				foreach ($_SESSION[$type] as $message){
					$output .= '<div class="alert alert-'. $type .' alert-dismissible show fade" role="alert">';
						$output .= $message;
						$output .=	'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
					$output .= '</div>';
				}

                unset($_SESSION[$type]);
			}
		}


        return $output;
	}
}