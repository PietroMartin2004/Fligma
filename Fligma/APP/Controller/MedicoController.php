<?php
// FLIGMA/APP/Controller/MedicoController.php
namespace App\Controller;

use App\Model\UsuarioModel;
use App\Model\ConsultaModel;

class MedicoController {
    private $usuarioModel; // Usamos UsuarioModel para gerenciar o médico na tabela 'usuarios'
    private $consultaModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        $this->consultaModel = new ConsultaModel();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $crm = $_POST['crm'] ?? '';
            $especialidade = $_POST['especialidade'] ?? '';
            $tipo = 'medico'; // Definimos explicitamente como médico

            if (empty($nome) || empty($email) || empty($senha) || empty($crm) || empty($especialidade)) {
                header('Location: ' . BASE_URL . '/index.php?page=medico&action=cadastrar&status=error&message=' . urlencode('Todos os campos são obrigatórios.'));
                exit();
            }

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Chama o método cadastrar do UsuarioModel, passando os dados específicos de médico
            $cadastroSucesso = $this->usuarioModel->cadastrar($nome, $email, $senhaHash, $tipo, $crm, $especialidade);

            if ($cadastroSucesso) {
                header('Location: ' . BASE_URL . '/index.php?page=medico&action=login&status=success&message=' . urlencode('Cadastro de médico realizado com sucesso!'));
                exit();
            } else {
                header('Location: ' . BASE_URL . '/index.php?page=medico&action=cadastrar&status=error&message=' . urlencode('Erro ao cadastrar médico. Email ou CRM já podem estar em uso.'));
                exit();
            }
        } else {
            require_once __DIR__ . '/../View/medico/cadastrar.php'; // NOVO: View de cadastro de médico
        }
    }

    public function login() {
        require_once __DIR__ . '/../View/medico/login.php'; // NOVO: View de login de médico
    }

    public function logar() {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $medico = $this->usuarioModel->autenticar($email, $senha);

        // Verifica se é um médico e autentica
        if ($medico && $medico['tipo'] === 'medico') {
            $_SESSION['usuario'] = $medico;
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $medico['id'];
            $_SESSION['user_nome'] = $medico['nome'];
            $_SESSION['user_tipo'] = $medico['tipo']; // Garante que o tipo 'medico' está na sessão

            header("Location: " . BASE_URL . "/index.php?page=medico&action=dashboard");
            exit();
        } else {
            header("Location: " . BASE_URL . "/index.php?page=medico&action=login&status=error&message=" . urlencode("Email ou senha inválidos para médico, ou você não é um médico cadastrado."));
            exit();
        }
    }

    public function dashboard() {
        // Redireciona para o dashboard correto se o tipo de usuário estiver na sessão
        if (isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] !== 'medico') {
             header("Location: " . BASE_URL . "/index.php?page=usuario&action=dashboard");
             exit();
        }

        if (!isset($_SESSION['usuario']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_tipo'] !== 'medico') {
            header("Location: " . BASE_URL . "/index.php?page=medico&action=login&status=error&message=" . urlencode("Você precisa fazer login como médico para acessar o dashboard."));
            exit();
        }

        $medicoId = $_SESSION['user_id'] ?? null;
        $minhasConsultas = [];

        if ($medicoId) {
            $minhasConsultas = $this->consultaModel->getConsultasByMedicoId($medicoId);
        }

        require_once __DIR__ . '/../View/medico/dashboard.php'; // NOVO: Dashboard de médico
    }

    public function logout() {
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "/index.php?page=home&status=success&message=" . urlencode("Você foi desconectado com sucesso."));
        exit();
    }

    public function minhasConsultas() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_tipo'] !== 'medico') {
            header("Location: " . BASE_URL . "/index.php?page=medico&action=login&status=error&message=" . urlencode("Acesso negado. Faça login como médico."));
            exit();
        }
        $medicoId = $_SESSION['user_id'];
        $consultas = $this->consultaModel->getConsultasByMedicoId($medicoId);
        require_once __DIR__ . '/../View/medico/minhas_consultas.php';
    }

    // Você pode adicionar um método para gerenciar uma consulta específica, mudar status, etc.
    public function gerenciarConsulta() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_tipo'] !== 'medico') {
            header("Location: " . BASE_URL . "/index.php?page=medico&action=login&status=error&message=" . urlencode("Acesso negado. Faça login como médico."));
            exit();
        }
        // Lógica para pegar o ID da consulta da URL e exibir detalhes/opções de gerenciamento
        $consultaId = $_GET['id'] ?? null;
        // ... carregar a consulta, exibir formulário de atualização de status, etc.
        echo "Página para gerenciar a consulta ID: " . htmlspecialchars($consultaId);
        // require_once __DIR__ . '/../View/medico/gerenciar_consulta.php';
    }
}