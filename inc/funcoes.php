<?php 
    //=========================================
    // FUNÇÕES ESTÁTICAS
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    }

    class funcoes{

        // =======================================================
        public static function VerificarLogin(){
            // VERIFICA SE O UTILIZADOR TEM SESSÃO ATIVA
            $resultado = false;
            if(isset($_SESSION['id_utilizador'])){
                $resultado = true;
            }
            return $resultado;
        }

        // =======================================================
        public static function VerificarLoginCliente(){
            // VERIFICA SE O CLIENTE TEM SESSÃO ATIVA
            $resultado = false;
            if(isset($_SESSION['id_cliente'])){
                $resultado = true;
            }
            return $resultado;
        }

        // =======================================================
        public static function IniciarSessao($dados){
            // INICIA A SESSÃO
            $_SESSION['id_utilizador'] = $dados[0]['id_utilizador'];
            $_SESSION['nome'] = $dados[0]['nome'];
            $_SESSION['email'] = $dados[0]['email'];
            $_SESSION['permissoes'] = $dados[0]['permissoes'];
        }

        // =======================================================
        public static function IniciarSessaoCliente($dados){
            // INICIA A SESSÃO DO CLIENTE
            $_SESSION['id_cliente'] = $dados[0]['id_cliente'];
            $_SESSION['nome_cliente'] = $dados[0]['nome'];
            $_SESSION['email_cliente'] = $dados[0]['email'];
        }

        // =======================================================
        public static function DestroiSessao(){
            // DESTROI AS VARIÁVEIS DA SESSÃO
            unset($_SESSION['id_utilizador']);
            unset($_SESSION['nome']);
            unset($_SESSION['email']);
            unset($_SESSION['permissoes']);
        }

        // =======================================================
        public static function DestroiSessaoCliente(){
            // DESTROI AS VARIÁVEIS DA SESSÃO DO CLIENTE
            unset($_SESSION['id_cliente']);
            unset($_SESSION['nome_cliente']);
            unset($_SESSION['email_cliente']);
        }

        // =======================================================
        public static function CriarCodigoAlfanumerico($numChars){
            // CRIA UM CÓDIGO ALEATÓRIO ALFANUMÉRICO PARA SER USADO NA RECUPERAÇÂO DA PASSWORD
            $codigo='';
            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?()-%';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0,strlen($caracteres)) ,1);
            }
            return $codigo;
        }

        // =======================================================
        public static function CriarCodigoAlfanumericoSemSinais($numChars){
            // CRIA UM CÓDIGO ALEATÓRIO ALFANUMÉRICO SEM SINAIS PARA SER USADO NA RECUPERAÇÂO DA PASSWORD
            $codigo='';
            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0,strlen($caracteres)) ,1);
            }
            return $codigo;
        }

        // =======================================================
        public static function CriarLOG($mensagem, $utilizador){
            // CRIA UM REGISTO EM LOGS
            $gestor = new Gestor();
            $data_hora = new DateTime();
            $parametros = [
                ':data_hora'        => $data_hora->format('Y-m-d H:i:s'),
                ':utilizador'       => $utilizador,
                ':mensagem'         => $mensagem
            ];
            $gestor->EXE_NON_QUERY(
                'INSERT INTO logs(data_hora, utilizador, mensagem)
                 VALUES(:data_hora, :utilizador, :mensagem)', $parametros);
        }

        // =======================================================
        public static function Permissao($index){
            // VERIFICA SE O UTILIZADOR COM SESSÃO ATIVA TEM PERMISSÃO PARA A FUNCIONALIDADE
            if(substr($_SESSION['permissoes'], $index, 1) == 1){
                return true;
            } else{
                return false;
            }
        }

        // =======================================================
        public static function Paginacao($source, $pagina_atual, $itens_por_pagina, $total_itens){
            // CRIA E CONTROLA O MECANISMO DE PAGINÇÃO E RESPECTIVA NAVEGAÇÃO
            $max_paginas = floor($total_itens/$itens_por_pagina);

            echo '<div>';

            // PAGINA ANTERIOR
            if($pagina_atual == 1){
                echo '«';
            } else {
                echo '<a href="' .$source. '&p=' .($pagina_atual - 1). '">«</a>';
            }

            echo ' | ';

            // PAGINA SEGUINTE
            if($pagina_atual == $max_paginas){
                echo '»';
            } else {
                echo '<a href="' .$source. '&p=' .($pagina_atual + 1). '">»</a>';
            }

            echo '</div>';
        }
    }
?>