<?php
require_once '../controlador/DAO_estudiante.php';
require_once '../modelo/Estudiante.php';


$modelo=new Bd();
$id   = $_GET['id'];
$modelo->delete($id);
header("Location: index.php?id=$id");

  
