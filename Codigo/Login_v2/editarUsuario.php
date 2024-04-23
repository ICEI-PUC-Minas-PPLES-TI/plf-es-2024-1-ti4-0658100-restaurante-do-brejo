<?php
include_once('config.php');

// Verifica se 'id' foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Agora é seguro usar o 'id'

    // Aqui você coloca a lógica para buscar os dados do usuário e mostrar no formulário de edição
    // Por exemplo:
    $sql = "SELECT id, nome, email, papel FROM usuarios WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        // Exiba os dados do usuário em um formulário para edição
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "ID do usuário não especificado.";
    // Opção: redirecionar para outra página se o ID não for fornecido
    // header('Location: nome_da_sua_pagina_de_listagem.php');
    // exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de controle</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets2/css/style.css">
</head>

<body>
    <?php include_once ('config.php'); ?>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name=""></ion-icon>
                        </span>
                        <span class="title">Restaurante do Brejo</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">Mensagens</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Ajuda</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Configurações</span>
                    </a>
                </li>

                

                <li>
                    <a href="login.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sair</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            

            <!-- ================ Order Details List ================= -->
            <div class="details">
               

                <!-- ================= New Customers ================ -->
                <div class="recentOrders">
                    <?php if (isset($user)): ?>
                        <form action="saveEdit.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
                            
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            
                            <label for="papel">Papel:</label>
                            <select id="papel" name="papel">
                                <option value="usuario" <?php echo ($user['papel'] == 'usuario') ? 'selected' : ''; ?>>Usuário</option>
                                <option value="adm" <?php echo ($user['papel'] == 'adm') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="funcionario" <?php echo ($user['papel'] == 'funcionario') ? 'selected' : ''; ?>>Funcionario</option>
                                <!-- Adicione aqui mais opções de papel conforme necessário -->
                            </select>
                            
                            <button type="submit">Atualizar</button>
                        </form>
                        <?php else: ?>
                            <p>Usuário não encontrado ou ID não especificado.</p>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets2/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>