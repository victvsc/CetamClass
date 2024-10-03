<?php
session_start();
include('../../../includes/db.php');

if (isset($_SESSION['user_id'])) {
  // Verifica se o id_usuario é igual a 3 (moderador)
  if ($_SESSION['user_id'] != 1) {
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
  <title>Avisos - Aluno</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
</head>
<style>
<style>
  body {
    font-family: 'Josefin Sans', sans-serif;
  }

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

  /* Seção de Avisos */
  .announcement-section {
    padding: 20px;
    background-color: #f8f9fa; /* Cor de fundo leve */
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
  }

  .announcement {
    background-color: rgba(255, 193, 24, 0.7);
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
  }

  .announcement i {
    font-size: 24px;
    margin-right: 10px;
  }
</style>

  </style>
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
      <div id="nav-footer-titlebox"><a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank"><?php echo exibirNomeUsuario($conn); ?></a><span id="nav-footer-subtitle">Aluno</span></div>
      <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
    </div>
    <div id="nav-footer-content">
        <button class="custom-btn" onclick="window.location.href='../../../includes/logout.php'">Sair</button>
    </div>
  </div>
</div>
<!-- partial -->
<div class="content">
  <div class="announcement-section">
    <h2>Avisos</h2>
    <div class="announcement-container">
      <div class="announcement">
        <i class="fas fa-bell"></i>
        <strong>Reunião de pais:</strong> próxima quinta-feira às 19h.
      </div>
      <div class="announcement">
        <i class="fas fa-bell"></i>
        <strong>Prazos:</strong> Entrega de trabalhos até 15 de outubro.
      </div>
      <div class="announcement">
        <i class="fas fa-bell"></i>
        <strong>Novidades:</strong> Novas atividades foram adicionadas à biblioteca.
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</body>
</html>