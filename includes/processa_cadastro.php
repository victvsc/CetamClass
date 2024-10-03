<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os campos estão definidos
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $data_nasc = isset($_POST['data_nasc']) ? $_POST['data_nasc'] : null;
    $id_turma = isset($_POST['id_turma']) ? $_POST['id_turma'] : null;

    // Verifica se todos os campos necessários estão preenchidos
    if ($nome && $sobrenome && $email && $senha && $cpf && $data_nasc && $id_turma) {
        // Escapar dados para evitar injeção SQL
        $nome = $conn->real_escape_string($nome);
        $sobrenome = $conn->real_escape_string($sobrenome);
        $email = $conn->real_escape_string($email);
        $senha = $conn->real_escape_string($senha);
        $cpf = $conn->real_escape_string($cpf);
        $data_nasc = $conn->real_escape_string($data_nasc);
        $id_turma = (int)$id_turma; // Garantir que id_turma é um número inteiro

        // Montar a query de inserção
        $sql = "INSERT INTO aluno (nome, sobrenome, email, senha, cpf, data_nasc, id_turma) 
                VALUES ('$nome', '$sobrenome', '$email', '$senha', '$cpf', '$data_nasc', $id_turma)";

        // Executar a query
        if ($conn->query($sql) === TRUE) {
            echo "Aluno cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar aluno: " . $conn->error;
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios.";
    }

    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
echo "<button onclick='history.back()'>Voltar</button>";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
</head>
<body>
    <h1>Cadastro de Aluno</h1>
    <form action="processa_cadastro.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="sobrenome">Sobrenome:</label>
        <input type="text" name="sobrenome" id="sobrenome" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" required>

        <label for="data_nasc">Data de Nascimento:</label>
        <input type="date" name="data_nasc" id="data_nasc" required>

        <label for="id_turma">ID da Turma:</label>
        <input type="number" name="id_turma" id="id_turma" required>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
