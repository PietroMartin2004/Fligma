<?php
// FLIGMA/APP/Model/UsuarioModel.php
namespace App\Model;

use App\Model\Database;

class UsuarioModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function cadastrar($nome, $email, $senhaHash, $tipo = 'cliente', $crm = null, $especialidadeMedica = null) {
        try {
            // 1. Verificar se o email já existe
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                return false; // Email já existe
            }

            // 2. Inserir o novo usuário/médico
            // Adaptação para incluir crm e especialidade_medica se for um médico
            if ($tipo === 'medico') {
                $stmt = $this->db->prepare("INSERT INTO usuarios (nome, email, senha, tipo, crm, especialidade_medica) VALUES (?, ?, ?, ?, ?, ?)");
                return $stmt->execute([$nome, $email, $senhaHash, $tipo, $crm, $especialidadeMedica]);
            } else {
                $stmt = $this->db->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
                return $stmt->execute([$nome, $email, $senhaHash, $tipo]);
            }

        } catch (\PDOException $e) {
            error_log("Erro PDO ao cadastrar usuário/médico: " . $e->getMessage());
            // die("Erro crítico ao cadastrar usuário (PDO): " . $e->getMessage() . "<br>SQLSTATE: " . $e->getCode());
            return false;
        }
    }

    public function autenticar($email, $senhaBruta) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senhaBruta, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function getUserById($userId) {
        $stmt = $this->db->prepare("SELECT id, nome, email, tipo, crm, especialidade_medica FROM usuarios WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // NOVO MÉTODO: Obter médicos por especialidade ou todos
    public function getMedicos($especialidade = null) {
        try {
            $sql = "SELECT id, nome, email, crm, especialidade_medica FROM usuarios WHERE tipo = 'medico'";
            $params = [];

            if ($especialidade) {
                $sql .= " AND especialidade_medica = ?";
                $params[] = $especialidade;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar médicos: " . $e->getMessage());
            return [];
        }
    }

    // NOVO MÉTODO: Obter um médico específico pelo ID
    public function getMedicoById($medicoId) {
        try {
            $stmt = $this->db->prepare("SELECT id, nome, email, crm, especialidade_medica FROM usuarios WHERE id = ? AND tipo = 'medico'");
            $stmt->execute([$medicoId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar médico por ID: " . $e->getMessage());
            return false;
        }
    }
}