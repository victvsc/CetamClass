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
<h1 class="text-center">Gerenciamento de Materiais</h1>

    <!-- Botão para adicionar um novo material -->
    <div class="text-right mb-3">
        <button class="custom-btn" onclick="openModal()">Adicionar Novo Material</button>
    </div>

<!-- Tabela de materiais -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome do Material</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="material-table-body">
        <tr data-id="1">
            <td>1</td>
            <td class="material-name">Notebook</td>
            <td class="material-quantity">10</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="openModal(1)">Editar</button>
                <button class="btn btn-danger btn-sm" onclick="deleteMaterial(1)">Excluir</button>
            </td>
        </tr>
        <tr data-id="2">
            <td>2</td>
            <td class="material-name">Teclado</td>
            <td class="material-quantity">25</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="openModal(2)">Editar</button>
                <button class="btn btn-danger btn-sm" onclick="deleteMaterial(2)">Excluir</button>
            </td>
        </tr>
        <!-- Mais materiais -->
    </tbody>
</table>


<!-- Modal para adicionar/editar material -->
<div id="materialModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Adicionar Material</h2>
        <form id="materialForm">
            <input type="text" id="materialName" placeholder="Nome do Material" required class="input-field"><br>
            <input type="number" id="materialQuantity" placeholder="Quantidade" required class="input-field"><br>
            <button type="submit" class="submit">Salvar</button>
        </form>
    </div>
</div>

<div class="upload-section">
    <h2>Upload de Arquivos</h2>
    <p>Adicione seus arquivos (PDF, DOCX, etc.) relacionados aos materiais aqui:</p>
    <input type="file" id="file-upload" class="file-upload" accept=".pdf,.docx,.txt" />
    <button class="submit">Enviar</button>
</div>

    <script>
        // Função para abrir o modal
        function openModal() {
            document.getElementById("materialModal").style.display = "flex";
            document.getElementById("modalTitle").innerText = "Adicionar Material";
        }

        // Função para fechar o modal
        function closeModal() {
            document.getElementById("materialModal").style.display = "none";
        }

        // Função para editar material
        function editMaterial(id) {
            document.getElementById("materialModal").style.display = "flex";
            document.getElementById("modalTitle").innerText = "Editar Material";
            // Lógica para preencher os campos com os dados do material existente
        }

        // Função para deletar material
        function deleteMaterial(id) {
            if (confirm("Tem certeza que deseja excluir este material?")) {
                // Lógica para deletar o material
            }
        }

        // Fechar o modal ao clicar fora dele
        window.onclick = function(event) {
            var modal = document.getElementById("materialModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

// Variável global para armazenar o ID do material que está sendo editado
let editingMaterialId = null;

// Função para abrir o modal de edição
function openModal(materialId) {
    const modal = document.getElementById("materialModal");
    const modalTitle = document.getElementById("modalTitle");

    if (materialId) {
        // Editar material
        const materialRow = document.querySelector(`tr[data-id='${materialId}']`);
        const materialName = materialRow.querySelector('.material-name').innerText;
        const materialQuantity = materialRow.querySelector('.material-quantity').innerText;

        document.getElementById("materialName").value = materialName;
        document.getElementById("materialQuantity").value = materialQuantity;

        modalTitle.innerText = "Editar Material";
        editingMaterialId = materialId; // Define o ID do material que está sendo editado
    } else {
        // Adicionar novo material
        document.getElementById("materialForm").reset();
        modalTitle.innerText = "Adicionar Material";
        editingMaterialId = null; // Limpa o ID do material
    }

    modal.style.display = "flex"; // Exibe o modal
}

// Função para fechar o modal
function closeModal() {
    document.getElementById("materialModal").style.display = "none"; // Esconde o modal
}

// Função para adicionar ou editar material
document.getElementById("materialForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita o envio do formulário

    const materialName = document.getElementById("materialName").value;
    const materialQuantity = document.getElementById("materialQuantity").value;

    if (editingMaterialId) {
        // Atualizar material existente
        const materialRow = document.querySelector(`tr[data-id='${editingMaterialId}']`);
        materialRow.querySelector('.material-name').innerText = materialName;
        materialRow.querySelector('.material-quantity').innerText = materialQuantity;
    } else {
        // Adicionar novo material
        const newRow = document.createElement("tr");
        newRow.setAttribute("data-id", Date.now()); // Usando timestamp como ID único
        newRow.innerHTML = `
            <td>${newRow.getAttribute("data-id")}</td>
            <td class="material-name">${materialName}</td>
            <td class="material-quantity">${materialQuantity}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="openModal(${newRow.getAttribute("data-id")})">Editar</button>
                <button class="btn btn-danger btn-sm" onclick="deleteMaterial(${newRow.getAttribute("data-id")})">Excluir</button>
            </td>
        `;
        document.getElementById("material-table-body").appendChild(newRow);
    }

    closeModal(); // Fecha o modal após a operação
});

// Função para excluir material
function deleteMaterial(materialId) {
    const materialRow = document.querySelector(`tr[data-id='${materialId}']`);
    if (materialRow) {
        materialRow.remove(); // Remove a linha da tabela
    }
}

    </script>

<!-- partial -->
<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</html>
