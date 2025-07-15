<?php
// FLIGMA/APP/Model/ConsultaModel.php
namespace App\Model;

use App\Model\Database;

class ConsultaModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getConsultasByUserId($userId) {
        try {
            $stmt = $this->db->prepare("SELECT c.*, u.nome as medico_nome_consulta FROM consultas c LEFT JOIN usuarios u ON c.medico_id = u.id WHERE c.usuario_id = ? ORDER BY data_consulta ASC, hora_consulta ASC");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar consultas de usuário: " . $e->getMessage());
            return [];
        }
    }

    // NOVO: Método para buscar consultas de um MÉDICO específico
    public function getConsultasByMedicoId($medicoId) {
        try {
            $stmt = $this->db->prepare("SELECT c.*, u.nome as usuario_nome_consulta FROM consultas c JOIN usuarios u ON c.usuario_id = u.id WHERE c.medico_id = ? ORDER BY data_consulta ASC, hora_consulta ASC");
            $stmt->execute([$medicoId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar consultas de médico: " . $e->getMessage());
            return [];
        }
    }

    // ATUALIZADO: Inclui medico_id
    public function agendarConsulta($usuarioId, $medicoId, $medicoNome, $data, $hora, $especialidade, $observacoes, $status) {
        try {
            $stmt = $this->db->prepare("INSERT INTO consultas (usuario_id, medico_id, medico_nome, data_consulta, hora_consulta, especialidade, observacoes, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$usuarioId, $medicoId, $medicoNome, $data, $hora, $especialidade, $observacoes, $status]);
        } catch (\PDOException $e) {
            error_log("Erro ao agendar consulta: " . $e->getMessage());
            // die("Erro crítico ao agendar consulta (PDO): " . $e->getMessage() . "<br>SQLSTATE: " . $e->getCode());
            return false;
        }
    }

    public function getAllConsultas() {
        try {
            // Unindo com usuários para pegar o nome do usuário e do médico
            $stmt = $this->db->query("SELECT c.*, u_cliente.nome as nome_cliente, u_medico.nome as nome_medico FROM consultas c JOIN usuarios u_cliente ON c.usuario_id = u_cliente.id LEFT JOIN usuarios u_medico ON c.medico_id = u_medico.id ORDER BY c.data_consulta ASC, c.hora_consulta ASC");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar todas as consultas: " . $e->getMessage());
            return [];
        }
    }
}