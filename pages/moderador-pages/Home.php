<?php
session_start();
include('../../includes/db.php');

// Verificação se o usuário está logado
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

// Função para exibir o nome do usuário
function exibirNomeUsuario() {
    return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
}

// Consulta 1: Total de alunos por turma e turno
$sql1 = "SELECT t.nome AS turma, tn.descricao 
AS turno, COUNT(a.matricula) AS total_alunos
          FROM turma t
          LEFT JOIN aluno a ON t.id_turma = a.id_turma
          LEFT JOIN turno tn ON tn.id_turno = t.id_turno
          GROUP BY tn.id_turno, t.id_turma";
$result1 = $conn->query($sql1);

if (!$result1) {
    die("Erro na consulta SQL 1: " . $conn->error);
}

// Consulta 2: Total de alunos por estado de matrícula
$sql2 = "SELECT em.descricao AS descricao, COUNT(a.sim) AS total 
          FROM aluno a 
          LEFT JOIN estado_m em ON em.sim = a.sim 
          GROUP BY em.sim";
$result2 = $conn->query($sql2);

if (!$result2) {
    die("Erro na consulta SQL 2: " . $conn->error);
}

$sql3 = "SELECT p.nome AS 'Professor',c.nome 
AS 'Componente',t.nome 
AS 'Turma',t.id_turma,COUNT(a.matricula) AS 'quantidade'FROM aluno a
JOIN turma t
ON t.id_turma = a.id_turma
JOIN professor p
ON p.id_turma = t.id_turma
join componente c
on c.id_professor=p.id_professor
GROUP BY p.nome, t.nome
ORDER BY t.id_turma;";
$result3 = $conn->query($sql3);

if (!$result2) {
    die("Erro na consulta SQL 3: " . $conn->error);
}
// Fechamento da conexão com o banco de dados
$conn->close();
?>


<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <style>
        .custom-badge{
            background-color:#722F37;
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

.accordion-button:focus,
.accordion-button:not(.collapsed) {
  box-shadow: none !important;
  border-color: #722F37 !important;
  background-color: #722F37 !important;
  color: white !important;
}

.accordion-button.collapsed:focus {
  box-shadow: none !important;
  background-color: #f8f9fa !important;
  color: #722F37 !important;
}


.accordion-body {
  border: 1px solid #722F37;
}

        .todo-container {
            display: flex;
            justify-content: space-between;
        }
        .todo-column {
            width: 30%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }
        .todo-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            position: relative;
        }
        .todo-card.completed {
            background-color: #722F37;
            text-decoration: line-through;
        }
        .add-task-card {
            border: 2px dashed #722F37;
            color: #722F37;
            text-align: center;
            cursor: pointer;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .add-task-card:hover {
            background-color: #722F37;
            color: #ffff;
        }
        .task-actions {
            display: flex;
            gap: 5px;
        }
        .remove-task-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: transparent;
            border: none;
            color: #dc3545;
            font-size: 1.2em;
            cursor: pointer;
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
      <h1><strong>Olá, <?php echo exibirNomeUsuario($conn); ?> ! <span class="badge badge-pill custom-badge" style="color: white;font-size:small;vertical-align: middle;">Moderador</span></strong></h1>
    </div>
    <div class="content-list">
      <div class="  mt-5">
        <strong class="border-bottom border-2 border-primarymod" style="padding-bottom: 2px;font-size: x-large;">Suas Tarefas</strong>
        <br>
        <br>
        <div class="todo-container ">
            <div id="todo-to-do" class="todo-column">
                <h4>Não iniciadas <span class="badge" style="background-color:#722F37" id="todo-to-do-count">0</span></h4>
                <!-- Botão "Adicionar Tarefa" fixo na coluna "Não iniciadas" -->
                <div id="add-task-card" class="todo-card add-task-card" onclick="openTaskModal('to-do')">
                    <span>+ Adicionar Tarefa</span>
                </div>
            </div>
            <div id="todo-in-progress" class="todo-column">
                <h4>Iniciadas <span class="badge" style="background-color:#722F37" id="todo-in-progress-count">0</span></h4>
            </div>
            <div id="todo-completed" class="todo-column">
                <h4>Concluídas <span class="badge" style="background-color:#722F37" id="todo-completed-count">0</span></h4>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">Adicionar/Editar Tarefa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="task-title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="task-title">
                        </div>
                        <div class="mb-3">
                            <label for="task-description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="task-description" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="task-status">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="saveTask()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        <br>
        <div class="content">
      <strong class="border-bottom border-2 border-primarymod" style="padding-bottom: 2px;font-size:x-large;">Relatórios Rápidos</strong>
    <br>
    <br>
      <div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      <h3>Relação Alunos por Turma e Turno</h3>
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <table>
    <thead>
        <tr>
            <th>Turma</th>
            <th>Turno</th>
            <th>Total de Alunos</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result1 && $result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                echo "<tr><td>" . $row['turma'] 
                . "</td><td>" . $row['turno'] 
                . "</td><td>" . $row['total_alunos'] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
        }
        ?>
    </tbody>
