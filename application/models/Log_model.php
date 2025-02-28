<?php
class Log_model extends CI_Model {
    public function registrar_log($tabela, $acao, $dados, $usuario_id = NULL) {
        $log_data = [
            'tabela' => $tabela,
            'acao' => $acao,
            'dados' => json_encode($dados),
            'usuario_id' => $usuario_id
        ];
        $this->db->insert('logs', $log_data);
    }
}
?>
