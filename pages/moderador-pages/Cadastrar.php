<?php
session_start();

// Conexão com o banco de dados
include('../../includes/db.php');

// Verifica se o usuário está logado
if (isset($_SESSION['user_id'])) {
    // Verifica se o id_usuario é igual a 3 (moderador)
    if ($_SESSION['user_id'] != 3) {
        // Se não for, redireciona para a página de login
        header("Location: ../geral-pages/html/Login.php");
        exit();
    }
} else {
    // Se não estiver logado, redireciona para a página de login
    header("Location: ../geral-pages/html/Login.php");
    exit();
}

function getTableColumns($conn, $table) {
    $columns = [];
    $result = $conn->query("DESCRIBE $table");

    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
    return $columns;
}

// Mensagem de status
$message = '';

// Processa o formulário de inserção
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tabela'])) {
    $tabela = $_POST['tabela'];
    $columns = getTableColumns($conn, $tabela);

    // Cria a query dinamicamente
    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $sql = "INSERT INTO $tabela (" . implode(',', $columns) . ") VALUES ($placeholders)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Vincula os parâmetros dinamicamente
        $params = [];
        $types = str_repeat('s', count($columns)); // Todos os campos como strings
        $params[] = & $types;
        foreach ($columns as $column) {
            $params[] = & $_POST[$column];
        }

        call_user_func_array([$stmt, 'bind_param'], $params);

        if ($stmt->execute()) {
            $message = "Dados inseridos com sucesso na tabela $tabela!";
        } else {
            $message = "Erro ao inserir os dados: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Erro ao preparar a query: " . $conn->error;
    }
}

function exibirNomeUsuario() {
    return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Dados nas Tabelas</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
          rel="stylesheet">
    <style>
        .message {
            width: 100%;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: white;
            position: fixed; /* Para manter a mensagem fixa no topo */
            top: 0; /* Posição superior */
            left: 0; /* Posição esquerda */
            z-index: 1000; /* Para garantir que fique acima de outros conteúdos */
            display: flex; /* Usado para alinhar o conteúdo */
            justify-content: space-between; /* Alinhamento horizontal */
            align-items: center; /* Alinhamento vertical */
        }
        .success {
            background-color: #4CAF50; /* Cor de sucesso: verde */
        }
        .error {
            background-color: #f44336; /* Cor de erro: vermelho */
        }
        .close-btn {
            cursor: pointer; /* Muda o cursor para indicar que é clicável */
            color: white; /* Cor do texto do botão */
            font-size: 18px; /* Tamanho da fonte */
            margin-left: 15px; /* Margem à esquerda */
        }
    </style>
</head>
<body>
<div id="nav-bar">
    <input id="nav-toggle" type="checkbox"/>
    <div id="nav-header"><a id="nav-title" href="https://codepen.io" target="_blank">Cetam<i></i>Class</a>
        <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
        <hr/>
    </div>
    <div id="nav-content">
        <div class="nav-button"><i class="fas fa-home"></i><span><a href="Home.php">Home</a></span></div>
        <div class="nav-button"><i class="fas fa-plus"></i><span><a href="Cadastrar.php">Cadastro</a></span></div>
        <div class="nav-button"><i class="fas fa-folder-minus"></i><span><a href="Atualizar-Del-Cads.php">Atualizar e Deletar</a></span></div>
        <div class="nav-button"><i class="fas fa-book-open"></i><span><a href="biblioteca.php">Biblioteca</a></span></div>
        <div class="nav-button"><i class="fas fa-exclamation-circle"></i><span><a href="avisos.php">Avisos</a></span></div>
        <hr/>
        <div id="nav-content-highlight"></div>
    </div>
    <input id="nav-footer-toggle" type="checkbox"/>
    <div id="nav-footer">
        <div id="nav-footer-heading">
            <div id="nav-footer-titlebox"><a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank"><?php echo exibirNomeUsuario(); ?></a><span id="nav-footer-subtitle">Modearador</span></div>
            <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
        </div>
        <div id="nav-footer-content">
            <button class="custom-btn" onclick="window.location.href='../../includes/logout.php'">Sair</button>
        </div>
    </div>
</div>

<div class="col-sm p-3 min-vh-100 content">
    <strong class="border-bottom border-2 border-primarymod" style="padding-bottom: 2px;font-size:x-large;">
        Inserir Dados nas Tabelas</strong>

    <!-- Exibir mensagem, se houver -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'sucesso') !== false ? 'success' : 'error'; ?>">
            <span><?php echo $message; ?></span>
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    <?php endif; ?>

    <!-- Selecionar a tabela -->
    <form method="GET">
        <div class="mb-3">
            <label for="tabela" class="form-label">Selecione a Tabela</label>
            <select class="form-select" name="tabela" id="tabela" required>
                <option value="">Selecione</option>
                <option value="aluno">Aluno</option>
                <option value="estado_m">Estado M</option>
                <option value="estado_c">Estado C</option>
                <option value="boletim">Boletim</option>
                <option value="componente">Componente</option>
                <option value="curso">Curso</option>
                <option value="moderador">Moderador</option>
                <option value="professor">Professor</option>
                <option value="turno">Turno</option>
                <option value="turma">Turma</option>
                <option value="usuario">Usuário</option>
                <option value="comptur">Comptur</option>
                <option value="profbol">Profbol</option>
            </select>
        </div>
        <button type="submit" class="btn" style="background-color:#722F37;color:white;">Selecionar Tabela</button>
    </form>

    <?php
    // Se a tabela foi selecionada, exibir o formulário para os campos
    if (isset($_GET['tabela'])) {
        $tabela = $_GET['tabela'];
        echo "<h3>Inserir dados na tabela: $tabela</h3>";

        // Obter colunas da tabela
        $conn = new mysqli("localhost", "root", "", "projetocetam");
        $columns = getTableColumns($conn, $tabela);
        $conn->close();

        echo '<form method="POST">';
        echo '<input type="hidden" name="tabela" value="' . htmlspecialchars($tabela) . '">';
        foreach ($columns as $column) {
            echo '<div class="mb-3">';
            echo '<label for="' . $column . '" class="form-label">' . ucfirst($column) . '</label>';
            echo '<input type="text" class="form-control" name="' . $column . '" required>';
            echo '</div>';
        }
        echo '<button type="submit" class="btn" style="background-color:#722F37;color:white;">Inserir Dados</button>';
        echo '</form>';
    }
    ?>
</div>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/codigos.js"></script>
</body>
</html>
