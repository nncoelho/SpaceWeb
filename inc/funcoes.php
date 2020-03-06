<?php 
    //========================================
    // Funções Estáticas
    //========================================

    // Verificar a Sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    class funcoes{

        // =======================================================
        public static function VerificarLogin(){
            // Verifica se o Utilizador tem Sessão Ativa
            $resultado = false;
            if(isset($_SESSION['id_utilizador'])){
                $resultado = true;
            }
            return $resultado;
        }

        // =======================================================
        public static function VerificarLoginCliente(){
            // Verifica se o Cliente tem Sessão Ativa
            $resultado = false;
            if(isset($_SESSION['id_cliente'])){
                $resultado = true;
            }
            return $resultado;
        }

        // =======================================================
        public static function IniciarSessao($dados){
            // Iniciar a Sessão
            $_SESSION['id_utilizador'] = $dados[0]['id_utilizador'];
            $_SESSION['nome'] = $dados[0]['nome'];
            $_SESSION['email'] = $dados[0]['email'];
            $_SESSION['permissoes'] = $dados[0]['permissoes'];
        }

        // =======================================================
        public static function IniciarSessaoCliente($dados){
            // Iniciar a Sessão do Cliente
            $_SESSION['id_cliente'] = $dados[0]['id_cliente'];
            $_SESSION['nome_cliente'] = $dados[0]['nome'];
            $_SESSION['email_cliente'] = $dados[0]['email'];
        }

        // =======================================================
        public static function DestroiSessao(){
            // Destroi as variáveis da Sessão
            unset($_SESSION['id_utilizador']);
            unset($_SESSION['nome']);
            unset($_SESSION['email']);
            unset($_SESSION['permissoes']);
        }

        // =======================================================
        public static function DestroiSessaoCliente(){
            // Destroi as variáveis da Sessão do Cliente
            unset($_SESSION['id_cliente']);
            unset($_SESSION['nome_cliente']);
            unset($_SESSION['email_cliente']);
        }

        // =======================================================
        public static function CriarCodigoAlfanumerico($numChars){
            // Cria um Código Aleatório Alfanumérico
            $codigo='';
            $caracteres = 'abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ0123456789!?()-%';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0,strlen($caracteres)) , 1 );
            }
            return $codigo;
        }

        // =======================================================
        public static function CriarCodigoAlfanumericoSemSinais($numChars){
            // Cria um Código Aleatório Alfanumérico
            $codigo='';
            $caracteres = 'abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ0123456789';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0,strlen($caracteres)) , 1 );
            }
            return $codigo;
        }

        // =======================================================
        public static function CriarLOG($mensagem, $utilizador){
            // Cria um registo em LOGS
            $gestor = new cl_gestorBD();
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
            // Verifica se o Utilizador com Sessão Ativa tem Permissão para a funcionalidade
            if(substr($_SESSION['permissoes'], $index, 1) == 1){
                return true;
            } else{
                return false;
            }
        }
    }
?>