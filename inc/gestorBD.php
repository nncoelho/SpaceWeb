<?php
    //======================================================================================
    // Gestor | Gestor da Base de Dados - MySQL - PDO - CRUD
    //======================================================================================

    class cl_gestorBD{
        
        //==================================================================
        public function EXE_QUERY($query, $parametros = NULL, $fechar_ligacao = TRUE)
        {
            // Executa a Query à Base de Dados (SELECT)
            $resultados = NULL;

            $config = include('config.php');

            // Abre a Ligação à Base de Dados
            $ligacao = new PDO(
                'mysql:host='.$config['BD_HOST'].
                ';dbname='.$config['BD_DATABASE'].
                ';charset='.$config['BD_CHARSET'],
                $config['BD_USERNAME'],
                $config['BD_PASSWORD'],
                array(PDO::ATTR_PERSISTENT => TRUE));
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Executa a Query
            if ($parametros != NULL) {
                $gestor = $ligacao->prepare($query);
                $gestor->execute($parametros);
                $resultados = $gestor->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $gestor = $ligacao->prepare($query);
                $gestor->execute();
                $resultados = $gestor->fetchAll(PDO::FETCH_ASSOC);
            }

            // Fecha a Ligação por defeito
            if ($fechar_ligacao) {
                $ligacao = NULL;
            }

            // Retorna os resultados
            return $resultados;
        }

        //==================================================================
        public function EXE_NON_QUERY($query, $parametros = NULL, $fechar_ligacao = TRUE)
        {
            // Executa uma Query com ou sem Parâmetros (INSERT, UPDATE, DELETE)

            $config = include('config.php');

            // Abre a Ligação à Base de Dados
            $ligacao = new PDO(
                'mysql:host='.$config['BD_HOST'].
                ';dbname='.$config['BD_DATABASE'].
                ';charset='.$config['BD_CHARSET'],
                $config['BD_USERNAME'],
                $config['BD_PASSWORD'],
                array(PDO::ATTR_PERSISTENT => TRUE));
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Executa a Query
            $ligacao->beginTransaction();
            try {
                if ($parametros != NULL) {
                    $gestor = $ligacao->prepare($query);
                    $gestor->execute($parametros);
                } else {
                    $gestor = $ligacao->prepare($query);
                    $gestor->execute();
                }
                $ligacao->commit();
            } catch (PDOException $e) {
                echo '<p>' . $e . '</p>';
                $ligacao->rollBack();
            }

            // Fecha a Ligação por defeito
            if ($fechar_ligacao) {
                $ligacao = NULL;
            }
        }

        //==================================================================
        public function RESET_AUTO_INCREMENT($tabela){
            
            // Faz Reset ao Auto_Increment de uma determinada tabela ($tabela)
            $config = include('config.php');

            // Abre a Ligação à Base de Dados
            $ligacao = new PDO(
                'mysql:host='.$config['BD_HOST'].
                ';dbname='.$config['BD_DATABASE'].
                ';charset='.$config['BD_CHARSET'],
                $config['BD_USERNAME'],
                $config['BD_PASSWORD'],
                array(PDO::ATTR_PERSISTENT => TRUE));
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Reset ao Auto_Increment
            $ligacao->exec('ALTER TABLE '.$tabela.' AUTO_INCREMENT = 1');

            // Fecha a Ligação
            $ligacao = NULL;
        }    
    }
?>