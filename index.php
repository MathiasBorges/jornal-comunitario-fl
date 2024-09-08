<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];
} else {
    // Redirecione para a página de login se o usuário não estiver logado
    header("Location: login.php");
    exit();
}

include 'Usuario.php';

// Conexão com o banco de dados
$dsn = 'mysql:host=localhost;dbname=jornal_comunitario;charset=utf8';
$dbUsername = 'root'; // Substitua pelo seu usuário do banco de dados
$dbPassword = ''; // Substitua pela sua senha do banco de dados

try {
    $db = new PDO($dsn, $dbUsername, $dbPassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para recuperar as notícias
    $stmt = $db->prepare("SELECT * FROM noticias ORDER BY data_criacao DESC");
    $stmt->execute();
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jornal Comunitário</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="imagens/LogoFL.jpeg" type="image/x-icon">
</head>
<body onload="verificarImagem()">
<header>
    <div class="header-container">
        <img src="imagens/LogoJornal.png" alt="" class="logo"> <!-- Imagem ao lado do título -->
        <h1>Jornal Comunitário</h1>

        <div class="menu-login-container">
            <?php if (isset($username)) { ?>
                <a href="perfil.php" class="usuario_logado">Olá, <?php echo htmlspecialchars($username); ?>!</a>
            <?php } else { ?>
                <a href="login.php" class="login-button">Login</a>
            <?php } ?>
            <label class="menu-icon" onclick="exibirCategorias()">&#9776;</label> <!-- Ícone de menu -->
        </div>
    </div>
    <nav class="nav-popup">
        <label class="close-menu" onclick="fecharCategorias()">&times;</label> <!-- Ícone de fechar -->
        <ul>
            <li><a href="#noticias-locais">Notícias Locais</a></li>
            <li><a href="#entrevistas">Entrevistas</a></li>
            <li><a href="#opiniao">Opinião</a></li>
            <li><a href="#cultura-lazer">Cultura e Lazer</a></li>
            <li><a href="#educacao">Educação</a></li>
            <li><a href="#historia-memoria">História e Memória</a></li>
            <li><a href="#esportes">Esportes</a></li>
            <li><a href="#meio-ambiente">Meio Ambiente</a></li>
        </ul>
    </nav>
</header>
    
<main>

    <section id="noticias-locais">
        <h2>Notícias Locais</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'noticia'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'noticia'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="entrevistas">
        <h2>Entrevistas</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'entrevista'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'entrevista'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="opiniao">
        <h2>Opinião</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'opiniao'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'opiniao'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="cultura-lazer">
        <h2>Cultura e Lazer</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'cultura-e-lazer'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'cultura-e-lazer'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="educacao">
        <h2>Educação</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'educacao'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'educacao'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="historia-memoria">
        <h2>História e Memória</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'historia-e-memoria'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'historia-e-memoria'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="esportes">
        <h2>Esportes</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'esporte'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'esporte'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="meio-ambiente">
        <h2>Meio Ambiente</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'meio-ambiente-e-sustentabilidade'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'meio-ambiente-e-sustentabilidade'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="tecnologias-inovacao">
        <h2>Tecnologias e Inovação</h2>
        <div class="grid-container">
            <?php foreach ($noticias as $noticia): ?>
                <?php if ($noticia['categoria'] === 'tecnologias-e-inovacao'): ?>
                    <article>
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <?php if ($noticia['imagem']): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" class="noticia-imagem">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($noticia['conteudo']); ?></p>
                        <p><em>Categoria: <?php echo htmlspecialchars($noticia['categoria']); ?></em></p>
                        <p><em>Publicado em: <?php echo $noticia['data_criacao']; ?></em></p>
                    </article>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty(array_filter($noticias, fn($n) => $n['categoria'] === 'tecnologias-e-inovacao'))): ?>
                <p>Nenhuma notícia disponível.</p>
            <?php endif; ?>
        </div>
    </section>

</main>

<footer>
    <p>&copy; 2024 Jornal Comunitário. Todos os direitos reservados.</p>
</footer>

<script src="script.js"></script>
</body>
</html>