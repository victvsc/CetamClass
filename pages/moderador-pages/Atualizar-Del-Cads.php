<!-- Conexão com o Banco -->
<?php
session_start();
include('../../includes/db.php'); // Inclua seu arquivo de conexão com o banco de dados aqui

// Verifica se o usuário está autenticado
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
$nomeModerador = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';

// Função para executar uma consulta SQL
function executeQuery($sql)
{
    global $conn;
    $result = $conn->query($sql);
    return $result;
}

// Função para obter o nome da coluna de chave primária de uma tabela
function getPrimaryKeyColumn($table)
{
    global $conn;
    $table = $conn->real_escape_string($table); // Escapa o nome da tabela
    $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
    $result = executeQuery($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Column_name']; // Retorna o nome da coluna de chave primária
    }
    return null;
}

// Função para exibir os resultados de uma consulta
function displayResults($result, $table)
{
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        $first_row = true;
        while ($row = $result->fetch_assoc()) {
            if ($first_row) {
                // Cabeçalho da tabela
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                }
                echo "<th>Ações</th>"; // Adiciona uma coluna para ações
                echo "</tr>";
                $first_row = false;
            }
            // Linhas de dados
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            // Obtém a coluna de chave primária
            $primary_key_column = getPrimaryKeyColumn($table);
            if ($primary_key_column) {
                // Adiciona botão de ação para deletar
                echo "<td>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='table' value='$table'>";
                echo "<input type='hidden' name='id_column' value='$primary_key_column'>";
                echo "<input type='hidden' name='id_value' value='" . $row[$primary_key_column] . "'>";
                echo "<button type='submit' name='delete' style='border:none;background-color:#722F37;color:white;' class='rounded-pill'>Deletar</button>";
                echo "</form>";
                echo "</td>";
            } else {
                echo "<td>Ações Indisponíveis</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum resultado encontrado.";
    }
}

// Função para deletar um registro na tabela
function deleteRecord($table, $id_column, $id_value)
{
    global $conn;
    $table = $conn->real_escape_string($table); // Escapa o nome da tabela
    $id_column = $conn->real_escape_string($id_column); // Escapa o nome da coluna de ID
    $sql_delete = "DELETE FROM $table WHERE $id_column = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_value);
    if ($stmt_delete->execute()) {
        echo "Registro deletado com sucesso.";
    } else {
        echo "Erro ao deletar registro: " . $conn->error;
    }
}

// Função para atualizar um registro na tabela
function updateRecord($table, $id_column, $id_value, $campo_a_atualizar, $novo_valor)
{
    global $conn;
    $table = $conn->real_escape_string($table); // Escapa o nome da tabela
    $id_column = $conn->real_escape_string($id_column); // Escapa o nome da coluna de ID
    $campo_a_atualizar = $conn->real_escape_string($campo_a_atualizar); // Escapa o nome do campo a atualizar
    $sql_update = "UPDATE $table SET $campo_a_atualizar = ? WHERE $id_column = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $novo_valor, $id_value); // O tipo "si" indica uma string e um inteiro
    if ($stmt_update->execute()) {
        echo "Registro atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar registro: " . $conn->error;
    }
}

// Verifica se houve um POST para deletar um registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $table = $_POST['table'];
    $id_column = $_POST['id_column'];
    $id_value = $_POST['id_value'];
    deleteRecord($table, $id_column, $id_value);
}

// Verifica se houve um POST para atualizar um registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $table = $_POST['table'];
    $id_column = $_POST['id_column'];
    $id_value = $_POST['id_value'];
    $campo_a_atualizar = $_POST['campo_a_atualizar'];
    $novo_valor = $_POST['novo_valor'];
    updateRecord($table, $id_column, $id_value, $campo_a_atualizar, $novo_valor);
}
function exibirNomeUsuario() {
    return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
}
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cadastros</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <style>
    body {
        margin: 0;
        /* Remove margens padrão do body */
    }

    table {
  width: 100%;
  border-collapse: collapse;
}

table th,
table td {
  border: 1px solid #722F37;
  padding: 10px;
  text-align: left;
}

table th {
  background-color: #722F37;
  color: white;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}

