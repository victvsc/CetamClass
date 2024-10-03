<?php
session_start();

// Verifica se o usuário está logado
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

// Aqui você pode adicionar o restante do código da página do painel do moderador
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Moderador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Bem-vindo ao Painel do Moderador</h1>
    <!-- O conteúdo da página vai aqui -->
</body>
</html>
