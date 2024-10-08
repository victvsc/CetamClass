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
  <div class="announcement-section">
    <h2>Avisos</h2>
    <div class="row">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card">
          <img src="https://static.vecteezy.com/system/resources/previews/029/694/993/original/happy-family-icon-flat-style-mom-dad-and-child-of-parents-symbol-for-your-web-site-design-logo-app-ui-illustration-design-vector.jpg" class="card-img-top" alt="Imagem de Reunião">
          <div class="card-body">
            <h5 class="card-title">Reunião de pais</h5>
            <p class="card-text">Próxima quinta-feira às 19h.</p>
            <a href="#" class="btn btn-warning"><i class="fas fa-bell"></i> Detalhes</a>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card">
          <img src="https://cdn-icons-png.flaticon.com/512/588/588423.png" class="card-img-top" alt="Imagem de Prazos">
          <div class="card-body">
            <h5 class="card-title">Prazos</h5>
            <p class="card-text">Entrega de trabalhos até 15 de outubro.</p>
            <a href="#" class="btn btn-warning"><i class="fas fa-bell"></i> Detalhes</a>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card">
          <img src="https://cdn-icons-png.flaticon.com/512/2702/2702154.png" class="card-img-top" alt="Imagem de Novidades">
          <div class="card-body">
            <h5 class="card-title">Novidades</h5>
            <p class="card-text">Novas atividades foram adicionadas à biblioteca.</p>
            <a href="#" class="btn btn-warning"><i class="fas fa-bell"></i> Detalhes</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('nav-toggle').addEventListener('change', function() {
    const sidebar = document.getElementById('nav-bar');
    const content = document.querySelector('.content');

    if (this.checked) {
      sidebar.classList.add('closed');
      content.classList.add('closed');
    } else {
      sidebar.classList.remove('closed');
      content.classList.remove('closed');
    }
  });
</script>



<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</body>
</html>
