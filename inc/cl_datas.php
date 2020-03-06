<?php 
    //=================================
    // Classe para tratamento de Datas
    //=================================

    class DATAS{
        
        public static function DataHoraAtualBD(){
            // Retorna a Data e Hora atual formatada para MySQL
            $data = new DateTime();
            return $data->format('Y-m-d H:i:s');
        }
    }
?>