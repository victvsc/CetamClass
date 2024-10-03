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
    <div class="nav-button"><i class="fas fa-question-circle"></i><span><a href="./ajuda.php">Ajuda</a></span></div>
    <div id="nav-content-highlight"></div>
  </div>
  <input id="nav-footer-toggle" type="checkbox"/>
  <div id="nav-footer">
    <div id="nav-footer-heading">
      <div id="nav-footer-avatar"><img src="https://gravatar.com/avatar/4474ca42d303761c2901fa819c4f2547"/></div>
      <div id="nav-footer-titlebox"><a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank">Usuário</a><span id="nav-footer-subtitle">Admin</span></div>
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
  <!-- Seção de FAQ -->
<div class="container mt-4">
  <h2 class="text-center">Perguntas Frequentes (FAQ) para Professores</h2>
  <div id="faqAccordion">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            Como posso lançar notas no sistema?
          </button>
        </h5>
      </div>
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#faqAccordion">
        <div class="card-body">
          Você pode lançar notas acessando a seção "Diário" no menu principal.
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header" id="headingTwo">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Onde encontro o calendário acadêmico?
          </button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
        <div class="card-body">
          O calendário acadêmico pode ser encontrado na seção "Avisos" ou na sua página de "Informações Acadêmicas".
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header" id="headingThree">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Como posso acessar materiais didáticos?
          </button>
        </h5>
      </div>
      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
        <div class="card-body">
          Os materiais didáticos estão disponíveis na seção "Materiais Didáticos" do menu.
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header" id="headingFour">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
            Como posso mudar minha senha?
          </button>
        </h5>
      </div>
      <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
        <div class="card-body">
          Para mudar sua senha, vá até as configurações de perfil na sua conta.
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header" id="headingFive">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
            Como posso entrar em contato com o suporte?
          </button>
        </h5>
      </div>
      <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqAccordion">
        <div class="card-body">
          Você pode entrar em contato com o suporte através da seção "Contato" no menu.
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header" id="headingSix">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
            Onde posso encontrar informações sobre bolsas de estudo?
          </button>
        </h5>
      </div>
      <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#faqAccordion">
        <div class="card-body">
          Informações sobre bolsas de estudo estão disponíveis na seção de "Avisos" ou no portal do aluno.
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</html>
