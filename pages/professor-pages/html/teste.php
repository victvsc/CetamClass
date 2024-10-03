<?php
session_start();
include('../../../includes/db.php'); // Inclui a conexão com o banco de dados

if (isset($_SESSION['user_id'])) {
    // Verifica se o id_usuario é igual a 2 (moderador)
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

// Busca a lista de alunos da turma do professor
$id_professor = $_SESSION['user_id']; // A partir da sessão, usando user_id
$query = "
    SELECT a.matricula, a.nome 
    FROM aluno a
    JOIN turma t ON a.id_turma = t.id_turma
    JOIN comptur ct ON ct.id_turma = t.id_turma
    JOIN componente c ON ct.id_componente = c.id_componente
    WHERE c.id_professor = ?
";

$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$alunos = $result->fetch_all(MYSQLI_ASSOC);

// Processa o formulário de registro de notas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($alunos as $aluno) {
        $matricula = $aluno['matricula'];
        $n1 = $_POST["n1_$matricula"];
        $n2 = $_POST["n2_$matricula"];
        $n3 = $_POST["n3_$matricula"];
        $frequencia = $_POST["frequencia_$matricula"];

        // Aqui você deve fazer a inserção ou atualização no banco de dados
        $media = ($n1 + $n2 + $n3) / 3; // Calcula a média
        $insertQuery = "INSERT INTO boletim (matricula, n1, n2, n3, media, frequencia) VALUES (?, ?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE n1 = ?, n2 = ?, n3 = ?, media = ?, frequencia = ?";
        $insertStmt = $conn->prepare($insertQuery);

        if (!$insertStmt) {
            die("Erro na preparação da consulta de inserção: " . $conn->error);
        }

        $insertStmt->bind_param("idddiiidddi", $matricula, $n1, $n2, $n3, $media, $frequencia, $n1, $n2, $n3, $media, $frequencia);
        $insertStmt->execute();
    }
    echo "<p>Notas e frequência registradas com sucesso!</p>";
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar Notas e Frequência</title>
    <link rel="stylesheet" href="../../styles.css"> <!-- Link para o CSS -->
</head>
<body>
    <header>
        <h1>Registrar Notas e Frequência</h1>
        <p>Bem-vindo, <?php echo exibirNomeUsuario(); ?>!</p>
    </header>
    <main>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota 3</th>
                        <th>Frequência (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo $aluno['matricula']; ?></td>
                            <td><?php echo $aluno['nome']; ?></td>
                            <td><input type="number" step="0.01" name="n1_<?php echo $aluno['matricula']; ?>" required></td>
                            <td><input type="number" step="0.01" name="n2_<?php echo $aluno['matricula']; ?>" required></td>
                            <td><input type="number" step="0.01" name="n3_<?php echo $aluno['matricula']; ?>" required></td>
                            <td><input type="number" name="frequencia_<?php echo $aluno['matricula']; ?>" required></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Registrar</button>
        </form>
    </main>
</body>
</html>
