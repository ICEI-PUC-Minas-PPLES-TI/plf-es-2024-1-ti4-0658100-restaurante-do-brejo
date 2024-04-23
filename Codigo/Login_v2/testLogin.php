<?php
session_start();

if (!empty($_POST['email']) && !empty($_POST['senha'])) {
    include_once('config.php');
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conexao->query($sql);

    if (mysqli_num_rows($result) < 1) {
        // Email não encontrado
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            // Senha correta
            $_SESSION['email'] = $email;
            // Armazene apenas um token ou flag de sessão ao invés da senha, por segurança
            $_SESSION['papel'] = $row['papel']; // Armazena o papel do usuário na sessão
            $_SESSION['id_cliente'] = $row['id'];
            
            // Redireciona o usuário com base no seu papel
            if ($_SESSION['papel'] == 'adm') {
                header('Location: paginaAdm.php');
            } elseif ($_SESSION['papel'] == 'funcionario') {
                header('Location: paginaFuncionario.php');
            } else { // 'cliente' e outros papéis não especificados
                header('Location: indexLogado.php');
            }
            exit();
        } else {
            // Senha incorreta
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: login.php');
        }
    }
} else {
    header('Location: login.php');
}
?>