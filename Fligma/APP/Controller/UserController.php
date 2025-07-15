<?php
// FLIGMA/APP/Controller/UserController.php
namespace App\Controller;

use App\Model\UsuarioModel;
use App\Model\ConsultaModel;

class UserController {
    private $usuarioModel;
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
            // Por padrão, quem se cadastra aqui é um 'cliente'
            $tipo = 'cliente';

            if (empty($nome) || empty($email) || empty($senha)) {
                header('Location: ' . BASE_URL . '/index.php?page=usuario&action=cadastrar&status=error&message=' . urlencode('Todos os campos são obrigatórios.'));
                exit();
            }

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Passa o tipo para o modelo
            $cadastroSucesso = $this->usuarioModel->cadastrar($nome, $email, $senhaHash, $tipo);

            if ($cadastroSucesso) {
                header('Location: ' . BASE_URL . '/index.php?page=usuario&action=login&status=success&message=' . urlencode('Cadastro realizado com sucesso! Por favor, faça login.'));
                exit();
            } else {
                header('Location: ' . BASE_URL . '/index.php?page=usuario&action=cadastrar&status=error&message=' . urlencode('Erro ao cadastrar usuário. Email já pode estar em uso ou outro problema.'));
                exit();
            }
        } else {
            require_once __DIR__ . '/../View/usuario/cadastrar.php';
        }
    }

    public function login() {
        require_once __DIR__ . '/../View/usuario/login.php';
    }

    public function logar() {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $usuario = $this->usuarioModel->autenticar($email, $senha);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nome'] = $usuario['nome'];
            $_SESSION['user_tipo'] = $usuario['tipo']; // Armazena o tipo do usuário na sessão

            // Redireciona com base no tipo de usuário
            if ($usuario['tipo'] === 'medico') {
                header("Location: " . BASE_URL . "/index.php?page=medico&action=dashboard");
            } else {
                header("Location: " . BASE_URL . "/index.php?page=usuario&action=dashboard");
            }
            exit();
        } else {
            header("Location: " . BASE_URL . "/index.php?page=usuario&action=login&status=error&message=" . urlencode("Email ou senha inválidos."));
            exit();
        }
    }

    public function dashboard() {
        // Redireciona para o dashboard correto se o tipo de usuário estiver na sessão
        if (isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] === 'medico') {
             header("Location: " . BASE_URL . "/index.php?page=medico&action=dashboard");
             exit();
        }

        if (!isset($_SESSION['usuario']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_tipo'] !== 'cliente') {
            header("Location: " . BASE_URL . "/index.php?page=usuario&action=login&status=error&message=" . urlencode("Você precisa fazer login como cliente para acessar o dashboard."));
            exit();
        }

        $userId = $_SESSION['user_id'] ?? null;
        $consultas = [];

        if ($userId) {
            $consultas = $this->consultaModel->getConsultasByUserId($userId);
        }

        require_once __DIR__ . '/../View/usuario/dashboard.php';
    }

    public function logout() {
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "/index.php?page=home&status=success&message=" . urlencode("Você foi desconectado com sucesso."));
        exit();
    }
}