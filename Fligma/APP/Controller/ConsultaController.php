<?php
// FLIGMA/APP/Controller/ConsultaController.php
namespace App\Controller;

use App\Model\ConsultaModel;
use App\Model\UsuarioModel; // NOVO: Para buscar a lista de médicos

class ConsultaController {
    private $consultaModel;
    private $usuarioModel; // NOVO

    public function __construct() {
        $this->consultaModel = new ConsultaModel();
        $this->usuarioModel = new UsuarioModel(); // NOVO
    }

    public function agendar() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_tipo'] !== 'cliente') {
            header("Location: " . BASE_URL . "/index.php?page=usuario&action=login&status=error&message=" . urlencode("Você precisa fazer login como cliente para agendar uma consulta."));
            exit();
        }

        $medicos = $this->usuarioModel->getMedicos(); // Obtém a lista de médicos

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioId = $_SESSION['user_id'] ?? null;
            $medicoId = $_POST['medico_id'] ?? ''; // NOVO: Captura o ID do médico
            $data = $_POST['data'] ?? '';
            $hora = $_POST['hora'] ?? '';
            $especialidade = $_POST['especialidade'] ?? '';
            $observacoes = $_POST['observacoes'] ?? '';

            if (empty($usuarioId) || empty($medicoId) || empty($data) || empty($hora) || empty($especialidade)) {
                header('Location: ' . BASE_URL . '/index.php?page=consulta&action=agendar&status=error&message=' . urlencode('Preencha todos os campos obrigatórios.'));
                exit();
            }

            // Busca o nome do médico pelo ID para armazenar na consulta (redundante, mas útil por enquanto)
            $medicoInfo = $this->usuarioModel->getMedicoById($medicoId);
            $medicoNome = $medicoInfo ? $medicoInfo['nome'] : 'Médico Desconhecido';


            $agendado = $this->consultaModel->agendarConsulta($usuarioId, $medicoId, $medicoNome, $data, $hora, $especialidade, $observacoes, 'Agendada');

            if ($agendado) {
                header('Location: ' . BASE_URL . '/index.php?page=usuario&action=dashboard&status=success&message=' . urlencode('Consulta agendada com sucesso!'));
                exit();
            } else {
                header('Location: ' . BASE_URL . '/index.php?page=consulta&action=agendar&status=error&message=' . urlencode('Erro ao agendar consulta. Tente novamente.'));
                exit();
            }

        } else {
            // Passa a lista de médicos para a view
            require_once __DIR__ . '/../View/consulta/agendar.php';
        }
    }

    public function listar() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Apenas admins ou médicos deveriam ver todas as consultas, por exemplo.
        // Por enquanto, vamos permitir se estiver logado.
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header("Location: " . BASE_URL . "/index.php?page=usuario&action=login&status=error&message=" . urlencode("Acesso negado. Faça login."));
            exit();
        }

        $consultas = $this->consultaModel->getAllConsultas();

        require_once __DIR__ . '/../View/consulta/listar.php';
    }
}