<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Médico - Fligma Clínica</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7e0e0; /* Cor de fundo diferente para médicos */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            padding: 35px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            box-sizing: border-box;
            border-top: 5px solid #dc3545; /* Borda diferente */
        }
        h2 {
            text-align: center;
            color: #dc3545; /* Cor do título diferente */
            margin-bottom: 30px;
            font-size: 1.8em;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #f8d7da; /* Borda diferente */
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group select:focus {
            border-color: #dc3545; /* Borda ao focar diferente */
            outline: none;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.2);
        }
        .form-group input[type="submit"] {
            background-color: #dc3545; /* Cor do botão diferente */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .form-group input[type="submit"]:hover {
            background-color: #c82333;
        }
        .message {
            margin-top: 25px;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95em;
        }
        .login-link a {
            color: #dc3545; /* Cor do link diferente */
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Médico</h2>

        <?php
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = htmlspecialchars($_GET['status']);
            $message = htmlspecialchars($_GET['message']);
            echo '<div class="message ' . $status . '">' . $message . '</div>';
        }
        ?>

        <form action="<?php echo BASE_URL; ?>/index.php?page=medico&action=cadastrar" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="crm">CRM:</label>
                <input type="text" id="crm" name="crm" placeholder="Ex: CRM/SP 123456" required>
            </div>
            <div class="form-group">
                <label for="especialidade">Especialidade:</label>
                <select id="especialidade" name="especialidade" required>
                    <option value="">Selecione uma especialidade</option>
                    <option value="Cardiologia">Cardiologia</option>
                    <option value="Dermatologia">Dermatologia</option>
                    <option value="Endocrinologia">Endocrinologia</option>
                    <option value="Ginecologia">Ginecologia</option>
                    <option value="Oftalmologia">Oftalmologia</option>
                    <option value="Pediatria">Pediatria</option>
                    <option value="Clínica Geral">Clínica Geral</option>
                    <option value="Neurologia">Neurologia</option>
                    <option value="Ortopedia">Ortopedia</option>
                    <option value="Psiquiatria">Psiquiatria</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Cadastrar Médico">
            </div>
        </form>

        <div class="login-link">
            Já tem uma conta de médico? <a href="<?php echo BASE_URL; ?>/index.php?page=medico&action=login">Faça Login</a>
        </div>
        <div class="login-link" style="margin-top: 10px;">
            <a href="<?php echo BASE_URL; ?>/index.php?page=home">Voltar para a Home</a>
        </div>
    </div>
</body>
</html>