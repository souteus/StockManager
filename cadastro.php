<!-- CDN da biblioteca SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/script.js"></script>
<!-- biblioteca Ajax para rodar a mensagem personalizada -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/a84022c447.js" crossorigin="anonymous"></script>

<?php
include_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confpassword = $_POST['confpassword'];

    // Checar se o usuário e a senha existem no BD
    if (!empty($username) && !empty($password)) {
        // Checar se a senha confere com a confirmação de senha
        if ($password === $confpassword) {
            try {
                // Checaer se o usuário já existe
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
                $stmt->execute([$username]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Se o usuário existir, faça o login dele no sistema
                if (count($result) > 0) {
                    session_start();
                    $_SESSION['usuario'] = $result[0]['nome'];
                    $_SESSION['nivel'] = $result[0]['nivel'];
                    echo "<script>window.location = 'index.php'</script>";
                } else {
                    // Se o usuário não exisitr, registre ele
                    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, usuario, senha, confsenha) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $username, $password, $confpassword]);
                    echo "<script>window.location = 'login.php'</script>";
                }
            } catch (Exception $e) {
                echo "Erro ao registrar usuário: " . $e->getMessage();
            }
        } else {
            echo "<script>
        $(function(){
        Mensagem2('Senhas não coincidem!', '2000')
        })
        </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        a {
            color: #74C0FC;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form class="form2" action="" method="post">
        <div class="voltar">
            <i class="fa-solid fa-arrow-left" style="color: #74C0FC;"><a href="login.php">VOLTAR</a></i>
        </div>
        <div class="img2">
            <img src="img/cadastro.png" alt="Logo">
        </div>
        <div class="nome">
            <div class="i">
                <i class="fa-solid fa-user"></i>
            </div>
            <input type="text" placeholder="Nome" name="name" required>
        </div>
        <div class="user">
            <div class="i1">
                <i class="fa-solid fa-address-card"></i>
            </div>
            <input type="text" placeholder="Usuário" name="username" required>
        </div>
        <div class="senha">
            <div class="i">
                <i class="fa-solid fa-lock"></i>
            </div>
            <input type="password" placeholder="Senha" name="password" required>
        </div>
        <div class="confsenha">
            <div class="i">
                <i class="fa-solid fa-lock"></i>
            </div>
            <input type="password" placeholder="Repita a senha" name="confpassword" required>
        </div>
        <button class="button" type="submit">CADASTRAR</button>
    </form>
</body>

</html>