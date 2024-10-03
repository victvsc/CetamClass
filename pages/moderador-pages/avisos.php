<?php
session_start();
include('../../includes/db.php');

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
function exibirNomeUsuario() {
  return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
}
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
  <meta charset="UTF-8">
  <title>CetamClass - Aluno</title>
  <link rel="stylesheet" href="css/bootstrap.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
</head>
<style>
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
<body>
<!-- partial:index.partial.html -->
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
<div class="content">
<div class=" announcements">
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
      <!-- Adicione mais avisos aqui se necessário -->
  </div>
</div>
<!-- partial -->
<script type="text/javascript" src="js/bootstrap.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="js/codigos.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</body>
</html>