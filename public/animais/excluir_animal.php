<?php
require_once '../../infra/conexao.php';

$animal_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($animal_id) {
    try {
        $sql = "DELETE FROM animais WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $animal_id]);
    } catch (PDOException $e) {
        die("Erro ao excluir animal: " . $e->getMessage());
    }
}

header('Location: listar_animais.php?sucesso=1');
exit;