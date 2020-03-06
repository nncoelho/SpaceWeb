<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    class emails{
        
        public function EnviarEmail($dados){

            // Dados[0] = Endereço de Email do Destinatário
            // Dados[1] = Assunto
            // Dados[2] = Mensagem
            require '../phpmailer/src/Exception.php';
            require '../phpmailer/src/PHPMailer.php';
            require '../phpmailer/src/SMTP.php';

            // Configurações
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

            // Email
            $mail->Password = $configs['MAIL_PASSWORD'];
            $mail->setFrom ($configs['MAIL_FROM'], 'spaceweb');
            $mail->addAddress($dados[0], $dados[0]);
            $mail->CharSet = "UTF-8";

            // Assunto
            $mail->Subject = $dados[1];

            // Mensagem
            $mail->Body = $dados[2];               

            // Envio da Mensagem
            $enviada = false;
            if($mail->send()){ $enviada = true; }
            return $enviada;
        }
                
        // =========================================================
        public function EnviarEmailCliente($dados){

            // Dados[0] = Endereço de Email do Cliente
            // Dados[1] = Assunto
            // Dados[2] = Mensagem
            require 'phpmailer/src/Exception.php';
            require 'phpmailer/src/PHPMailer.php';
            require 'phpmailer/src/SMTP.php';

            // Configurações
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

            // Email
            $mail->Password = $configs['MAIL_PASSWORD'];
            $mail->setFrom ($configs['MAIL_FROM'], 'spaceweb');
            $mail->addAddress($dados[0], $dados[0]);
            $mail->CharSet = "UTF-8";

            // Assunto
            $mail->Subject = $dados[1];

            // Mensagem
            $mail->Body = $dados[2];               

            // Envio da Mensagem
            $enviada = false;
            if($mail->send()){ $enviada = true; }
            return $enviada;
        }
    }
?>