<?php 
    //=========================================
    // CLASSE PARA TRATAMENTO DE DATAS
    //=========================================
    class Datas{
        public static function DataHoraAtualBD(){
            // RETORNA A DATA E HORA ATUAL FORMATADA
            $data = new DateTime();
            return $data->format('Y-m-d H:i:s');
        }
    }
