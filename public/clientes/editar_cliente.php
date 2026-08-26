<?php
require_once '../../infra/conexao.php';

$mensagem = '';
$cliente_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$cliente_id) {
    header('Location: listar_clientes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);

    if (!empty($nome)) {
        try {
            $sql = "UPDATE clientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':telefone' => $telefone,
                ':id' => $cliente_id
            ]);

            header('Location: listar_clientes.php?sucesso=1');
            exit;
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar cliente: " . $e->getMessage();
        }
    } else {
        $mensagem = "O campo Nome é obrigatório!";
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->execute([':id' => $cliente_id]);
    $cliente = $stmt->fetch();

    if (!$cliente) {
        header('Location: listar_clientes.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados do cliente: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente - AUmigos</title>
</head>
<body>
    <h1>Editar Cliente</h1>

    <?php if ($mensagem): ?>
        <p style="color: red;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label for="nome">Nome *:</label><br>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
        </div>
        <br>
        <div>
            <label for="email">E-mail:</label><br>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>">
        </div>
        <br>
        <div>
            <label for="telefone">Telefone:</label><br>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">
        </div>
        <br>
        <button type="submit">Atualizar Cliente</button>
        <a href="listar_clientes.php">Cancelar</a>
    </form>
</body>
</html>