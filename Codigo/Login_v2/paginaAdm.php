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
            <div class="cardBox">
                

                
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                

                <!-- ================= New Customers ================ -->
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Usuários</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Papel</th>
                                <th>Ações</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlUsers = "SELECT id, nome, email, papel FROM usuarios ORDER BY id DESC LIMIT 8";
                            $resultUsers = $conexao->query($sqlUsers);
                            if ($resultUsers->num_rows > 0) {
                                while ($row = $resultUsers->fetch_assoc()) {
                                    echo "<tr>
                            <td>" . htmlspecialchars($row['nome']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['papel']) . "</td>
                            <td><a href='editarUsuario.php?id=" . $row['id'] . "'>Editar</a></td>
                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No users found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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