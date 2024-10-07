<?php
#CREAMOS LA CONEXION A LA BASE DE DATOS
$conn = new mysqli("localhost","root","","task_manager");

if($conn ->connect_error){
    die("Connection failed: " . $conn -> connect_error);
}