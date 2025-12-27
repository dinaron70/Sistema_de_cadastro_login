<?php
$host = "localhost";
$usuario = "recebimento_ureia";
$senha = "Senador@21#";
$banco = "importantes";
$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco: " . $conn->connect_error);
}


?>
