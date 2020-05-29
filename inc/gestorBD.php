<?php
    //=======================================================================
    // CLASSE GESTORA DA BASE DE DADOS - MYSQL - PDO - CRUD
    //=======================================================================
    class Gestor{
            
        private $db_server = 'localhost';
        private $db_name = 'spaceweb';
        private $db_charset = 'utf8';
        private $db_username = 'root';
        private $db_password = '';

        //===================================================================
        // CRUD - CREATE READ UPDATE DELETE
        //===================================================================
        public function EXE_QUERY($query, $parameters = null, $debug = true, $close_connection = true){

            // EXECUTA A CONEXÃO A DATABASE (READ/SELECT)
            $results = null;

            // CONEXÃO
            $connection = new PDO(
                'mysql:host='.$this->db_server.
                ';dbname='.$this->db_name.
                ';charset='.$this->db_charset,
                $this->db_username,
                $this->db_password,
                array(PDO::ATTR_PERSISTENT => true));      
                
            if($debug){
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }

            // EXECUÇÃO
            try {
                if ($parameters != null) {
                    $gestor = $connection->prepare($query);
                    $gestor->execute($parameters);
                    $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $gestor = $connection->prepare($query);
                    $gestor->execute();
                    $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {        
                return false;
            }

            // FECHA CONEXÃO
            if ($close_connection) {
                $connection = null;
            }

            // RETORNA RESULTADOS
            return $results;
        }

        //===================================================================
        public function EXE_NON_QUERY($query, $parameters = null, $debug = true, $close_connection = true){

            // EXECUTA A QUERY A DATABASE (CREATE/INSERT, UPDATE, DELETE)

            // CONEXÃO
            $connection = new PDO(
                'mysql:host='.$this->db_server.
                ';dbname='.$this->db_name.
                ';charset='.$this->db_charset,
                $this->db_username,
                $this->db_password,
                array(PDO::ATTR_PERSISTENT => true));   

            if($debug){
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
            
            // EXECUÇÃO
            $connection->beginTransaction();
            try {
                if ($parameters != null) {
                    $gestor = $connection->prepare($query);
                    $gestor->execute($parameters);
                } else {
                    $gestor = $connection->prepare($query);
                    $gestor->execute();
                }
                $connection->commit();
            } catch (PDOException $e) {            
                $connection->rollBack();
                return false;
            }

            // FECHA CONEXÃO
            if ($close_connection) {
                $connection = null;
            }
            
            return true;
        }
    }
?>