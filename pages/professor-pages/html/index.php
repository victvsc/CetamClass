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
        .custom-badge{
            background-color:#228B22;
        }
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
      <h1><strong>Olá, <?php echo exibirNomeUsuario($conn); ?> ! <span class="badge badge-pill custom-badge" style="color: white;font-size:small;vertical-align: middle;">Professor</span></strong></h1>
  <p>Esta é a sua página inicial, onde você pode acessar todas as funcionalidades do portal.</p>
  <div class="resources-section">
    <h2>Recursos Úteis</h2>
    <div class="resource-grid">
      <div class="resource-block">
        <h3>Gerenciar Atividades</h3>
        <p>Organize e acompanhe suas atividades facilmente.</p>
        <p>Com esta ferramenta, você pode criar, editar e remover tarefas, definir prazos e priorizar suas responsabilidades. Receba lembretes para não perder nenhuma data importante.</p>
      </div>
      <div class="resource-block">
        <h3>Gerenciar Materiais</h3>
        <p>Administre todos os seus materiais de forma eficiente.</p>
        <p>Acesse uma lista completa de materiais didáticos, faça upload de novos arquivos e categorize-os conforme suas necessidades. Mantenha tudo organizado para facilitar a consulta.</p>
      </div>
      <div class="resource-block">
        <h3>Acessar Diário</h3>
        <p>Veja suas anotações e compromissos em um só lugar.</p>
        <p>Registre suas ideias, anotações de aula e compromissos importantes. O diário permite que você busque por datas específicas e visualize seu histórico de atividades.</p>
      </div>
      <div class="resource-block">
        <h3>Biblioteca</h3>
        <p>Acesse todos os recursos de leitura disponíveis.</p>
        <p>Explore uma ampla gama de livros, artigos e materiais de estudo. Filtre por categoria e aproveite sugestões personalizadas de leitura com base em suas preferências.</p>
      </div>
    </div>
  </div>
  

  <div class="announcement-section">
    <h2>Avisos</h2>
    <div class="announcement">
      <i class="fas fa-bell"></i>
      <p>Não esqueça do prazo para entrega do projeto até sexta-feira!</p>
    </div>
    <div class="announcement">
      <i class="fas fa-info-circle"></i>
      <p>As aulas serão remarcadas devido ao feriado nacional.</p>
    </div>
  </div>
</div>

  
<!-- partial -->

<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>
</body>
</html>
