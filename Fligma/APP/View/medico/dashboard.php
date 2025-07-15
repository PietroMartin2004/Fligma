<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Médico - Fligma Clínica</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7e0e0; /* Cor de fundo para médicos */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }
        .header {
            background-color: #dc3545; /* Cor diferente para médicos */
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
            background-color: #c82333; /* Cor do botão sair diferente */
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .user-info a:hover {
            background-color: #bd2130;
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
            color: #dc3545; /* Cor do título diferente */
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
        }
        .section-title {
            font-size: 1.5em;
            color: #dc3545;
            margin-bottom: 20px;
            border-bottom: 2px solid #f2dede;
            padding-bottom: 10px;
        }
        .appointment-list {
            margin-top: 20px;
        }
        .appointment-item {
            background-color: #fcf8f2; /* Fundo item de consulta diferente */
            border: 1px solid #f5c6cb;
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
        .status.agendada { background-color: #f8d7da; color: #721c24; } /* Cores status diferentes */
        .status.concluída { background-color: #d4edda; color: #155724; }
        .status.cancelada { background-color: #ffeeba; color: #856404; }
        .no-appointments {
            text-align: center;
            padding: 30px;
            background-color: #ffeeba;
            border: 1px solid #ffdf7e;
            border-radius: 8px;
            color: #856404;
        }
        .no-appointments p {
            margin: 0 0 15px 0;
            font-size: 1.1em;
        }
        .no-appointments a {
            color: #dc3545;
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
        <h1>Dashboard do Médico</h1>
        <div class="user-info">
            <?php
            $userName = $_SESSION['usuario']['nome'] ?? 'Médico(a)';
            echo 'Olá, Dr(a). ' . htmlspecialchars($userName) . '!';
            ?>
            <a href="<?php echo BASE_URL; ?>/index.php?page=medico&action=logout">Sair</a>
        </div>
    </header>

    <div class="container">
        <h2>Suas Consultas Agendadas</h2>

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
            if (!empty($minhasConsultas)) {
                foreach ($minhasConsultas as $consulta) {
                    echo '<div class="appointment-item">';
                    echo '    <h3>Consulta com Paciente: ' . htmlspecialchars($consulta['usuario_nome_consulta']) . '</h3>';
                    echo '    <p><strong>Data:</strong> ' . htmlspecialchars(date('d/m/Y', strtotime($consulta['data_consulta']))) . '</p>';
                    echo '    <p><strong>Hora:</strong> ' . htmlspecialchars(date('H:i', strtotime($consulta['hora_consulta']))) . '</p>';
                    echo '    <p><strong>Especialidade:</strong> ' . htmlspecialchars($consulta['especialidade'] ?? 'Não informada') . '</p>';
                    echo '    <p><strong>Status:</strong> <span class="status ' . htmlspecialchars(strtolower($consulta['status'])) . '">' . htmlspecialchars($consulta['status']) . '</span></p>';
                    echo '    <p><strong>Observações:</strong> ' . htmlspecialchars($consulta['observacoes'] ?? 'Nenhuma') . '</p>';
                    // Você pode adicionar links para gerenciar a consulta aqui, ex:
                    // echo '    <p><a href="' . BASE_URL . '/index.php?page=medico&action=gerenciar_consulta&id=' . htmlspecialchars($consulta['id']) . '">Gerenciar Consulta</a></p>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-appointments">';
                echo '    <p>Você não possui consultas agendadas no momento.</p>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="section-title" style="margin-top: 40px;">Informações do Médico</div>
        <div class="appointment-item">
            <p><strong>CRM:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['crm'] ?? 'Não informado'); ?></p>
            <p><strong>Especialidade:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['especialidade_medica'] ?? 'Não informada'); ?></p>
        </div>
    </div>
</body>
</html>