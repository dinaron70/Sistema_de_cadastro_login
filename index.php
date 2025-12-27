
<?php
session_start();
include_once "salas/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $primeiro_nome = $_POST["primeiro_nome"];
    $senha = $_POST["senha"];

    // Busca o usuário pelo nome
    $sql = "SELECT id, senha FROM importantes WHERE primeiro_nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $primeiro_nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

     // Verifica a senha (se estiver salva com hash)
	if (password_verify($senha, $usuario["senha"])) {
    $_SESSION["usuario_id"] = $usuario["id"];
    $_SESSION["primeiro_nome"] = $primeiro_nome; // guarda o nome na sessão
    $_SESSION["sucesso"] = "Login realizado com sucesso!";
    header("Location: salas/salas.php");
    exit;     
        } else {
            $_SESSION["erro"] = "Senha incorreta!";
        }
    } else {
        $_SESSION["erro"] = "Usuário não encontrado!";
    }
}
?>
<?php
if (isset($_SESSION["erro"])) {
    echo "<p style='color:red; text-align:center;'>" . $_SESSION["erro"] . "</p>";
    unset($_SESSION["erro"]);
}

if (isset($_SESSION["sucesso"])) {
    echo "<p style='color:green; text-align:center;'>" . $_SESSION["sucesso"] . "</p>";
    unset($_SESSION["sucesso"]);
}
?>


<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/styleproject.css">
	<style type="text/css">
	/* Reset básico */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
a{
	text-decoration: none;
	color: brown;
}
/* Estrutura principal */
header {
  background-color: #333;
  color: #fff;
  padding: 1rem;
  text-align: center;
}

nav {
  background-color: #444;
  display: flex;
  justify-content: center;
  gap: 1rem;
  padding: 0.5rem;
}

nav a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
}
.container {
  padding: 1rem;
  max-width: 1200px;
  margin: auto;
}

/* Responsividade */
@media (max-width: 768px) {
  nav {
    flex-direction: column;
    align-items: center;
  }

  nav a {
    padding: 0.5rem 0;
  }

  header {
    font-size: 1.2rem;
  }

  .container {
    padding: 0.5rem;
  }
}

@media (max-width: 480px) {
  header {
    font-size: 1rem;
    padding: 0.5rem;
  }

  nav {
    gap: 0.5rem;
  }

  .container {
    font-size: 0.9rem;
  }
}
.responsive-table {
  width: 100%;
  border-collapse: collapse;
}

.responsive-table th,
.responsive-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}

/* Estilo para telas menores */
@media (max-width: 600px) {
  .responsive-table,
  .responsive-table thead,
  .responsive-table tbody,
  .responsive-table th,
  .responsive-table td,
  .responsive-table tr {
    display: block;
    width: 100%;
  }

  .responsive-table thead tr {
    display: none; /* Esconde cabeçalho */
  }

  .responsive-table tr {
    margin-bottom: 15px;
    border: 1px solid #ddd;
    padding: 10px;
  }

  .responsive-table td {
    display: flex;
    justify-content: space-between;
    padding: 8px;
    border: none;
    border-bottom: 1px solid #eee;
  }

  .responsive-table td::before {
    content: attr(data-label);
    font-weight: bold;
    margin-right: 10px;
  }
}
/* Estilo geral do formulário */
form {
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  gap: 15px;
}

/* Inputs e textarea */
form input,
form textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  transition: border-color 0.3s;
}

form input:focus,
form textarea:focus {
  border-color: #007bff;
  outline: none;
}

/* Botão */
form button {
  padding: 12px;
  background: #007bff;
  color: #fff;
  font-size: 1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}

form button:hover {
  background: #0056b3;
}

/* Responsividade */
@media (min-width: 768px) {
  form {
    flex-direction: row;
    flex-wrap: wrap;
  }

  form input {
    flex: 1 1 calc(50% - 15px);
  }

  form textarea {
    flex: 1 1 100%;
    min-height: 120px;
  }

  form button {
    flex: 1 1 100%;
  }
}
	</style>
<title>Salas</title>
</head>

<body>
	<div class="container">
        <h1 align="center">Bem-vindo à minha biblioteca!</h1>
	    <form action="index.php" method="POST" autocomplete="on" enctype="multipart/form-data">
	    	<input type="text" id="primeiro_nome" name="primeiro_nome"
            required placeholder="Primeiro nome">
			<input type="password" id="senha" name="senha" required placeholder="Senha">
			<button type="submit">Entrar na sala</button>
		</form>
         <a href="salas/cadastro.php">Cadastre-se</a>
	</div>
</body>
</html>
