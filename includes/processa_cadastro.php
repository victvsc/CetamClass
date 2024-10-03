<?php
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabela = $_POST['tabela'];

    $query = "DESCRIBE $tabela";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $fields = [];
        $values = [];

        while ($row = $result->fetch_assoc()) {
            $field = $row['Field'];
            if (isset($_POST[$field])) {
                $fields[] = $field;
                $values[] = "'" . $conn->real_escape_string($_POST[$field]) . "'";
            }
        }

        $fields_str = implode(", ", $fields);
        $values_str = implode(", ", $values);

        $sql = "INSERT INTO $tabela ($fields_str) VALUES ($values_str)";

        if ($conn->query($sql) === TRUE) {
            echo "Dados cadastrados com sucesso na tabela $tabela!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "A tabela selecionada não possui atributos.";
    }

    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
echo "<button onclick='history.back()'>Voltar</button>";
?>
