<?php
session_start();
include('../../../includes/db.php');

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
function exibirNomeUsuario() {
    return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
  }
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
  <meta charset="UTF-8">
  <title>CetamClass - Professor</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
      <style>
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
<!-- partial:index.partial.html -->
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
<div class="content">
<h1 class="text-center">Gerenciar Atividades</h1>

    <!-- Botão para adicionar uma nova atividade -->
    <div class="text-right mb-3">
        <button class="custom-btn" onclick="openActivityModal()">Adicionar Nova Atividade</button>
    </div>

    <!-- Tabela de atividades -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome da Atividade</th>
                <th>Data de Entrega</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="tabela-atividades">
            <!-- As atividades serão inseridas aqui via JavaScript -->
        </tbody>
    </table>
</div>

<!-- Modal para Adicionar/Editar Atividade -->
<div id="activityModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title">Adicionar Nova Atividade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeActivityModal()"></button>
            </div>
            <div class="modal-body">
                <form id="activityForm">
                    <div class="mb-3">
                        <label for="activityName" class="form-label">Nome da Atividade</label>
                        <input type="text" class="form-control" id="activityName" required>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Data de Entrega</label>
                        <input type="date" class="form-control" id="dueDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityStatus" class="form-label">Status</label>
                        <select class="form-select" id="activityStatus">
                            <option value="Concluída">Concluída</option>
                            <option value="Pendente">Pendente</option>
                        </select>
                    </div>
                    <input type="hidden" id="editingActivityId">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    let editingActivityId = null;

    function openActivityModal(activityId = null) {
        const modal = new bootstrap.Modal(document.getElementById('activityModal'));
        if (activityId) {
            // Editar atividade
            const activityRow = document.querySelector(`tr[data-id='${activityId}']`);
            document.getElementById('activityName').value = activityRow.cells[1].innerText;
            document.getElementById('dueDate').value = activityRow.cells[2].innerText;
            document.getElementById('activityStatus').value = activityRow.cells[3].innerText;
            document.getElementById('modalTitle').innerText = "Editar Atividade";
            editingActivityId = activityId;
        } else {
            // Adicionar nova atividade
            document.getElementById('activityForm').reset();
            document.getElementById('modalTitle').innerText = "Adicionar Nova Atividade";
            editingActivityId = null;
        }
        modal.show();
    }

    function closeActivityModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('activityModal'));
        modal.hide();
    }

    document.getElementById('activityForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        const activityName = document.getElementById('activityName').value;
        const dueDate = document.getElementById('dueDate').value;
        const status = document.getElementById('activityStatus').value;

        if (editingActivityId) {
            // Atualizar atividade existente
            const activityRow = document.querySelector(`tr[data-id='${editingActivityId}']`);
            activityRow.cells[1].innerText = activityName;
            activityRow.cells[2].innerText = dueDate;
            activityRow.cells[3].innerHTML = `<span class="badge bg-${status === 'Concluída' ? 'success' : 'warning'}">${status}</span>`;
        } else {
            // Adicionar nova atividade
            const newId = document.querySelectorAll('#tabela-atividades tr').length + 1;
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-id', newId);
            newRow.innerHTML = `
                <td>${newId}</td>
                <td>${activityName}</td>
                <td>${dueDate}</td>
                <td><span class="badge bg-${status === 'Concluída' ? 'success' : 'warning'}">${status}</span></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="openActivityModal(${newId})">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteActivity(${newId})">Excluir</button>
                </td>
            `;
            document.getElementById('tabela-atividades').appendChild(newRow);
        }

        closeActivityModal(); // Fecha o modal após a operação
    });

    function deleteActivity(id) {
        if (confirm("Tem certeza que deseja excluir a atividade " + id + "?")) {
            const activityRow = document.querySelector(`tr[data-id='${id}']`);
            if (activityRow) {
                activityRow.remove(); // Remove a linha da tabela
                alert("Atividade " + id + " excluída.");
            }
        }
    }
<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</html>
