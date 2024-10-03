<?php
session_start();
include('../../../includes/db.php');

// Lógica de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta SQL
    $sql = "
        (SELECT u.id_usuario, u.nivel, a.nome, a.matricula, NULL as id_professor FROM usuario u 
         INNER JOIN aluno a ON u.id_usuario = a.id_usuario 
         WHERE a.email = ? AND a.senha = ?)
        UNION
        (SELECT u.id_usuario, u.nivel, p.nome, NULL as matricula, p.id_professor FROM usuario u 
         INNER JOIN professor p ON u.id_usuario = p.id_usuario 
         WHERE p.email = ? AND p.senha = ?)
        UNION
        (SELECT u.id_usuario, u.nivel, m.nome, NULL as matricula, NULL as id_professor FROM usuario u 
         INNER JOIN moderador m ON u.id_usuario = m.id_usuario 
         WHERE m.email = ? AND m.senha = ?)
    ";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $email, $senha, $email, $senha, $email, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id_usuario'];
            $_SESSION['nivel'] = $row['nivel'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['matricula'] = $row['matricula'] ?? null;
            $_SESSION['id_professor'] = $row['id_professor'] ?? null;

            // Após login bem-sucedido, redireciona para a página de destino
            header("Location: Geral-Dashboard.php");
            exit();
        } else {
            $error = "Login falhou. Verifique suas credenciais.";
        }
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('../../../img/fundo.png'); /* Altere para o caminho da sua imagem */
            background-size: cover;
            background-position: center;
            filter: brightness(0.8); /* Para escurecer a imagem, se necessário */
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8); /* Fundo branco com opacidade */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .text-danger {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2 class="text-center">Bem-vindo ao CetamClass</h2>
    
    <form method="POST" action="">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="senha" placeholder="Digite sua senha" required>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='text-danger'>$error</p>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
