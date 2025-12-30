<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "importantes";
$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco: " . $conn->connect_error);
}


?>

