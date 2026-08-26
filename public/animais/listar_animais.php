<?php
require_once '../../infra/conexao.php';

try {
    $sql = "SELECT a.*, c.nome AS nome_responsavel 
            FROM animais a 
            INNER JOIN clientes c ON a.cliente_id = c.id 
            ORDER BY a.nome ASC";
    $stmt = $pdo->query($sql);
    $animais = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar animais: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Animais - AUmigos</title>
</head>
<body>
    <h1>Animais Cadastrados</h1>

    <?php if (isset($_GET['sucesso'])): ?>
        <p style="color: green;">Operação realizada com sucesso!</p>
    <?php endif; ?>

    <a href="cadastrar_animal.php">+ Novo Animal</a> | 
    <a href="../clientes/listar_clientes.php">Gerenciar Clientes</a> | 
    <a href="../index.php">Início</a>

    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Pet</th>
                <th>Espécie</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Responsável</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($animais) > 0): ?>
                <?php foreach ($animais as $animal): ?>
                    <tr>
                        <td><?= htmlspecialchars($animal['id']) ?></td>
                        <td><?= htmlspecialchars($animal['nome']) ?></td>
                        <td><?= htmlspecialchars($animal['especie']) ?></td>
                        <td><?= htmlspecialchars($animal['raca'] ?: '-') ?></td>
                        <td><?= htmlspecialchars($animal['idade'] !== null ? $animal['idade'] . ' anos' : '-') ?></td>
                        <td>
                            <a href="../clientes/detalhes_cliente.php?id=<?= $animal['cliente_id'] ?>">
                                <?= htmlspecialchars($animal['nome_responsavel']) ?>
                            </a>
                        </td>
                        <td>
                            <a href="editar_animal.php?id=<?= $animal['id'] ?>">Editar</a> |
                            <a href="excluir_animal.php?id=<?= $animal['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este animal?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum animal cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>