<?php
include 'Usuario.php';
session_start();
$message = ""; // Inicializa a variável de mensagem

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['codigo_adm'])) {
    if($_POST["codigo_adm"]=="mathias_adm"){
            // Obtém os dados do formulário
        $new_username = $_POST["username"];
        $new_password = $_POST["password"];

        // Cria uma nova instância da classe Usuario
        $usuario = new Usuario();

        // Tenta fazer login
        if ($usuario->register($new_username, $new_password)) {
            // Login bem-sucedido
            $message = "Cadastro bem-sucedido! ID do usuário: " . $usuario->getId();
            $_SESSION['id']=$usuario->getId();
            $_SESSION['username']=$usuario->getUsername();
            
        } else {
            // Login falhou
            $message = "Usuário ou senha inválidos.";
        }
    }else{
        echo '<script>alert("Você não é um administrador!")</script>';
    }
    echo "<script>console.log('{$message}')</script>";
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jornal Comunitário</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" href="imagens/LogoFL.jpeg" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Cadastrar Usuário</h1>
    </header>
    <main>
        <div class="login-container">
            <form asction="" class="login_form" method="POST">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required minlength="2" maxlength="50">
                <br>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required minlength="6" maxlength="255">
                <br>
                <br>
                <label for="codigo_adm">Código administrador:</label>
                <input type="codigo_adm" id="codigo_adm" name="codigo_adm" required minlength="6" maxlength="255">
                <br>
                <a href="login.php">Fazer Login</a>
                <br>
                <br>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Jornal Comunitário. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
