<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Usuário - Fligma Clínica</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f2f7;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 1.8em;
        }
        .user-info {
            font-size: 1.1em;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-info a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            background-color: #dc3545;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .user-info a:hover {
            background-color: #c82333;
        }
        .container {
            flex-grow: 1;
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
        }
        .section-title {
            font-size: 1.5em;
            color: #007bff;
            margin-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
        }
        .appointment-list {
            margin-top: 20px;
        }
        .appointment-item {
            background-color: #f8f9fa;
            border: 1px solid #e2e6ea;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .appointment-item h3 {
            margin: 0 0 10px 0;
            color: #343a40;
            font-size: 1.3em;
        }
        .appointment-item p {
            margin: 0;
            color: #555;
            font-size: 0.95em;
        }
        .appointment-item strong {
            color: #000;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.85em;
            text-transform: uppercase;
        }
        .status.agendada { background-color: #cce5ff; color: #004085; }
        .status.concluída { background-color: #d4edda; color: #155724; }
        .status.cancelada { background-color: #f8d7da; color: #721c24; }
        .no-appointments {
            text-align: center;
            padding: 30px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            color: #856404;
        }
        .no-appointments p {
            margin: 0 0 15px 0;
            font-size: 1.1em;
        }
        .no-appointments a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        .no-appointments a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Fligma Clínica</h1>
        <div class="user-info">
            <?php
            $userName = $_SESSION['usuario']['nome'] ?? 'Usuário';
            echo 'Olá, ' . htmlspecialchars($userName) . '!';
            ?>
            <a href="<?php echo BASE_URL; ?>/index.php?page=usuario&action=logout">Sair</a>
        </div>
    </header>

    <div class="container">
        <h2>Seu Painel de Consultas</h2>

        <?php
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = htmlspecialchars($_GET['status']);
            $message = htmlspecialchars($_GET['message']);
            echo '<div class="message ' . $status . '">' . $message . '</div>';
        }
        ?>

        <div class="section-title">Próximas Consultas</div>
        <div class="appointment-list">
            <?php
            if (!empty($consultas)) {
                foreach ($consultas as $consulta) {
                    echo '<div class="appointment-item">';
                    echo '    <h3>Consulta com Dr(a). ' . htmlspecialchars($consulta['medico']) . '</h3>';
                    echo '    <p><strong>Data:</strong> ' . htmlspecialchars(date('d/m/Y', strtotime($consulta['data_consulta']))) . '</p>';
                    echo '    <p><strong>Hora:</strong> ' . htmlspecialchars(date('H:i', strtotime($consulta['hora_consulta']))) . '</p>';
                    echo '    <p><strong>Especialidade:</strong> ' . htmlspecialchars($consulta['especialidade'] ?? 'Não informada') . '</p>';
                    echo '    <p><strong>Status:</strong> <span class="status ' . htmlspecialchars(strtolower($consulta['status'])) . '">' . htmlspecialchars($consulta['status']) . '</span></p>';
                    echo '    <p><strong>Observações:</strong> ' . htmlspecialchars($consulta['observacoes'] ?? 'Nenhuma') . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-appointments">';
                echo '    <p>Você não possui nenhuma consulta agendada no momento.</p>';
                echo '    <p>Que tal <a href="' . BASE_URL . '/index.php?page=consulta&action=agendar">agendar uma nova consulta</a>?</p>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="section-title" style="margin-top: 40px;">Outras Ações</div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="<?php echo BASE_URL; ?>/index.php?page=consulta&action=agendar" style="background-color: #28a745; color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: 600; margin: 10px; display: inline-block;">Agendar Nova Consulta</a>
        </div>
    </div>
</body>
</html>