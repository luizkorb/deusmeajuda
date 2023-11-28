<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <link rel="stylesheet" href="adm.css">
</head>
<body>

<div class="cabecalho">
        <img src="menu.png" width="350px" class="menu">
    </div>    <br>
<div class="tudo">
    <h2>Inserir Dados</h2>
    <form action="crud.php" method="post" class="form">
        CPF: <br> <input type="text" name="cpf"  required><br>
        Email: <br> <input type="email" name="email"  required><br>
        Senha: <br> <input type="password" name="senha" required><br>
        Nome: <br> <input type="text" name="nome" required><br>
        Telefone: <br> <input type="text" name="telefone" required><br>
        Usuário: <br> <input type="text" name="usuario" required><br>
        <input type="submit" name="inserir" value="Inserir" class="button">
    </form>


    




    <h2>Excluir Dados</h2>
    <form action="crud.php" method="post" class="form">
        CPF do Bombeiro a ser excluído: <input type="cpf" name="cpf" required><br>
        <input type="submit" name="excluir" value="Excluir" class="button">
    </form>


    <h2>Alterar Dados</h2>
    <form action="crud.php" method="get" class="form">
    CPF do Bombeiro a ser alterado: <input type="text" name="cpfAntigo" required><br><br>
    Novo CPF: <br> <input type="text" name="novoCpf" required><br>
    Novo Email: <input type="email" name="email" required><br>
    Nova Senha: <input type="password" name="senha" required><br>
    Novo Nome: <input type="text" name="nome" required><br>
    Novo Telefone: <input type="text" name="telefone" required><br>
    Novo Usuário: <input type="text" name="usuario" required><br>
    <input type="submit" name="alterar" value="Alterar" class="button">
</form>

<?php
include_once("crud.php"); // Certifique-se de ajustar o caminho conforme necessário

// Lógica para processar a exclusão ou alteração enviada pelos formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
    $cpf = $_POST['cpf'];
    excluirUsuario($cpf);
}

// Lógica para processar o formulário de filtragem
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["listar"])) {
    $filtro = isset($_GET["nome"]) ? $_GET["nome"] : '';

    // Use o valor de $filtro na sua consulta SQL
    $comando = $pdo->prepare("SELECT * FROM cadastro_bombeiro WHERE Nome LIKE :filtro");
    $comando->execute([':filtro' => "%$filtro%"]);

    $lista_usuarios = $comando->fetchAll(PDO::FETCH_ASSOC);
}
?>



<h2>Listar Dados</h2>

<form action="" method="get" class="form">
    <label for="nome">Filtrar por nome:</label>
    <input type="text" id="nome" name="nome" placeholder="Digite um nome">
    <input type="submit" name="listar" value="Listar" class="button"> 
</form>

<?php
if (!empty($lista_usuarios)) {
    echo '<table border="1" class="tabela">
            <thead>
                <tr>
                    <th> CPF </th>
                    <th> Nome </th>
                    <th> E-mail </th>
                    <th> Telefone</th>
                    <th> Usuário </th>
                    <th> Ações </th>
                </tr>
            </thead>
            <tbody>';
    
    foreach ($lista_usuarios as $linha) {
        echo '<tr>
                <td>' . $linha['CPF'] . ' </td>
                <td>' . $linha['Nome'] . ' </td>
                <td>' . $linha['Email'] . ' </td>
                <td>' . $linha['Telefone'] . ' </td>
                <td>' . $linha['Usuario'] . ' </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="cpf" value="' . $linha['CPF'] . '">
                        <button type="submit" name="excluir">Excluir</button>
                    </form>
                    <form action="alterar_usuario.php" method="get">
                        <input type="hidden" name="cpf" value="' . $linha['CPF'] . '">
                        <button type="submit">Alterar</button>
                    </form>
                </td>
            </tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<p>Nenhum usuário encontrado.</p>';
}
?>

</body>
</html>