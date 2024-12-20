<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once './conexao.php';
require './lib/vendor/autoload.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS exclusivo -->
    <link rel="stylesheet" href="./css/estilo.css">

    <title>Motive Gym</title>
</head>

<body>
    <nav>
        <a href="#">Inicio</a>
        <a href="#planos">Planos</a>
        <a href="#rede">Conheça nossa rede</a>
        <a href="#contato">Entre em contato</a>
    </nav>

    <header>
        <h2>Bem-vindo à Motive Gym</h2>
        <h4>Motive-se! Supere-se!</h4>
        <button class="animacaoBotao2">Inscreva-se agora!</button>
    </header>

    <main>
        <!-- Seção de Planos -->
        <section id="planos">
            <h2>Escolha o plano mais vantajoso</h2>
            <div class="planos-container">
                <!-- Plano Básico -->
                <div class="plano">
                    <h3>Plano Básico</h3>
                    <p>R$ 99,90/mês</p>
                    <ul>
                        <li>12 meses de fidelidade</li>
                        <li>App de treinos</li>
                        <li>Área de musculação e aeróbicos</li>
                    </ul>
                    <button class="animacaoBotao3">Assine</button>
                </div>

                <!-- Plano Premium -->
                <div class="plano">
                    <h3>Plano Premium</h3>
                    <p>R$ 149,90/mês</p>
                    <ul>
                        <li>Sem fidelidade</li>
                        <li>App de treinos</li>
                        <li>Área de musculação e aeróbicos</li>
                    </ul>
                    <button class="animacaoBotao3">Assine</button>
                </div>

                <!-- Plano VIP -->
                <div class="plano">
                    <h3>Plano VIP</h3>
                    <p>R$ 199,90/mês</p>
                    <ul>
                        <li>12 meses de fidelidade</li>
                        <li>Leve 5 amigos por mês para treinar</li>
                        <li>Cadeira de massagem</li>
                        <li>Acesso ilimitado a nossa rede de academias</li>
                        <li>Treino online</li>
                        <li>Aulas coletivas</li>
                        <li>App de treinos</li>
                        <li>Área de musculação e aeróbicos</li>
                    </ul>
                    <button class="animacaoBotao3">Assine</button>
                </div>
            </div>
        </section>

        <!-- Seção conheça nossa rede -->
        <section id="rede">
            <div id="conteudoRede">
                <p>Somos uma academia inovadora que busca proporcionar um ambiente motivador para todas as idades e níveis de condicionamento físico. Nossa missão é ajudá-lo a alcançar seus objetivos, superar seus limites e transformar sua vida!</p>
                <br>
                <div class="carrossel">
                    <div class="container" id="img">
                        <img src="./img/1024px/imagem5_1024.jpg" alt="">
                        <img src="./img/1024px/imagem4_1024.jpg" alt="">
                        <img src="./img/1024px/imagem3_1024.jpg" alt="">
                        <img src="./img/1024px/imagem2_1024.jpg" alt="">
                    </div>
                </div>
                <br>
            </div>
        </section>

        <!-- Conheça nossa rede / Fale Conosco -->
        <section id="contato">
            <h3>Fale Conosco</h3>
            <hr>
            <div id="conteudoContato">

                <?php
                $dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if (!empty($dadosForm['btnEnviarMsg'])) {
                    //var_dump($dadosForm);
                    $query_msg = "INSERT INTO fale_conosco (nome, email, tipo_pessoa, mensagem, criacao) 
                        VALUES (:nome, :email, :tipo_pessoa, :mensagem, NOW())";
                    $salvarMsg = $conn->prepare($query_msg);
                    $salvarMsg->bindParam(':nome', $dadosForm['nome']);
                    $salvarMsg->bindParam(':email', $dadosForm['email']);
                    $salvarMsg->bindParam(':tipo_pessoa', $dadosForm['gridRadios']);
                    $salvarMsg->bindParam(':mensagem', $dadosForm['mensagem']);

                    $salvarMsg->execute();

                    if ($salvarMsg->rowCount()) {
                        $mail = new PHPMailer(true);


                        try {
                            //Server settings
                            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //descomentar DEBUG para testar
                            $mail->CharSet = 'UTF-8';
                            $mail->isSMTP();
                            $mail->Host = 'sandbox.smtp.mailtrap.io';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'fc6e420573e429';
                            $mail->Password = 'e622bb4d67dc04';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                            $mail->Port       = 587;

                            //Recipients
                            $mail->setFrom('dev.wmauriciu@gmail.com', 'dev.WMauriciu');
                            $mail->addAddress($dadosForm['email'], $dadosForm['nome']);     //Add a recipient

                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Salvando no banco e disparando email';
                            //$mail->Body    = 'Boa tarde, Mau <br> Segue solicitação para  <b>embarque!</b>.<br>Texto da segunda linha.';
                            $mail->Body    =  "Prezado(a) ". $dadosForm['nome']  ."<br><br> Acuso recebimento de seu e-mail.<br>Responderei o mais breve possível.<br><br>" . $dadosForm['gridRadios'] . "<br><br> Mensagem:<br>" . $dadosForm['mensagem'];
                            $mail->AltBody =  "Prezado(a) ". $dadosForm['nome']  ."\n\n Acuso recebimento de seu e-mail.\nResponderei o mais breve possível.\n\n" . $dadosForm['gridRadios'] . "\n\n Mensagem:\n" . $dadosForm['mensagem'];

                            $mail->send();
                            unset($dadosForm);

                            echo "Mensagem de contato enviada com sucesso!<br>";
                        } catch (Exception $ex) {
                            //echo "ERRO: Mensagem de contato não pode ser enviado. Error PHPMailer: $mail->ErrorInfo}";
                            echo "ERRO: Mensagem de contato não pode ser enviada.";
                        }
                    } else {
                        echo "ERRO: Não foi possível enviar a mensagem!";
                    }
                }
                ?>

                <form name="addMensagem" action="" method="POST">
                    <div class="form-group row">
                        <label for="nome" class="col-sm-2 col-form-label">Nome</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required value="<?php if(isset($dadosForm['nome'])){ echo $dadosForm['nome'];} ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="<?php if(isset($dadosForm['email'])){ echo $dadosForm['email'];} ?>">
                        </div>
                    </div>
                    <fieldset class="form-group">
                        <div class="row">

                            <div class="row mx-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="naoCliente" value="naoCliente" required value="<?php if(isset($dadosForm['gridRadios'])){ echo $dadosForm['gridRadios'];} ?>">
                                    <label class="form-check-label" for="naoCliente" id="radio1">
                                        Não sou cliente
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="souCliente" value="souCliente" required value="<?php if(isset($dadosForm['gridRadios'])){ echo $dadosForm['gridRadios'];} ?>">
                                    <label class="form-check-label" for="souCliente" id="radio2">
                                        Sou cliente
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="Personal" value="Personal" disabled value="<?php if(isset($dadosForm['gridRadios'])){ echo $dadosForm['gridRadios'];} ?>">
                                    <label class="form-check-label" for="Personal" id="radio3">
                                        Personal
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="mensagem">Mensagem</label>
                        <textarea class="col-sm-10 form-control" id="mensagem" name="mensagem" rows="5" maxlength="500" placeholder="Escreva sua mensagem aqui" required value="<?php if(isset($dadosForm['mensagem'])){ echo $dadosForm['mensagem'];} ?>"></textarea>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4">
                            <button type="reset" class="btn btn btn-danger">Limpar</button>
                            <button type="submit" class="btn btn-success" name="btnEnviarMsg" value="EnviarMsg">Enviar</button>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </main>

    <footer>
        <div>
            <span>Siga a Motive Gym nas redes sociais</span>
        </div>
        <div>
            <a href="http://www.instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="http://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="http://www.youtube.com" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="http://www.messenger.com" target="_blank"><i class="bi bi-messenger"></i></a>
            <a href="http://web.whatsapp.com" target="_blank"><i class="bi bi-whatsapp"></i></a>

        </div>
    </footer>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="./js/script.js" defer></script>
</body>

</html>