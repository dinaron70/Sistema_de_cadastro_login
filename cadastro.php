<?php
session_start();
include_once "conexao.php";
if (isset($_SESSION["sucesso"])) {
    echo "<p style='color: green; font-weight: bold; text-align: center;'>"
         . $_SESSION["sucesso"] . "</p>";
    unset($_SESSION["sucesso"]); // limpa a mensagem para não repetir
}

if (isset($_SESSION["erro"])) {
    echo "<p style='color: red; font-weight: bold; text-align: center;'>"
         . $_SESSION["erro"] . "</p>";
    unset($_SESSION["erro"]);
}

?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
	<!--<link rel="stylesheet" href="../css/styleproject.css">-->
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
		<div align="center"><a href="../index.php">Home</a></div>
        <h1 align="center">Bem-vindo à minha biblioteca!</h1>
		
		<h3 align="center">Página de cadastro de pessoas!</h3>
	    <form action="incluir_nome.php" method="post" autocomplete="on" enctype="multipart/form-data">
	    	<input type="text" id="primeiro_nome" name="primeiro_nome" required placeholder="Primeiro nome">
			<input type="text" id="sobrenome" name="sobrenome" required placeholder="Sobrenome">
			<input type="email" id="email" name="email" required placeholder="Email">
			<input type="text" id="cpf" name="cpf" maxlength="14" oninput="mascaraCPF(this)"
            required placeholder="CPF">
			<input type="text" id="cep" name="cep" maxlength="9" oninput="mascaraCEP(this)"
            onblur="buscarEndereco(this.value)"
            required placeholder="Cep">			
			<input type="text" id="logradouro" name="logradouro" required placeholder="Logradouro">
			<input type="text" id="bairro" name="bairro" required placeholder="Bairro">
			<input type="text" id="cidade" name="cidade" required placeholder="Cidade">
			<input type="text" id="uf" name="uf" required placeholder="UF">																   
			<input type="text" id="phone" name="phone" maxlength="15" oninput="mascaraCelular(this)" required placeholder="Celular">
			<input type="password" id="senha" name="senha" required placeholder="Senha">
			<input type="password" id="repet_senha" name="repet_senha" required placeholder="Repita a senha">
			<textarea id="textarea" name="textarea" required></textarea>
			<button type="submit">Enviar Relatório</button>
		</form>
		
		<script>
		document.addEventListener("DOMContentLoaded", function () {

			const campos = [
				"primeiro_nome",
				"sobrenome",
				"email",
				"cpf",
				"cep",	   
				"phone",
				"senha",
                "repet_senha",
				"textarea",
			    	  
			];

			// Desabilita todos os campos, exceto o primeiro
			for (let i = 1; i < campos.length; i++) {
				document.getElementById(campos[i]).disabled = true;
			}

			// Ativa o próximo campo somente quando o atual estiver preenchido
			campos.forEach((campo, index) => {
				const input = document.getElementById(campo);

				input.addEventListener("input", function () {
					if (input.value.trim() !== "" && campos[index + 1]) {
						document.getElementById(campos[index + 1]).disabled = false;
					}
				});

				// Impede clicar em campos futuros
				input.addEventListener("focus", function () {
					if (index > 0) {
						const anterior = document.getElementById(campos[index - 1]);
						if (anterior.value.trim() === "") {
							anterior.focus();
						}
					}
				});
			});

		});
     </script>
		
<script>
  async function buscarEndereco(cep) {
    cep = cep.replace(/\D/g, '');
    if (cep.length !== 8) {
      alert("CEP inválido!");
      return;
    }

    try {
      const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
      const data = await response.json();

      if (data.erro) {
        alert("CEP não encontrado!");
        return;
      }

      document.getElementById("logradouro").value = data.logradouro;
      document.getElementById("bairro").value = data.bairro;
      document.getElementById("cidade").value = data.localidade;
      document.getElementById("uf").value = data.uf;

    } catch (error) {
      alert("Erro ao buscar CEP!");
    }
  }
</script>													
<script>
    function mascaraCPF(campo) {
      let valor = campo.value.replace(/\D/g, ""); // remove não números
      valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
      valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
      valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      campo.value = valor;
    }

    function mascaraCEP(campo) {
      let valor = campo.value.replace(/\D/g, "");
      valor = valor.replace(/(\d{5})(\d)/, "$1-$2");
      campo.value = valor;
    }
	function mascaraCelular(campo) {
    let valor = campo.value.replace(/\D/g, ""); // remove não números

    // Formato: (99) 99999-9999
    if (valor.length > 10) {
      valor = valor.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else {
      valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    }

    campo.value = valor;
  }


  </script>


	</div>
</body>
</html>

