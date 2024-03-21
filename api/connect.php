<?php
// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos foram enviados
    if (isset($_POST['instituicao'], $_POST['nome'], $_POST['cpf'], $_POST['celular'], $_POST['nascimento'])) {
        // Captura os dados do formulário
        $instituicao = $_POST['instituicao'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $celular = $_POST['celular'];
        $nascimento = $_POST['nascimento'];

        // Configurações de conexão com o banco de dados
        $servername = "localhost"; // endereço do servidor
        $username = "root"; // nome de usuário do banco de dados
        $password = "root"; // senha do banco de dados
        $dbname = "routeform"; // nome do banco de dados

        // Cria a conexão
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se houve algum erro na conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Prepara a declaração SQL para inserção de dados
        $sql = "INSERT INTO routeform (instituicao, nome, cpf, celular, nascimento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Verifica se a preparação da declaração foi bem-sucedida
        if ($stmt === false) {
            die("Preparação da declaração falhou: " . $conn->error);
        }

        // Associa os parâmetros à declaração preparada
        $stmt->bind_param("sssss", $instituicao, $nome, $cpf, $celular, $nascimento);

        // Executa a declaração
        if ($stmt->execute()) {
            echo "Registro inserido com sucesso";
        } else {
            echo "Erro ao inserir o registro: " . $stmt->error;
        }

        // Fecha a declaração e a conexão
        $stmt->close();
        $conn->close();
    } else {
        echo "Todos os campos do formulário devem ser preenchidos";
    }
} else {
    echo "Este script deve ser acessado por meio de uma solicitação POST";
}
?>
