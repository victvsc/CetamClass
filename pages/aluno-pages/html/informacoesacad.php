<?php
session_start();
include('../../../includes/db.php');

// Verifica se o usuário está logado e se é o moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: ../../geral-pages/html/Login.php");
    exit();
}

function exibirBoletim($matricula, $conn) {
    $query = "
        SELECT 
            a.nome AS nome_aluno,
            b.n1, 
            b.n2, 
            b.n3, 
            b.frequencia, 
            b.media,
            b.obs,
            c.nome AS nome_componente, 
            p.nome AS nome_professor
        FROM boletim b
        JOIN componente c ON b.id_componente = c.id_componente
        JOIN professor p ON c.id_professor = p.id_professor
        JOIN aluno a ON b.matricula = a.matricula
        WHERE b.matricula = ?
    ";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $matricula);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='content'>
                    <table class='table table-bordered table-striped'>
                        <thead>
                          <tr>
                              <th>Aluno</th>
                              <th>Componente</th>
                              <th>Professor</th>
                              <th>Nota 1</th>
                              <th>Nota 2</th>
                              <th>Nota 3</th>
                              <th>Frequência</th>
                              <th>Média</th>
                              <th>Status</th>
                              <th>Observações</th>
                          </tr>
                        </thead>
                        <tbody>";

            while ($row = $result->fetch_assoc()) {
                $status = ($row['frequencia'] < 75) ? "Reprovado por falta" : (($row['media'] >= 6.0) ? "Aprovado" : "Reprovado");
                echo "<tr>
                        <td>{$row['nome_aluno']}</td>
                        <td>{$row['nome_componente']}</td>
                        <td>{$row['nome_professor']}</td>
                        <td>{$row['n1']}</td>
                        <td>{$row['n2']}</td>
                        <td>{$row['n3']}</td>
                        <td>{$row['frequencia']}%</td>
                        <td>{$row['media']}</td>
                        <td class='status-" . strtolower(str_replace(' ', '-', $status)) . "'>{$status}</td>
                        <td>{$row['obs']}</td>
                      </tr>";
            }

            echo "</tbody></table></div>";
        } else {
            echo "<div class='alert alert-warning'>Nenhum boletim encontrado para a matrícula: {$matricula}.</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erro ao preparar a consulta: " . $conn->error . "</div>";
    }
}

if (isset($_SESSION['matricula'])) {
    $matricula = $_SESSION['matricula'];
} else {
    $matricula = null;
}

function exibirNomeUsuario() {
    return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
}

// Mova o fechamento da conexão para o final
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Informações Acadêmicas - Aluno</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    /* Adicione seus estilos personalizados aqui */
    .custom-badge {
      background-color: #0052c5;
    }
    .custom-btn {
      border-radius: 0.375rem;
      border: 2px solid #1e90ff;
      background-color: #1e90ff;
      color: white;
      transition: background-color 0.3s, color 0.3s;
    }
    .custom-btn:hover {
      background-color: #1c86ee;
      border-color: #1c86ee;
      color: white;
    }
    .content {
      margin-top: 30px;
      animation: fade-in 0.5s;
    }
    @keyframes fade-in {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    table {
      width: 100%;
      margin-bottom: 1.5rem;
      font-family: 'Josefin Sans', sans-serif;
    }
    th, td {
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #0052c5;
      color: white;
      font-weight: bold;
      text-transform: uppercase;
    }
    td {
      background-color: #f9f9f9;
      color: #333;
    }
    tr:nth-child(even) td {
      background-color: #f2f2f2;
    }
    tr:hover td {
      background-color: #e9ecef;
      transition: background-color 0.3s ease;
    }
    .status-aprovado {
      color: green;
      font-weight: bold;
    }
    .status-reprovado {
      color: red;
      font-weight: bold;
    }
    .status-reprovado-por-falta {
      color: orange;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div id="nav-bar">
  <input id="nav-toggle" type="checkbox"/>
  <div id="nav-header">
    <a id="nav-title" href="#">Cetam<i></i>Class</a>
    <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
    <hr/>
  </div>
  <div id="nav-content">
    <div class="nav-button"><i class="fas fa-home"></i><span><a href="./index.php">Home</a></span></div>
    <div class="nav-button"><i class="fas fa-book"></i><span><a href="./informacoesacad.php">Informações Acadêmicas</a></span></div>
    <hr/>
    <div class="nav-button"><i class="fas fa-folder"></i><span><a href="./turvirt.php">Turma Virtual</a></span></div>
    <div class="nav-button"><i class="fas fa-table"></i><span><a href="./matrizcur.php">Matriz Curricular</a></span></div>
    <div class="nav-button"><i class="fas fa-book-open"></i><span><a href="./biblioteca.php">Biblioteca</a></span></div>
    <div class="nav-button"><i class="fas fa-exclamation-circle"></i><span><a href="./avisos.php">Avisos</a></span></div>
    <hr/>
    <div id="nav-content-highlight"></div>
  </div>
  <input id="nav-footer-toggle" type="checkbox"/>
  <div id="nav-footer">
    <div id="nav-footer-heading">
      <div id="nav-footer-titlebox">
        <a id="nav-footer-title" href="#"><?php echo exibirNomeUsuario(); ?></a><span id="nav-footer-subtitle">Aluno</span>
      </div>
      <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
    </div>
    <div id="nav-footer-content">
      <button class="custom-btn" onclick="window.location.href='../../../includes/logout.php'">Sair</button>
    </div>
  </div>
</div>

<div class="container content">
    <h1 class="text-center my-4">Boletim do Aluno</h1>
  </div>
    <?php
        if ($matricula) {
            exibirBoletim($matricula, $conn);
        } else {
            echo "<div class='alert alert-warning'>Matrícula não encontrada.</div>";
        }
    ?>
</div>

<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</html>

<?php
$conn->close(); // Mova para o final do script
?>