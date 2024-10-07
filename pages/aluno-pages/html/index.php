<?php
session_start();
include('../../../includes/db.php');

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_id'] != 1) {
        header("Location: ../../geral-pages/html/Login.php");
        exit();
    }
} else {
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
    <title>Home - Aluno</title>
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

.container {
    transition: transform 0.3s ease; /* Transição suave para transform */
}

.container.shifted {
    transform: translateX(-250px); /* Ajuste conforme a largura da sua navbar */
}

</style>
<body>

<!-- Navbar -->
<div id="nav-bar">
  <input id="nav-toggle" type="checkbox"/>
  <div id="nav-header"><a id="nav-title" href="https://codepen.io" target="_blank">Cetam<i></i>Class</a>
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

<!-- Conteúdo Principal -->
<div class="container mt-4" id="main-content">
    <h1>Bem-vindo, <?php echo exibirNomeUsuario(); ?>!</h1>
    <div class="row">
        <!-- Avisos -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-header">
                    <h5>Avisos Importantes</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Não se esqueça da reunião na próxima terça-feira às 14h.</li>
                        <li>Os resultados das provas já estão disponíveis.</li>
                        <li>O prazo para entrega de trabalhos é na próxima sexta-feira.</li>
                    </ul>
                </div>
            </div>
        </div>
        
    <!-- Acesso Rápido -->
    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header">
                    <h5>Acesso Rápido</h5>
                </div>
                <div class="card-body">
                    <a class="btn btn-primary" href="./turvirt.php">Acessar Turma Virtual</a>
                    <a class="btn btn-secondary" href="./biblioteca.php">Visitar Biblioteca</a>
                    <a class="btn btn-success" href="./matrizcur.php">Ver Matriz Curricular</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const navToggle = document.getElementById('nav-toggle');
    const mainContent = document.getElementById('main-content');

    navToggle.addEventListener('change', () => {
        if (navToggle.checked) {
            mainContent.classList.add('shifted');
        } else {
            mainContent.classList.remove('shifted');
        }
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
