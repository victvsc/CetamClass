<?php
// Iniciar a sessão
session_start();

// Conexão com o banco de dados
include('../../../includes/db.php');

// Verifica se o usuário está logado
if (isset($_SESSION['user_id'])) {
  // Verifica se o id_usuario é igual a 3 (moderador)
  if ($_SESSION['user_id'] != 2) {
      // Se não for, redireciona para a página de login
      header("Location: ../../geral-pages/html/Login.php");
      exit();
  }
} else {
  // Se não estiver logado, redireciona para a página de login
  header("Location: ../../geral-pages/html/Login.php");
  exit();
}


// ID do professor logado
$id_professor_logado = $_SESSION['id_professor'];

// Atualizando os dados do boletim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_boletim = $_POST['id_boletim'];
    $frequencia = $_POST['frequencia'];
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    $n3 = $_POST['n3'];
    $media = ($n1 + $n2 + $n3) / 3;

    $sql = "UPDATE boletim SET frequencia='$frequencia', n1='$n1', n2='$n2', n3='$n3', media='$media' WHERE id_boletim='$id_boletim'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registro atualizado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro: " . $sql . " " . $conn->error . "');</script>";
    }
}
function exibirNomeUsuario() {
    return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
  }
// Consultando os alunos dos componentes que o professor leciona
$sql = "SELECT b.*, a.nome, a.sobrenome 
        FROM boletim b
        JOIN aluno a ON b.matricula = a.matricula
        JOIN componente c ON b.id_componente = c.id_componente
        WHERE c.id_professor = $id_professor_logado";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário Digital</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
        <style>
            /* Estilo para a tabela */
/* Estilo para a tabela */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #e6f7e6; /* Fundo suave verde-claro para a tabela */
    color: #333; /* Texto escuro */
    border: 1px solid #ccc; /* Borda leve para a tabela */
}

th, td {
    padding: 12px;
    border: 1px solid #ccc; /* Borda entre as células */
    text-align: left;
}

th {
    background-color: #228B22; /* Cor da sidebar para o cabeçalho */
    color: white; /* Texto branco no cabeçalho */
}

td {
    background-color: #f0fff0; /* Fundo verde-claro nas células */
    color: #333; /* Cor do texto */
}

td input {
    border: 1px solid #ccc; /* Borda leve para inputs */
    border-radius: 4px;
    padding: 6px;
    width: 80px;
}

tbody tr:nth-child(even) {
    background-color: #d8f3d8; /* Fundo verde mais suave para linhas pares */
}

tbody tr:hover {
    background-color: #c2e0c2; /* Fundo verde mais intenso ao passar o mouse */
}

button.btn-primary {
    background-color: #228B22; /* Botão verde floresta */
    border-color: #006400; /* Borda mais escura */
}

button.btn-primary:hover {
    background-color: #006400; /* Escurecer botão no hover */
    border-color: #004d00; /* Borda mais escura no hover */
}
.custom-btn {
        border-radius: 0.375rem;
        border: 2px solid #00FF7F;
        /* Borda azul padrão do Bootstrap */
        background-color: #00FF7F;
        /* Fundo transparente */
        color: #006400;
        /* Texto da cor da borda */
        transition: background-color 0.3s, color 0.3s;
        /* Transição suave para o hover */
    }

    .custom-btn:hover {
        border: 2px solid #006400;
        background-color: #006400;
        /* Fundo preenchido ao passar o mouse */
        color: white;
        /* Cor do texto ao passar o mouse */
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
    <div class="nav-button"><i class="fas fa-home"></i><span><a href="./index.php">Home</a></span></div>
    <div class="nav-button"><i class="fas fa-book"></i><span><a href="./diario.php">Diário</a></span></div>
    <div class="nav-button"><i class="fas fa-folder"></i><span><a href="./germat.php">Gerenciar Materiais</a></span></div>
    <hr/>
    <div class="nav-button"><i class="fas fa-book"></i><span><a href="./gerativ.php">Gerenciar Atividades</a></span></div>
    <div class="nav-button"><i class="fas fa-book-open"></i><span><a href="./biblioteca.php">Biblioteca</a></span></div>
    <div class="nav-button"><i class="fas fa-exclamation-circle"></i><span><a href="./avisos.php">Avisos</a></span></div>
    <hr/>
    <div id="nav-content-highlight"></div>
  </div>
  <input id="nav-footer-toggle" type="checkbox"/>
  <div id="nav-footer">
    <div id="nav-footer-heading">
     
      <div id="nav-footer-titlebox"><a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank"><?php echo exibirNomeUsuario($conn); ?></a><span id="nav-footer-subtitle">Professor</span></div>
      <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
    </div>
    <div id="nav-footer-content">
                <button class="custom-btn" onclick="window.location.href='../../../includes/logout.php'">Sair</button>
            </div>
    <div id="nav-footer-content">
    </div>
  </div>
</div>
<div class="container mt-4 content">
    <h2>Registro de Notas e Presença</h2>

    <h3>Registros do Boletim</h3>
    <table class="table table-striped"> 
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Aluno</th>
                <th>Frequência (%)</th>
                <th>Nota 1</th>
                <th>Nota 2</th>
                <th>Nota 3</th>
                <th>Média</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php   
           
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Concatenando nome e sobrenome para exibir como "Aluno"
                    $aluno = $row['nome'] . " " . $row['sobrenome'];
                    echo "<tr>
                        <form method='post'>
                            <td>{$row['matricula']}</td>
                            <td>{$aluno}</td>
                            <td><input type='number' name='frequencia' value='{$row['frequencia']}' style='width: 80px;' required></td>
                            <td><input type='number' name='n1' value='{$row['n1']}' step='0.1' style='width: 64px;' required></td>
                            <td><input type='number' name='n2' value='{$row['n2']}' step='0.1' style='width: 64px;' required></td>
                            <td><input type='number' name='n3' value='{$row['n3']}' step='0.1' style='width: 64px;' required></td>
                            <td><input type='number' name='media' value='{$row['media']}' style='width: 64px;' readonly></td>
                            <td>
                                <input type='hidden' name='id_boletim' value='{$row['id_boletim']}'> <!-- Hidden input for id_boletim -->
                                <button type='submit' name='update' class='btn btn-primary btn-sm'>Atualizar</button>
                            </td>
                        </form>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Nenhum registro encontrado.</td></tr>";
            }
            ?>
        </tbody>
        
    </table>
</div>
<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</html>



<?php
$conn->close();
?>
