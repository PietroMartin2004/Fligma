<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Consulta - Fligma Clínica</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f2f7;
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
            max-width: 500px;
            box-sizing: border-box;
            border-top: 5px solid #28a745;
        }
        h2 {
            text-align: center;
            color: #28a745;
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
        .form-group input[type="date"],
        .form-group input[type="time"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="date"]:focus,
        .form-group input[type="time"]:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.2);
        }
        .form-group input[type="submit"] {
            background-color: #28a745;
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
            background-color: #218838;
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
        .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95em;
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
    <div class="container">
        <h2>Agendar Nova Consulta</h2>

        <?php
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = htmlspecialchars($_GET['status']);
            $message = htmlspecialchars($_GET['message']);
            echo '<div class="message ' . $status . '">' . $message . '</div>';
        }
        ?>

        <form action="<?php echo BASE_URL; ?>/index.php?page=consulta&action=agendar" method="POST">
            <div class="form-group">
                <label for="medico_id">Selecione o Médico:</label>
                <select id="medico_id" name="medico_id" required>
                    <option value="">-- Selecione --</option>
                    <?php
                    // A variável $medicos é populada no ConsultaController
                    if (!empty($medicos)) {
                        foreach ($medicos as $medico) {
                            echo '<option value="' . htmlspecialchars($medico['id']) . '">'
                               . htmlspecialchars($medico['nome'])
                               . ' (' . htmlspecialchars($medico['especialidade_medica']) . ')'
                               . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum médico disponível</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="especialidade">Especialidade (informe a especialidade do médico escolhido):</label>
                <input type="text" id="especialidade" name="especialidade" required>
                </div>
            <div class="form-group">
                <label for="data">Data da Consulta:</label>
                <input type="date" id="data" name="data" required>
            </div>
            <div class="form-group">
                <label for="hora">Hora da Consulta:</label>
                <input type="time" id="hora" name="hora" required>
            </div>
            <div class="form-group">
                <label for="observacoes">Observações (opcional):</label>
                <textarea id="observacoes" name="observacoes" rows="4"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Agendar Consulta">
            </div>
        </form>

        <div class="back-link">
            <a href="<?php echo BASE_URL; ?>/index.php?page=usuario&action=dashboard">Voltar para o Dashboard</a>
        </div>
    </div>
</body>
</html>