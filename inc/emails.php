<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    class emails{
        
        public function EnviarEmail($dados){

            // DADOS[0] = ENDEREÇO DE EMAIL DO DESTINATÁRIO
            // DADOS[1] = ASSUNTO
            // DADOS[2] = MENSAGEM
            require '../phpmailer/src/Exception.php';
            require '../phpmailer/src/PHPMailer.php';
            require '../phpmailer/src/SMTP.php';

            // CONFIGURAÇÕES
            $configs = include('config.php');
		
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );

            $mail->isHTML();
            $mail->SMTPDebug = $configs['MAIL_DEBUG'];
            $mail->Host = $configs['MAIL_HOST'];
            $mail->Port = $configs['MAIL_PORT'];
            $mail->SMTPAuth = true;
            $mail->Username = $configs['MAIL_USERNAME'];                        

            // EMAIL
            $mail->Password = $configs['MAIL_PASSWORD'];
            $mail->setFrom ($configs['MAIL_FROM'], 'spaceweb');
            $mail->addAddress($dados[0], $dados[0]);
            $mail->CharSet = "UTF-8";

            // ASSUNTO
            $mail->Subject = $dados[1];

            // MENSAGEM
            $mail->Body = $dados[2];               

            // ENVIO DA MENSAGEM
            $enviada = false;
            if($mail->send()){ $enviada = true; }
            return $enviada;
        }
                
        // =========================================================
        public function EnviarEmailCliente($dados){

            // DADOS[0] = ENDEREÇO DE EMAIL DO CLIENTE
            // DADOS[1] = ASSUNTO
            // DADOS[2] = MENSAGEM
            require 'phpmailer/src/Exception.php';
            require 'phpmailer/src/PHPMailer.php';
            require 'phpmailer/src/SMTP.php';

            // CONFIGURAÇÕES
            $configs = include('config.php');
		
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );

            $mail->isHTML();
            $mail->SMTPDebug = $configs['MAIL_DEBUG'];
            $mail->Host = $configs['MAIL_HOST'];
            $mail->Port = $configs['MAIL_PORT'];
            $mail->SMTPAuth = true;
            $mail->Username = $configs['MAIL_USERNAME'];

            // EMAIL
            $mail->Password = $configs['MAIL_PASSWORD'];
            $mail->setFrom ($configs['MAIL_FROM'], 'spaceweb');
            $mail->addAddress($dados[0], $dados[0]);
            $mail->CharSet = "UTF-8";

            // ASSUNTO
            $mail->Subject = $dados[1];

            // MENSAGEM
            $mail->Body = $dados[2];               

            // ENVIO DA MENSAGEM
            $enviada = false;
            if($mail->send()){ $enviada = true; }
            return $enviada;
        }
    }
?>