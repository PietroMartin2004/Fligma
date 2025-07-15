<?php
// FLIGMA/index.php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use App\Controller\UserController;
use App\Controller\ConsultaController;
use App\Controller\MedicoController; // NOVO: Importa o MedicoController

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'home':
        require_once __DIR__ . '/APP/View/home.php';
        break;

    case 'usuario':
        $controller = new UserController();
        switch ($action) {
            case 'cadastrar':
                $controller->cadastrar();
                break;
            case 'login':
                $controller->login();
                break;
            case 'logar':
                $controller->logar();
                break;
            case 'dashboard':
                $controller->dashboard();
                break;
            case 'logout':
                $controller->logout();
                break;
            default:
                echo "Ação inválida para usuário.";
        }
        break;

    case 'medico': // NOVO: Roteamento para médicos
        $controller = new MedicoController();
        switch ($action) {
            case 'cadastrar':
                $controller->cadastrar();
                break;
            case 'login':
                $controller->login();
                break;
            case 'logar':
                $controller->logar();
                break;
            case 'dashboard':
                $controller->dashboard();
                break;
            case 'logout':
                $controller->logout();
                break;
            case 'minhas_consultas': // Para o médico ver suas consultas
                $controller->minhasConsultas();
                break;
            case 'gerenciar_consulta': // Para o médico gerenciar uma consulta específica
                $controller->gerenciarConsulta();
                break;
            // Adicione outras ações específicas para médicos aqui
            default:
                echo "Ação inválida para médico.";
        }
        break;

    case 'consulta':
        try {
            $controller = new ConsultaController();
            switch ($action) {
                case 'agendar':
                    $controller->agendar();
                    break;
                case 'listar': // Lista todas as consultas (talvez para um admin ou para o médico ver todas)
                    $controller->listar();
                    break;
                case 'detalhes':
                    echo "Página de detalhes da consulta"; // Placeholder
                    break;
                default:
                    echo "Ação inválida para consulta.";
            }
        } catch (\Error $e) {
            echo "Erro: Controller de Consulta não encontrado. Mensagem: " . $e->getMessage();
            error_log("Erro de Autoload (ConsultaController): " . $e->getMessage());
        }
        break;

    default:
        header("Location: " . BASE_URL . "/index.php?page=home");
        exit();
}
?>