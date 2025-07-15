<?php require_once __DIR__ . '/../../config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à Fligma Clínica</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 700;
        }
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            text-align: center;
            background: linear-gradient(to right, #e0f7fa, #c2e9fb);
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .main-content h2 {
            font-size: 3em;
            color: #0056b3;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .main-content p {
            font-size: 1.2em;
            color: #555;
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 700px;
        }
        .cta-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .cta-buttons a {
            display: inline-block;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .cta-buttons a:first-of-type { /* Botão "Cadastre-se Agora (Cliente)" */
            background-color: #28a745;
            color: white;
            border: 2px solid #28a745;
        }
        .cta-buttons a:first-of-type:hover {
            background-color: #218838;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .cta-buttons a:nth-of-type(2) { /* Botão "Acessar Minha Conta (Cliente)" */
            background-color: #007bff;
            color: white;
            border: 2px solid #007bff;
        }
        .cta-buttons a:nth-of-type(2):hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        /* Novo estilo para o botão do médico */
        .cta-buttons a.secondary[style*="background-color: #dc3545;"] {
            background-color: #dc3545 !important; /* Cor vermelha para médico */
            color: white;
            border: 2px solid #dc3545;
        }
        .cta-buttons a.secondary[style*="background-color: #dc3545;"]:hover {
            background-color: #c82333 !important; /* Tom mais escuro no hover */
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9em;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            margin-top: auto; /* Empurra o rodapé para baixo */
        }
        .footer p {
            margin: 0;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            .main-content h2 {
                font-size: 2.2em;
            }
            .main-content p {
                font-size: 1em;
            }
            .cta-buttons {
                flex-direction: column;
                gap: 15px;
            }
            .cta-buttons a {
                width: 80%;
                max-width: 300px;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Fligma Clínica</h1>
    </header>

    <main class="main-content">
        <h2>Cuidando de você com excelência.</h2>
        <p>A Fligma Clínica oferece um serviço completo para suas necessidades de saúde. <br>Cadastre-se ou faça login para gerenciar suas consultas.</p>

        <div class="cta-buttons">
            <a href="<?php echo BASE_URL; ?>/index.php?page=usuario&action=cadastrar" class="secondary">Cadastre-se Agora (Cliente)</a>
            <a href="<?php echo BASE_URL; ?>/index.php?page=usuario&action=login">Acessar Minha Conta (Cliente)</a>
            <a href="<?php echo BASE_URL; ?>/index.php?page=medico&action=login" class="secondary" style="background-color: #dc3545;">Acessar Conta (Médico)</a>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Fligma Clínica. Todos os direitos reservados.</p>
    </footer>
</body>
</html>