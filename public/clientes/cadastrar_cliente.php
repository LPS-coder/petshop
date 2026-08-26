<?php
require_once '../../infra/conexao.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);

    if (!empty($nome)) {
        try {
            $sql = "INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':telefone' => $telefone
            ]);

            header('Location: listar_clientes.php?sucesso=1');
            exit;
        } catch (PDOException $e) {
            $mensagem = "Erro ao cadastrar cliente: " . $e->getMessage();
        }
    } else {
        $mensagem = "O campo Nome é obrigatório!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Cliente - AUmigos</title>
</head>
<body>
    <h1>Cadastrar Novo Cliente</h1>

    <?php if ($mensagem): ?>
        <p style="color: red;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label for="nome">Nome *:</label><br>
            <input type="text" id="nome" name="nome" required>
        </div>
        <br>
        <div>
            <label for="email">E-mail:</label><br>
            <input type="email" id="email" name="email">
        </div>
        <br>
        <div>
            <label for="telefone">Telefone:</label><br>
            <input type="text" id="telefone" name="telefone">
        </div>
        <br>
        <button type="submit">Salvar Cliente</button>
        <a href="listar_clientes.php">Voltar</a>
    </form>
</body>
</html>
