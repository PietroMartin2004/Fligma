<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Consultas - Fligma Clínica</title>
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
        .header a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }
        .header a:hover {
            background-color: #004085;
        }
        .container {
            flex-grow: 1;
            width: 90%;
            max-width: 1000px;
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
        .consultas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .consultas-table th, .consultas-table td {
            border: 1px solid #e9ecef;
            padding: 12px;
            text-align: left;
        }
        .consultas-table th {
            background-color: #f8f9fa;
            color: #343a40;
            font-weight: 600;
        }
        .consultas-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .consultas-table tr:hover {
            background-color: #e9e9e9;
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
        .no-consultas {
            text-align: center;
            padding: 30px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            color: #856404;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Lista de Consultas</h1>
        <a href="<?php echo BASE_URL; ?>/index.php?page=usuario&action=dashboard">Voltar ao Dashboard</a>
    </header>

    <div class="container">
        <h2>Todas as Consultas Agendadas</h2>

        <?php
        if (!empty($consultas)) {
            echo '<table class="consultas-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID da Consulta</th>';
            echo '<th>Usuário (ID)</th>';
            echo '<th>Médico</th>';
            echo '<th>Especialidade</th>';
            echo '<th>Data</th>';
            echo '<th>Hora</th>';
            echo '<th>Status</th>';
            echo '<th>Observações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($consultas as $consulta) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($consulta['id']) . '</td>';
                echo '<td>' . htmlspecialchars($consulta['usuario_id']) . '</td>';
                echo '<td>' . htmlspecialchars($consulta['medico']) . '</td>';
                echo '<td>' . htmlspecialchars($consulta['especialidade']) . '</td>';
                echo '<td>' . htmlspecialchars(date('d/m/Y', strtotime($consulta['data_consulta']))) . '</td>';
                echo '<td>' . htmlspecialchars(date('H:i', strtotime($consulta['hora_consulta']))) . '</td>';
                echo '<td><span class="status ' . htmlspecialchars(strtolower($consulta['status'])) . '">' . htmlspecialchars($consulta['status']) . '</span></td>';
                echo '<td>' . htmlspecialchars($consulta['observacoes'] ?? 'Nenhuma') . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="no-consultas">';
            echo '    <p>Não há consultas cadastradas no sistema.</p>';
            echo '</div>';
        }
        ?>

        <div class="back-link">
            <a href="<?php echo BASE_URL; ?>/index.php?page=usuario&action=dashboard">Voltar para o Dashboard</a>
        </div>
    </div>
</body>
</html>