<?php
require_once '../../infra/conexao.php';

$cliente_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$cliente_id) {
    header('Location: listar_clientes.php');
    exit;
}

try {
    $stmtCliente = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmtCliente->execute([':id' => $cliente_id]);
    $cliente = $stmtCliente->fetch();

    if (!$cliente) {
        header('Location: listar_clientes.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados do cliente: " . $e->getMessage());
}

try {
    $stmtAnimais = $pdo->prepare("SELECT * FROM animais WHERE cliente_id = :cliente_id ORDER BY nome ASC");
    $stmtAnimais->execute([':cliente_id' => $cliente_id]);
    $animais = $stmtAnimais->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar animais do cliente: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Cliente - AUmigos</title>
</head>
<body>
    <h1>Detalhes do Cliente</h1>
    
    <p><strong>Cliente:</strong> <?= htmlspecialchars($cliente['nome']) ?></p>
    <p><strong>E-mail:</strong> <?= htmlspecialchars($cliente['email'] ?: 'Não informado') ?></p>
    <p><strong>Telefone:</strong> <?= htmlspecialchars($cliente['telefone'] ?: 'Não informado') ?></p>

    <hr>

    <h2>Animais Cadastrados</h2>

    <?php if (count($animais) > 0): ?>
        <ul>
            <?php foreach ($animais as $animal): ?>
                <li>
                    <strong><?= htmlspecialchars($animal['nome']) ?></strong> — 
                    <?= htmlspecialchars($animal['especie']) ?> — 
                    <?= htmlspecialchars($animal['raca'] ?: 'S/R') ?> — 
                    <?= htmlspecialchars($animal['idade'] ? $animal['idade'] . ' anos' : 'Idade não informada') ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Este cliente ainda não possui nenhum animal cadastrado.</p>
    <?php endif; ?>

    <br>
    <a href="../animais/cadastrar_animal.php?cliente_id=<?= $cliente['id'] ?>">+ Adicionar Animal para este Cliente</a> | 
    <a href="editar_cliente.php?id=<?= $cliente['id'] ?>">Editar Cliente</a> | 
    <a href="listar_clientes.php">Voltar para a Lista</a>
</body>
</html>