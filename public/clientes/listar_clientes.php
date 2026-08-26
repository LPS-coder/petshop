<?php
require_once '../../infra/conexao.php';

try {
    $stmt = $pdo->query("SELECT * FROM clientes ORDER BY nome ASC");
    $clientes = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar clientes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes - AUmigos</title>
</head>
<body>
    <h1>Clientes Cadastrados</h1>

    <?php if (isset($_GET['sucesso'])): ?>
        <p style="color: green;">Operação realizada com sucesso!</p>
    <?php endif; ?>

    <a href="cadastrar_cliente.php">+ Novo Cliente</a> | 
    <a href="../animais/listar_animais.php">Gerenciar Animais</a> | 
    <a href="../index.php">Início</a>

    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($clientes) > 0): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['id']) ?></td>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                        <td>
                            <a href="detalhes_cliente.php?id=<?= $cliente['id'] ?>">Ver Detalhes</a> |
                            <a href="editar_cliente.php?id=<?= $cliente['id'] ?>">Editar</a> |
                            <a href="excluir_cliente.php?id=<?= $cliente['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este cliente? Todos os seus pets também serão excluídos!');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum cliente cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>