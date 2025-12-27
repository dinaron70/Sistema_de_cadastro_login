<?php
session_start();
include_once "conexao.php";
$conn = new mysqli($host, $usuario, $senha, $banco);

// Se for página de cadastro, não bloqueie usuários sem login
// if(!isset($_SESSION["usuario_id"])) { header("Location: login.php"); exit; }

$primeiro_nome = $_POST["primeiro_nome"];
$sobrenome = $_POST["sobrenome"];
$email = $_POST["email"];
$cpf = $_POST["cpf"];
$cep = $_POST["cep"];
$logradouro = $_POST["logradouro"];
$bairro = $_POST["bairro"];
$cidade = $_POST["cidade"];
$uf = $_POST["uf"];
$phone = $_POST["phone"];
$senha = $_POST["senha"];
$repet_senha = $_POST["repet_senha"];
$created = date("Y-m-d H:i:s"); // gera automaticamente

if($senha !== $repet_senha){
    $_SESSION["erro"] = "As senhas digitadas não são iguais";
    header("Location: cadastro.php");
    exit;
}

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
$repet_senha_hash = password_hash($repet_senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO importantes 
(primeiro_nome, sobrenome, email, cpf, cep, logradouro, bairro, cidade, uf, phone, senha, repet_senha, created)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssss", $primeiro_nome, $sobrenome, $email, $cpf, $cep, $logradouro, $bairro, $cidade, $uf, $phone, $senha_hash, $repet_senha_hash, $created);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $stmt->execute();
    $_SESSION["sucesso"] = "Você foi cadastrado com sucesso";
    header("Location: cadastro.php");
    exit;
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        if (str_contains($e->getMessage(), 'email')) {
            $_SESSION["erro"] = "Email já cadastrado no sistema";
        } elseif (str_contains($e->getMessage(), 'cpf')) {
            $_SESSION["erro"] = "CPF já cadastrado no sistema";
        } else {
            $_SESSION["erro"] = "Registro duplicado";
        }
    } else {
        $_SESSION["erro"] = "Erro ao cadastrar usuário: " . $e->getMessage();
    }
    header("Location: cadastro.php");
    exit;
}

?>
