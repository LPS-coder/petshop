<?php
require_once '../../infra/conexao.php';

$cliente_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($cliente_id) {
    try {
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $cliente_id]);
    } catch (PDOException $e) {
        die("Erro ao excluir cliente: " . $e->getMessage());
    }
}

header('Location: listar_clientes.php?sucesso=1');
exit;