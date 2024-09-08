<?php
class Usuario {
    private $dsn = 'mysql:host=localhost;dbname=jornal_comunitario;charset=utf8';
    private $db;
    private $id;
    private $username;
    private $password;

    public function __construct() {
        // Conectar ao banco de dados
        try {
            $this->db = new PDO($this->dsn, "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<script>console.log(' Conexão bem sucedida')</script>";
        } catch (PDOException $e) {
            echo "<script>console.log(' Erro de conexão: {$e->getMessage()} ')</script>";
            exit;
        }
    }

    public function login($username, $password) {
        $this->username = $username;
        $this->password = $password;

        // Preparar a consulta SQL
        $stmt = $this->db->prepare("SELECT id, username, password FROM usuarios WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        // Obter os resultados
        // Obter os resultados
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->id = $row["id"];

    // Debug: Verifique os dados retornados
    echo "<script>console.log('Dados retornados: " . json_encode($row) . "');</script>";

    // Verificar a senha
    if (password_verify($password, $row["password"])) {
            // Login bem-sucedido
            return true;
        } else {
            // Senha incorreta
            return false;
        }
        } else {
        // Usuário não encontrado
        return false;
        }
    }

    public function register($username, $password) {
        // Verifica se o nome de usuário já existe
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    
        if ($stmt->fetchColumn() > 0) {
            return false; // Nome de usuário já existe
        }
    
        // Se o nome de usuário não existe, continua com o registro
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Preparar a consulta SQL
        $stmt = $this->db->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
    
        // Executar a consulta
        if ($stmt->execute()) {
            return true; // Registro bem-sucedido
        } else {
            return false; // Falha no registro
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function addNoticia($titulo, $conteudo, $usuario_id, $imagemPath = null, $categoria) {
        // Preparar a consulta SQL
        $stmt = $this->db->prepare("INSERT INTO noticias (titulo, conteudo, usuario_id, imagem, categoria) VALUES (:titulo, :conteudo, :usuario_id, :imagem, :categoria)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':conteudo', $conteudo);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':imagem', $imagemPath);
        $stmt->bindParam(':categoria', $categoria); // Novo parâmetro de categoria
    
        // Executar a consulta
        return $stmt->execute(); // Retorna true se a inserção foi bem-sucedida
    }
}


?>