table tr:hover {
  background-color: #ddd;
}


    .custom-btn {
        border-radius: 0.375rem;
        border: 2px solid #a84551;
        background-color: #a84551;
        color: white;
        transition: background-color 0.3s, color 0.3s;
    }

    .custom-btn:hover {
        border: 2px solid #872e3a;
        background-color: #872e3a;
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
      <div class="nav-button"><i class="fas fa-home"></i><span><a href="Home.php">Home</a></span></div>
      <div class="nav-button"><i class="fas fa-plus"></i><span><a href="Cadastrar.php">Cadastro</a></span></div>
      <div class="nav-button"><i class="fas fa-folder-minus"></i><span><a href="Atualizar-Del-Cads.php">Atualizar e Deletar</a></span></div>
      <div class="nav-button"><i class="fas fa-book-open"></i><span><a href="biblioteca.php">Biblioteca</a></span></div>
                <div class="nav-button"><i class="fas fa-exclamation-circle"></i><span><a href="avisos.php">Avisos</a></span></div><hr/>


      <div id="nav-content-highlight"></div>
    </div>

    <input id="nav-footer-toggle" type="checkbox"/>
      <div id="nav-footer">
        <div id="nav-footer-heading">
        <div id="nav-footer-titlebox"><a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank"><?php echo exibirNomeUsuario($conn); ?></a><span id="nav-footer-subtitle">Modearador</span></div>
        <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
      </div>
    
     
      <div id="nav-footer-content">
                <button class="custom-btn" onclick="window.location.href='../../includes/logout.php'">Sair</button>
            </div>

  </div>
</div>  
    <div class="col-sm p-3 min-vh-100">
        <div class="content">
            <h2 class="mt-4 border-bottom border-2 border-primarymod pb-2" style="display: inline-block;">
                <strong>Atualizar Registro</strong>
            </h2>

            <form class="form mt-3" method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="table_update" class="form-label" style="">Tabela:</label>
                        <input type="text" class="form-control form-control-sm" name="table" id="table_update" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="id_column_update" class="form-label">Coluna ID:</label>
                        <input type="text" class="form-control form-control-sm" name="id_column" id="id_column_update"
                            required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_value_update" class="form-label">ID:</label>
                        <input type="text" class="form-control form-control-sm" name="id_value" id="id_value_update"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="campo_a_atualizar" class="form-label">Campo a Atualizar:</label>
                        <input type="text" class="form-control form-control-sm" name="campo_a_atualizar"
                            id="campo_a_atualizar" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="novo_valor" class="form-label">Novo Valor:</label>
                        <input type="text" class="form-control form-control-sm" name="novo_valor" id="novo_valor"
                            required>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <button type="submit" name="update" class="btn btn-sm" style="background-color: #722F37;color
                        :white;">Atualizar Registro</button>
                    </div>
                </div>
            </form>
            <!-- Opção de Consultar e Deletar -->
            <h2>
                <strong class="border-bottom border-2 border-primarymod pb-2">Consultar e Deletar Dados</strong>
            </h2>

            <form class="mt-4" method="GET" action="">
                <div class="mb-3 d-flex align-items-center">
                    <label for="table" class="form-label me-2" style="font-size: larger;">Selecione a Tabela:</label>
                    <div style="position: relative; display: inline-block;">
                        <select class=" btn form-select rounded-pill"
                            style="background-color: #722F37; color: white; border: none; width: 200px; appearance: none; padding-right: 30px;"
                            name="table" id="table">
                            <option value="default" selected>Opções</option>
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
                        <span
                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); pointer-events: none; color: white;">
                            ▼
                        </span>
                    </div>
                    <button class="btn btn-sm rounded-pill ms-2" style="background-color:#a84551;color:white;" type="submit"
                        style="width: 200px;">Consultar</button>
                </div>
            </form>






            <?php
            // Exibe os resultados da consulta, se houver
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table'])) {
                $table = $_GET['table'];
                $sql_select = "SELECT * FROM $table";
                $result = executeQuery($sql_select);
                displayResults($result, $table); // Passa o nome da tabela como segundo argumento
            }
            ?>

            <!-- Opção de Atualizar -->


            <script type="text/javascript" src="../../js/bootstrap.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="../../js/codigos.js"></script>
</body>

</html>