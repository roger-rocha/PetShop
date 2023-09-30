<!DOCTYPE html>
<html>

<head>
    <title>Email com Botão</title>
    <style>
        /* Estilo para o contêiner do email */
        .email-container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        /* Estilo para o botão */
        .email-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            /* Cor azul */
            color: #fff;
            /* Cor do texto */
            text-decoration: none;
            border-radius: 5px;
            /* Bordas arredondadas */
        }

        /* Estilo para o texto no meio */
        .email-text {
            font-size: 16px;
            margin: 20px 0;
            color: white;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <p>Olá,</p>

        <p>Recebemos uma solicitação para redefinir a senha da sua conta. Se você não solicitou esta alteração, por
            favor, ignore este e-mail.</p>

        <p>Se deseja redefinir sua senha, siga as etapas abaixo:</p>

        <a href="{{ $urlToken }}" class="email-button">Clique aqui</a>

        <p>Lembre-se de escolher uma senha forte, com pelo menos oito caracteres, incluindo letras maiúsculas,
            minúsculas, números e caracteres especiais.</p>

        <p>Se você tiver algum problema ou dúvida, por favor, entre em contato conosco respondendo a este e-mail ou
            visitando nossa página de suporte em <strong>suporte@w2o.com.br</strong>.</p>

        <p>Obrigado por escolher nossos serviços!</p>

    </div>
</body>

</html>