</table>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <h3>Relação Alunos por Estado da Matrícula</h3>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <table>
    <thead>
        <tr>
            <th>Estado da Matrícula</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result2 && $result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                echo "<tr><td>" . $row['descricao'] . "</td><td>" 
                . $row['total'] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
        }
        ?>
    </tbody>
</table>
</div>
    </div>
  </div>
<div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <h3>Relação Professor,Componente e Turma</h3>
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <table>
    <thead>
        <tr>
            <th>Professor (a) </th>
            <th>Componente</th>
            <th>Turma</th>
            <th>ID</th>
            <th>Qtd de Alunos</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result3 && $result3->num_rows > 0) {
            while ($row = $result3->fetch_assoc()) {
                echo "<tr>"
                                . "<td>" . $row['Professor'] . "</td>"
                                . "<td>" . $row['Componente'] . "</td>"
                                . "<td>" . $row['Turma'] . "</td>"
                                . "<td>" . $row['id_turma'] . "</td>"
                                . "<td>" . $row['quantidade'] . "</td>"
                                . "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
        }
        ?>
    </tbody>
</table>

      </div>
    </div>
  </div>
        
</body>
</html>
    </div>

  <script>  
      const navToggle = document.getElementById('nav-toggle');
      const body = document.body;
  
      navToggle.addEventListener('change', function() {
          if (this.checked) {
              body.classList.add('sidebar-expanded');
          } else {
              body.classList.remove('sidebar-expanded');
          }
      });
      let tasks = [];
        let currentTaskIndex = -1;
        const statusElements = {
            'to-do': document.getElementById('todo-to-do'),
            'in-progress': document.getElementById('todo-in-progress'),
            'completed': document.getElementById('todo-completed')
        };

        document.addEventListener('DOMContentLoaded', () => {
            renderTasks();
        });

        function openTaskModal(status) {
            document.getElementById('task-status').value = status;
            document.getElementById('task-title').value = ''; // Limpar campos do formulário
            document.getElementById('task-description').value = '';
            currentTaskIndex = -1; // Resetar o índice da tarefa
            const modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.show();
        }

        function saveTask() {
            const title = document.getElementById('task-title').value;
            const description = document.getElementById('task-description').value;
            const status = document.getElementById('task-status').value;

            if (title && description) {
                const task = { title, description, status, completed: false };

                if (currentTaskIndex > -1) {
                    tasks[currentTaskIndex] = task; // Atualizar tarefa existente
                } else {
                    tasks.push(task); // Adicionar nova tarefa
                }

                renderTasks();
                const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
                modal.hide();
            } else {
                alert('Por favor, preencha todos os campos.');
            }
        }

        function renderTasks() {
            // Clear columns, except the "Adicionar Tarefa" card
            Object.values(statusElements).forEach(col => {
                const cards = col.querySelectorAll('.todo-card:not(#add-task-card)');
                cards.forEach(card => card.remove());
            });

            // Render tasks
            tasks.forEach((task, index) => {
                const taskCard = document.createElement('div');
                taskCard.className = 'todo-card';
                if (task.completed) taskCard.classList.add('completed');

                taskCard.innerHTML = `
                    <button class="remove-task-btn" onclick="deleteTask(${index})">&times;</button>
                    <h5>${task.title}</h5>
                    <p>${task.description}</p>
                    <div class="task-actions">
                        <button class="btn btn-warning btn-task" onclick="markAsInProgress(${index})">Iniciar</button>
                        <button class="btn btn-success btn-task" onclick="markAsCompleted(${index})">Concluir</button>
                        <button class="btn btn-secondary btn-task" onclick="editTask(${index})">Renomear</button>
                    </div>
                `;

                statusElements[task.status].appendChild(taskCard);
            });

            // Atualiza os contadores
            updateTaskCounts();
        }

        function markAsInProgress(index) {
            tasks[index].status = 'in-progress';
            renderTasks();
        }

        function markAsCompleted(index) {
            tasks[index].completed = true;
            tasks[index].status = 'completed';
            renderTasks();
        }

        function editTask(index) {
            currentTaskIndex = index;
            document.getElementById('task-title').value = tasks[index].title;
            document.getElementById('task-description').value = tasks[index].description;
            document.getElementById('task-status').value = tasks[index].status;

            const modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.show();
        }

        function deleteTask(index) {
            tasks.splice(index, 1);
            renderTasks();
        }

        function updateTaskCounts() {
            const counts = { 'to-do': 0, 'in-progress': 0, 'completed': 0 };
            tasks.forEach(task => counts[task.status]++);

            document.getElementById('todo-to-do-count').innerText = counts['to-do'];
            document.getElementById('todo-in-progress-count').innerText = counts['in-progress'];
            document.getElementById('todo-completed-count').innerText = counts['completed'];
        }
      
  </script>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/codigos.js"></script>
</body>
</html>