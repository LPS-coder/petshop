<?php
require_once '../../infra/conexao.php';

$mensagem = '';
$animal_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$animal_id) {
    header('Location: listar_animais.php');
    exit;
}

try {
    $stmtClientes = $pdo->query("SELECT id, nome FROM clientes ORDER BY nome ASC");
    $clientes = $stmtClientes->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar clientes: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_VALIDATE_INT);
    $nome = trim($_POST['nome']);
    $especie = trim($_POST['especie']);
    $raca = trim($_POST['raca']);
    $idade = filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT);

    if ($cliente_id && !empty($nome) && !empty($especie)) {
        try {
            $sql = "UPDATE animais SET cliente_id = :cliente_id, nome = :nome, especie = :especie, raca = :raca, idade = :idade WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':nome' => $nome,
                ':especie' => $especie,
                ':raca' => $raca,
                ':idade' => $idade !== false ? $idade : null,
                ':id' => $animal_id
            ]);

            header('Location: listar_animais.php?sucesso=1');
            exit;
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar animal: " . $e->getMessage();
        }
    } else {
        $mensagem = "Selecione o responsável, nome e espécie do animal!";
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM animais WHERE id = :id");
    $stmt->execute([':id' => $animal_id]);
    $animal = $stmt->fetch();

    if (!$animal) {
        header('Location: listar_animais.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados do animal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Animal - AUmigos</title>
</head>
<body>
    <h1>Editar Animal</h1>

    <?php if ($mensagem): ?>
        <p style="color: red;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label for="cliente_id">Responsável *:</label><br>
            <select id="cliente_id" name="cliente_id" required>
                <option value="">-- Selecione o Responsável --</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($animal['cliente_id'] == $c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div>
            <label for="nome">Nome do Pet *:</label><br>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($animal['nome']) ?>" required>
        </div>
        <br>
        <div>
            <label for="especie">Espécie *:</label><br>
            <input type="text" id="especie" name="especie" value="<?= htmlspecialchars($animal['especie']) ?>" required>
        </div>
        <br>
        <div>
            <label for="raca">Raça:</label><br>
            <input type="text" id="raca" name="raca" value="<?= htmlspecialchars($animal['raca']) ?>">
        </div>
        <br>
        <div>
            <label for="idade">Idade (anos):</label><br>
            <input type="number" id="idade" name="idade" min="0" value="<?= htmlspecialchars($animal['idade']) ?>">
        </div>
        <br>
        <button type="submit">Atualizar Animal</button>
        <a href="listar_animais.php">Cancelar</a>
    </form>
</body>
</html>