<?php
require_once 'arvore.php';

session_start();
if (!isset($_SESSION['tree'])) {
    $_SESSION['tree'] = new BinaryTree();
}
$tree = $_SESSION['tree'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $value = isset($_POST['value']) ? (int)$_POST['value'] : null;

    if ($action === 'insert' && $value !== null) {
        $tree->insert($value);
    } elseif ($action === 'remove' && $value !== null) {
        $tree->remove($value);
    } elseif ($action === 'clear') {
        $tree->clear();
    }
}

function displayTraversal($traversalFunction) {
    ob_start();
    $traversalFunction($_SESSION['tree']->root);
    return ob_get_clean();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Manipulação de Árvore Binária</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Manipulação de Árvore Binária</h1>
        <form method="POST">
            <input type="number" name="value" placeholder="Digite um valor">
            <button type="submit" name="action" value="insert">Inserir</button>
            <button type="submit" name="action" value="remove">Remover</button>
            <button type="submit" name="action" value="clear">Limpar Árvore</button>
        </form>

        <div class="output">
            <h2>Caminhamentos</h2>
            <p><strong>Pré-ordem:</strong> <?php echo displayTraversal([$tree, 'preOrder']); ?></p>
            <p><strong>Em-ordem:</strong> <?php echo displayTraversal([$tree, 'inOrder']); ?></p>
            <p><strong>Pós-ordem:</strong> <?php echo displayTraversal([$tree, 'postOrder']); ?></p>

            <h2>Informações da Árvore</h2>
            <p><strong>Altura da árvore:</strong> <?php echo $tree->height($tree->root); ?></p>
            <p><strong>Número de folhas:</strong> <?php echo $tree->countLeaves($tree->root); ?></p>
            <p><strong>Árvore completa:</strong> <?php echo $tree->isComplete($tree->root) ? 'Sim' : 'Não'; ?></p>
        </div>
    </div>
</body>
</html>
