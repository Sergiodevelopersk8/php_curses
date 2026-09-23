<?php 

// 1. CARGAR EL AUTOLOAD PRIMERO QUE NADA
require __DIR__ . '/../vendor/autoload.php';

// 2. Cargar los archivos de soporte
require 'funciones.php';
require 'database.php'; // Asegúrate de que aquí adentro se cree la variable $db

// 3. Usar las clases una vez que el autoload ya está activo
use Model\ActiveRecord;
ActiveRecord::setDB($db);