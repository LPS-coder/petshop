<?php
require_once '../../infra/conexao.php';

$mensagem = '';
$cliente_id_selecionado = filter_input(INPUT_GET, 'cliente_id', FILTER_VALIDATE_INT);

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
            $sql = "INSERT INTO animais (cliente_id, nome, especie, raca, idade) 
                    VALUES (:cliente_id, :nome, :especie, :raca, :idade)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':nome' => $nome,
                ':especie' => $especie,
                ':raca' => $raca,
                ':idade' => $idade !== false ? $idade : null
            ]);

            header('Location: listar_animais.php?sucesso=1');
            exit;
        } catch (PDOException $e) {
            $mensagem = "Erro ao cadastrar animal: " . $e->getMessage();
        }
    } else {
        $mensagem = "Selecione o responsável, nome e espécie do animal!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Animal - AUmigos</title>
</head>
<body>
    <h1>Cadastrar Novo Animal</h1>

    <?php if ($mensagem): ?>
        <p style="color: red;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <?php if (count($clientes) === 0): ?>
        <p style="color: red;">É necessário cadastrar ao menos um cliente antes de registrar um animal.</p>
        <a href="../clientes/cadastrar_cliente.php">Cadastrar Cliente Primeiro</a>
    <?php else: ?>
        <form method="POST" action="">
            <div>
                <label for="cliente_id">Responsável *:</label><br>
                <select id="cliente_id" name="cliente_id" required>
                    <option value="">-- Selecione o Responsável --</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($cliente_id_selecionado == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div>
                <label for="nome">Nome do Pet *:</label><br>
                <input type="text" id="nome" name="nome" required>
            </div>
            <br>
            <div>
                <label for="especie">Espécie * (ex: Cachorro, Gato):</label><br>
                <input type="text" id="especie" name="especie" required>
            </div>
            <br>
            <div>
                <label for="raca">Raça:</label><br>
                <input type="text" id="raca" name="raca">
            </div>
            <br>
            <div>
                <label for="idade">Idade (anos):</label><br>
                <input type="number" id="idade" name="idade" min="0">
            </div>
            <br>
            <button type="submit">Salvar Animal</button>
            <a href="listar_animais.php">Voltar</a>
        </form>
    <?php endif; ?>
</body>
</html>