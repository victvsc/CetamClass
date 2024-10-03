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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CetamClass - Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
            background-color: #f8f9fa; /* Cor de fundo */
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Escurecimento do fundo */
            z-index: 1040; /* Abaixo do carrossel */
            display: none; /* Inicialmente oculto */
        }

        .carousel-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050; /* Para garantir que fique acima de outros elementos */
            width: 400px; /* Diminuir ainda mais a largura do carrossel */
        }

        .custom-badge {
            background-color: #0052c5;
        }

        .custom-btn {
            border-radius: 0.375rem;
            border: 2px solid #1e90ff; /* Borda em azul claro */
            background-color: #1e90ff; /* Fundo em azul claro */
            color: white; /* Texto branco */
            transition: background-color 0.3s, color 0.3s; /* Transição suave para o hover */
        }

        .custom-btn:hover {
            background-color: #1c86ee; /* Fundo em azul um pouco mais escuro */
            border-color: #1c86ee; /* Borda em azul escuro */
            color: white; /* Texto branco */
        }

        .close-btn {
            position: absolute;
            top: -20px; /* Ajuste para ficar acima do carrossel */
            right: -20px; /* Ajuste para ficar fora do carrossel */
            background: none;
            border: none;
            font-size: 1.5rem;
            color: white; /* Cor do botão de fechar */
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="overlay" id="overlay"></div>
<div class="carousel-container" id="alertCarousel">
    <button class="close-btn" id="closeButton">&times;</button>
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../../../img/img1.jpeg" class="d-block w-100" alt="Imagem 1">
            </div>
            <div class="carousel-item">
                <img src="../../../img/img2.jpeg" class="d-block w-100" alt="Imagem 2">
            </div>
            <div class="carousel-item">
                <img src="../../../img/img3.jpeg" class="d-block w-100" alt="Imagem 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
</div>

<!-- Navbar -->
<div id="nav-bar">
    <input id="nav-toggle" type="checkbox"/>
    <div id="nav-header"><a id="nav-title" href="./index.php">Cetam<i></i>Class</a>
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
            <div id="nav-footer-titlebox"><a id="nav-footer-title" href="#"><?php echo exibirNomeUsuario(); ?></a><span id="nav-footer-subtitle">Aluno</span></div>
            <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
        </div>
        <div id="nav-footer-content">
            <button class="custom-btn" id="logoutButton">Sair</button>
        </div>
    </div>
</div>

<!-- Conteúdo Principal -->
<div class="content">
    <h1><strong>Olá, <?php echo exibirNomeUsuario(); ?>! <span class="badge badge-pill custom-badge" style="color: white;font-size: 15px;">Bem-vindo(a) ao CetamClass</span></strong></h1>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Mostrar o carrossel e o fundo escurecido
    document.getElementById('alertCarousel').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';

    document.getElementById('logoutButton').addEventListener('click', function() {
        document.getElementById('alertCarousel').style.display = 'block'; // Mostra o carrossel
        document.getElementById('overlay').style.display = 'block'; // Mostra o fundo escurecido
    });

    // Fechar o carrossel
    document.getElementById('closeButton').addEventListener('click', function() {
        document.getElementById('alertCarousel').style.display = 'none'; // Esconde o carrossel
        document.getElementById('overlay').style.display = 'none'; // Esconde o fundo escurecido
    });
</script>
</body>
</html>