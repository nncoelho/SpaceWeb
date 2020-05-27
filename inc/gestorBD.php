<?php
    //====================================================================
    // GESTOR DA BASE DE DADOS - MYSQL - PDO - CRUD
    //====================================================================

    class cl_gestorBD{
        
        //================================================================
        public function EXE_QUERY($query, $parametros = NULL, $fechar_ligacao = TRUE)
        {
            // EXECUTA A QUERY A BASE DE DADOS (READ/SELECT)
            $resultados = NULL;

            $config = include('config.php');

            // ABRE A LIGAÇÃO A BASE DE DADOS
            $ligacao = new PDO(
                'mysql:host='.$config['BD_HOST'].
                ';dbname='.$config['BD_DATABASE'].
                ';charset='.$config['BD_CHARSET'],
                $config['BD_USERNAME'],
                $config['BD_PASSWORD'],
                array(PDO::ATTR_PERSISTENT => TRUE));
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // EXECUTA A QUERY
            if ($parametros != NULL) {
                $gestor = $ligacao->prepare($query);
                $gestor->execute($parametros);
                $resultados = $gestor->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $gestor = $ligacao->prepare($query);
                $gestor->execute();
                $resultados = $gestor->fetchAll(PDO::FETCH_ASSOC);
            }

            // FECHA A LIGAÇÃO POR DEFEITO
            if ($fechar_ligacao) {
                $ligacao = NULL;
            }

            // RETORNA OS RESULTADOS
            return $resultados;
        }

        //================================================================
        public function EXE_NON_QUERY($query, $parametros = NULL, $fechar_ligacao = TRUE)
        {
            // EXECUTA UMA QUERY COM OU SEM PARÂMETROS (CREATE/INSERT, UPDATE, DELETE)
            $config = include('config.php');

            // ABRE A LIGAÇÃO A BASE DE DADOS
            $ligacao = new PDO(
                'mysql:host='.$config['BD_HOST'].
                ';dbname='.$config['BD_DATABASE'].
                ';charset='.$config['BD_CHARSET'],
                $config['BD_USERNAME'],
                $config['BD_PASSWORD'],
                array(PDO::ATTR_PERSISTENT => TRUE));
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // EXECUTA A QUERY
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

            // FECHA A LIGAÇÃO POR DEFEITO
            if ($fechar_ligacao) {
                $ligacao = NULL;
            }
        }

        //================================================================
        public function RESET_AUTO_INCREMENT($tabela){
            
            // FAZ RESET AO AUTO_INCREMENT DE UMA DETERMINADA TABELA ($TABELA)
            $config = include('config.php');

            // ABRE A LIGAÇÃO A BASE DE DADOS
            $ligacao = new PDO(
                'mysql:host='.$config['BD_HOST'].
                ';dbname='.$config['BD_DATABASE'].
                ';charset='.$config['BD_CHARSET'],
                $config['BD_USERNAME'],
                $config['BD_PASSWORD'],
                array(PDO::ATTR_PERSISTENT => TRUE));
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // RESET AO AUTO_INCREMENT
            $ligacao->exec('ALTER TABLE '.$tabela.' AUTO_INCREMENT = 1');

            // FECHA A LIGAÇÃO
            $ligacao = NULL;
        }    
    }
?>