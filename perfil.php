<?php
include 'Usuario.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];
} else {
    // Redirecione para a página de login se o usuário não estiver logado
    header("Location: login.php");
    exit();
}

// Verifica se o formulário foi enviado
if (isset($_POST['titulo']) && isset($_POST['conteudo']) && isset($_POST['categoria'])) {
    // Obtém os dados do formulário
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $categoria = $_POST['categoria']; // Captura a categoria do formulário
    $usuario_id = $userId; // ID do usuário logado

    // Inicializa a variável para o caminho da imagem
    $imagemPath = null;

    // Processa o upload da imagem, se houver
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $imagemNome = basename($_FILES['imagem']['name']);
        $imagemDir = 'uploads/'; // Diretório onde as imagens serão armazenadas

        // Verifica se o diretório de uploads existe
        if (!is_dir($imagemDir)) {
            mkdir($imagemDir, 0777, true); // Cria o diretório se não existir
        }

        $imagemPath = $imagemDir . $imagemNome;

        // Move a imagem para o diretório de uploads
        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
            echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
            exit();
        }
    }

    // Cria uma nova instância da classe Usuario
    $usuario = new Usuario();

    // Tenta adicionar a notícia ao banco de dados
    if ($usuario->addNoticia($titulo, $conteudo, $usuario_id, $imagemPath, $categoria)) {
        echo "<script>alert('Notícia adicionada com sucesso!');</script>";
        header("Location: index.php"); // Redireciona para a página inicial
        exit();
    } else {
        echo "<script>alert('Erro ao adicionar a notícia.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Jornal Comunitário</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="perfil.css">
    <link rel="shortcut icon" href="imagens/LogoFL.jpeg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($username); ?>!</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="perfil.php">Perfil</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
    <main>
        <div class="perfil-container">
            <h2>Adicionar Notícia</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required minlength="2" maxlength="100">
                <br>
                <label for="conteudo">Conteúdo:</label>
                <textarea id="conteudo" name="conteudo" required minlength="10"></textarea>
                <br>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="noticia">Notícia</option>
                    <option value="entrevista">Entrevista</option>
                    <option value="opiniao">Opinião</option>
                    <option value="cultura-e-lazer">Cultura e Lazer</option>
                    <option value="historia-e-memoria">História e Memória</option>
                    <option value="esporte">Esporte</option>
                    <option value="meio-ambiente-e-sustentabilidade">Meio Ambiente e Sustentabilidade</option>
                    <option value="tecnologias-e-inovacao">Tecnologias e Inovação</option>
                </select>
                <br>
                <label for="imagem">Adicionar Imagem (opcional):</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
                <br>
                <button type="submit">Adicionar Notícia</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Jornal Comunitário. Todos os direitos reservados.</p>
    </footer>
</body>
</html>