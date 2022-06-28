<?php

// Saber si estamos trabajando de forma local o remota
define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));

// Definir el uso horario o timezone del sistema
date_default_timezone_set('America/El_Salvador');

// Idioma
const LANG = 'es';

// Ruta base de proyecto
const BASEPATH = IS_LOCAL ? '/Users/avelar/Sites/bee' : '__EN_PRODUCCION__';

// Salt del sistema
const AUTH_SALT = 'BeeFramework';

// Puerto y URL del sitio
const PORT = '8000';

const URL = IS_LOCAL ? 'http://127.0.0.1:' . PORT : '__EN_PRODUCCION__';


// Rutas de directorio
const DS = DIRECTORY_SEPARATOR;
define("ROOT", getcwd() . DS);


const APP = ROOT . 'app' . DS;
const CLASSES = APP . 'classes' . DS;
const CONFIG = APP . 'config' . DS;
const CONTROLLERS = APP . 'controllers' . DS;
const FUNCTIONS = APP . 'functions' . DS;
const MODELS = APP . 'models' . DS;

const TEMPLATES = ROOT . 'templates' . DS;
const INCLUDES = TEMPLATES . 'includes' . DS;
const MODULES = TEMPLATES . 'modules' . DS;
const VIEWS = TEMPLATES . 'views' . DS;

// Rutas de archivos en base a URL
const ASSETS = URL . 'assets/';
const CSS = ASSETS . 'css/';
const JS = ASSETS . 'js/';
const FAVICON = ASSETS . 'favicon/';
const FONTS = ASSETS . 'fonts/';
const IMAGES = ASSETS . 'images/';
const PLUGINS = ASSETS . 'plugins/';
const UPLOADS = ASSETS . 'uploads/';

// Credenciales de Base de Datos
// Set para conexión local o en desarrollo
const LDB_ENGINE = 'mysql';
const LDB_HOST = 'localhost';
const LDB_NAME = 'beeframework';
const LDB_USER = 'admin';
const LDB_PASS = '0mEg4a9012_';
const LDB_CHARSET = 'utf8';

// Set para conexciòn en producciòn
const DB_ENGINE = 'mysql';
const DB_HOST = 'localhost';
const DB_NAME = 'beeframework';
const DB_USER = 'admin';
const DB_PASS = '0mEg4a9012_';
const DB_CHARSET = 'utf8';

// El controlador por defecto / el metodo por defecto
const DEFAULT_CONTROLLER = 'home';
const DEFAULT_ERROR_CONTROLLER = 'error';
const DEFAULT_METHOD = 'index';