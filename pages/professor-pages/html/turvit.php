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
  <title>Turma Virtual - Aluno</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/turvirt.css">
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
    <div class="nav-button"><i class="fas fa-book"></i><span><a href="./turvit.php">Turma Virtual</a></span></div>
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
  </div>
</div>
<div class="content">
<h1 class="text-center">Turma Virtual</h1>

<!-- Dashboard -->
<div class="dashboard">
    <div class="card">
        <h5>Informações da Turma</h5>
        <p>Aqui você pode encontrar informações relevantes sobre a turma.</p>
    </div>
    <div class="card">
        <h5>Atividades Recentes</h5>
        <p>Veja as atividades mais recentes que foram adicionadas.</p>
    </div>
    <div class="card">
        <h5>Recursos Adicionais</h5>
        <p>Links e materiais úteis para sua turma.</p>
    </div>
    <div class="card">
        <h5>Link para a Turma Virtual</h5>
        <p>Acesse sua turma virtual através do link abaixo:</p>
        <a href="https://classroom.google.com/c/NTgwMDEyODM1MTM4" target="_blank" class="btn-virtual">Entrar na Turma Virtual</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</html>
