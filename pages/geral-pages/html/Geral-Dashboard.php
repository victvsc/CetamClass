<?php
session_start();
include('../../../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$nivel = $_SESSION['nivel'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-header {
            padding: 20px;
            background-color: #343a40;
            color: white;
        }
        .dashboard-content {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="dashboard-header text-center">
    <h1>Bem-vindo ao Dashboard!</h1>
</div>

<div class="dashboard-content container mt-4">
    <h2 class="mb-4">Acesso Rápido</h2>
    <?php if ($nivel == 'Aluno'): ?>
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Olá Aluno!</h4>
            <p>Você pode acessar a sua <a href="../../aluno-pages/html/index.php" class="alert-link">Página do Aluno</a>.</p>
        </div>
    <?php elseif ($nivel == 'Professor'): ?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Olá Professor!</h4>
            <p>Você pode acessar a sua <a href="../../professor-pages/html/index.php" class="alert-link">Página do Professor</a>.</p>
        </div>
    <?php elseif ($nivel == 'Moderador'): ?>
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Olá Moderador!</h4>
            <p>Você pode acessar a sua <a href="../../moderador-pages/Home.php" class="alert-link">Página do Moderador</a>.</p>
        </div>
    <?php endif; ?>
    <a href="../../../includes/logout.php" class="btn btn-danger">Logout</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
