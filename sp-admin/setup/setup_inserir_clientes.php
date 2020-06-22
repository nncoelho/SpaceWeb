<?php 
    //=========================================
    // SETUP - INSERIR CLIENTES
    //=========================================

    // VERIFICA A SESSÃO
    if(!isset($_SESSION['a'])){
        exit();
    } 

    //=========================================
    // CLIENTES FICTICIOS
    //=========================================
    $nomes_homem = [
        'Nuno','Jorge','Ruben','Miguel','Marco','Rui','Paulo','Amilcar','Carlos','Alberto',
        'Joaquim','Joao','Luis','Mario','Rogerio','Fernando','Andre','Diogo','Americo','Rodrigo'
    ];
    $nomes_mulher = [
        'Vera','Rita','Sofia','Ana','Teresa','Sandra','Laura','Carolina','Sonia','Patricia',
        'Isabel','Carla','Mariana','Mafalda','Catarina','Fernanda','Paula','Elsa','Luciana','Luisa'
    ];
    $apelidos = [
        'Coelho','Matos','Moita','Feliciano','Marques','Gomes','Santos','Rodrigues','Silva','Carvalho',
        'Monteiro','Barros','Oliveira','Teixiera','Azevedo','Raimundo','Dias','Duarte','Albino','Ribeiro'
    ];

    //=========================================
    // ACESSO A BASE DE DADOS
    //=========================================
    $gestor = new Gestor();
    $numero_clientes = 50;

    // LIMPA OS DADOS DOS CLIENTES E ZERA O AUTO_INCREMENT
    $gestor->EXE_NON_QUERY('DELETE FROM clientes');
    $gestor->EXE_NON_QUERY('ALTER TABLE clientes AUTO_INCREMENT = 1');

    // MECANISMO PARA GERAR CLIENTES FICTCIOS
    for($i = 0; $i < $numero_clientes; $i++){

        // DEFINE O GENERO (MASCULINO OU FEMININO)
        $genero = rand(1,2);

        // DEFINE O NOME DO CLIENTE
        $nome = '';
        if($genero == 1){
            $nome = $nomes_homem[rand(0,count($nomes_homem)-1)] . ' ' . $apelidos[rand(0,count($apelidos)-1)];
        } else {
            $nome = $nomes_mulher[rand(0,count($nomes_mulher)-1)] . ' ' . $apelidos[rand(0,count($apelidos)-1)];
        }

        // CRIA O EMAIL FICTICIO DO CLIENTE
        $email_temp = strtolower(substr($nome,0,10)) . rand(1980,2010) . "@gmail.com";
        $email = str_replace(' ','.',$email_temp);

        // CRIA UM NOME DE UTILIZADOR(USERNAME) DO CLIENTE
        $utilizador_temp = strtolower(substr($nome,0,6)) . rand(1000,9999);
        $utilizador = str_replace(' ','',$utilizador_temp);

        // PASSWORD GERAL DOS CLIENTES FICTICIOS
        $palavra_passe = md5('abc123');

        $codigo_validacao = funcoes::CriarCodigoAlfanumericoSemSinais(30);
        $validada = 1;

        // INSERIR NA BASE DE DADOS
        $data = new DateTime();
        $parametros = [
            ':nome'                 => $nome,
            ':email'                => $email,
            ':utilizador'           => $utilizador,
            ':palavra_passe'        => $palavra_passe,
            ':codigo_validacao'     => $codigo_validacao,
            ':validada'             => 1,
            ':criado_em'            => $data->format('Y-m-d H:i:s'),
            ':atualizado_em'        => $data->format('Y-m-d H:i:s')
        ];

        $gestor->EXE_NON_QUERY('INSERT INTO clientes(nome, email, utilizador, palavra_passe, codigo_validacao, validada, criado_em, atualizado_em)
                                VALUES(:nome, :email, :utilizador, :palavra_passe, :codigo_validacao, :validada, :criado_em, :atualizado_em)',
        $parametros);
    }
?>

<div class="alert alert-success text-center"><?php echo $numero_clientes ?> Clientes inseridos com sucesso.</div>