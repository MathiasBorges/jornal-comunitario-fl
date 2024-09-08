<?php
include 'Usuario.php';
session_start();
$message = ""; // Inicializa a variável de mensagem

if (isset($_POST['username']) && isset($_POST['password'])) {
    // Obtém os dados do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Cria uma nova instância da classe Usuario
    $usuario = new Usuario();

    // Tenta fazer login
    if ($usuario->login($username, $password)) {
        // Login bem-sucedido
        $message = "Login bem-sucedido! ID do usuário: " . $usuario->getId();
        $_SESSION['id']=$usuario->getId();
        $_SESSION['username']=$usuario->getUsername();
        header("Location: index.php");
    } else {
        // Login falhou
        $message = "Usuário ou senha inválidos.";
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
        <h1>Login</h1>
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
                <a href="cadastrar_usuario.php">Cadastrar no usuário</a>
                <br>
                <br>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Jornal Comunitário. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
