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
