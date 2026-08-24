<?php
require_once __DIR__ . '/../infra/conexao.php';

$mensagem = '';

$stmt_users = $pdo->query("SELECT * FROM clientes ORDER BY nome ASC");
$usuarios = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'] ?? '';
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = $_POST['telefone'] ?? '';

    if (empty($cliente_id) || empty($nome) || empty($email) || empty($telefone)) {
        $mensagem = "Preencha todos os campos!";
    } else {

        $sql = "INSERT INTO clientes (cliente_id, nome, email, telefone) VALUES (:cliente_id, :nome, :email, :telefone)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':nome'       => $nome,
            ':email'      => $email,
            ':telefone'   => $telefone,
            ':categoria'  => $categoria
        ]);
        $mensagem = "Cliente cadastrado com sucesso!";
    }
}
?>