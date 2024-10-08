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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - CetamClass</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"rel="stylesheet">
    <link rel="stylesheet" href="../css/biblioteca.css">
</head>
<style>
      .custom-btn {
    border-radius: 0.375rem;
    border: 2px solid #1e90ff;
    /* Borda em azul claro */
    background-color: #1e90ff;
    /* Fundo em azul claro */
    color: white;
    /* Texto branco */
    transition: background-color 0.3s, color 0.3s;
    /* Transição suave para o hover */
}

.custom-btn:hover {
    background-color: #1c86ee;
    /* Fundo em azul um pouco mais escuro */
    border-color: #1c86ee;
    /* Borda em azul escuro */
    color: white;
    /* Texto branco */
}

/* Transição para o carrossel */
.carousel-container {
    transition: transform 0.5s ease; /* Suave transição */
    margin-left: 25%;
}

.carousel-container.shifted {
    transform: translateX(-250px); /* Move para a esquerda quando a sidebar estiver aberta */
}


</style>
<body>
    <!-- Navbar -->
    <div id="nav-bar">
  <input id="nav-toggle" type="checkbox"/>
  <div id="nav-header"><a id="nav-title" href="#" target="_blank">Cetam<i></i>Class</a>
    <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
    <hr/>
  </div>
  <div id="nav-content">
    <div class="nav-button"><i class="fas fa-home"></i><span><a href="./index.php">Home</a></span></div>
    <div class="nav-button"><i class="fas fa-book"></i><span><a href="./informacoesacad.php">Informações Acadêmcias</a></span></div>
    <div class="nav-button"><i class="fas fa-folder"></i><span><a href="./turvirt.php">Turma Virtual</a></span></div>
    <hr/>
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
    <div class="content-carousel">
    <!-- Carrossel -->
    <div class="carousel-container">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../../../img/biblioteca1.png" class="d-block w-100" alt="Imagem 1">
                </div>
                <div class="carousel-item">
                    <img src="../../../img/biblioteca2.png" class="d-block w-100" alt="Imagem 2">
                </div>
                <div class="carousel-item">
                    <img src="../../../img/biblioteca3.png" class="d-block w-100" alt="Imagem 3">
                </div>
            </div>
            <!-- Setas de navegação -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Próximo</span>
            </button>
        </div>
        <a href="https://www.baixelivros.com.br" target="_blank" class="access-button">Acessar</a>
    </div>

<!-- partial -->

<script>
    const navToggle = document.getElementById('nav-toggle');
    const carouselContainer = document.querySelector('.carousel-container');

    navToggle.addEventListener('change', () => {
        if (navToggle.checked) {
            carouselContainer.classList.add('shifted'); // Adiciona a classe para mover o carrossel
        } else {
            carouselContainer.classList.remove('shifted'); // Remove a classe quando a sidebar é fechada
        }
    });
</script>

<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</body>
</html>