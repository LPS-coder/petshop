<?php
require_once __DIR__ . '/../infra/conexao.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
$stmt->execute([':id' => $id]);
$prato = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prato) {
    header("Location: index.php");
    exit;
}

$usuarios = $pdo->query("SELECT * FROM clientes ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'] ?? '';
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = $_POST['telefone'] ?? '';

   if (empty($cliente_id) || empty($nome) || empty($email) || empty($telefone)) {
        $mensagem = "Preencha todos os campos!";
    } else {

        $sql = "UPDATE pratos SET usuario_id = :usuario_id, nome = :nome, descricao = :descricao, preco = :preco, categoria = :categoria WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':nome'       => $nome,
            ':descricao'  => $descricao,
            ':preco'      => $preco,
            ':categoria'  => $categoria,
            ':id'         => $id
        ]);
        header("Location: index.php");
        exit;
    }
}
?>
