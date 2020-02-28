<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Document</title>
      <style>
          h1{
              font-size:30px;
              margin: 30px;
          }
          p{
              font-size:20px;
              margin-top: 30px;
              color: #8f8e8e;
          }
          .contenedor{
              font-family: Arial, Helvetica, sans-serif;
              text-align: center;
              max-width: 400px;
              margin: 0 auto;
              border: 1px solid #cccccc;
          }
          .boton{
              color: #ffffff;
              background-color: #FF6705;
              padding:15px 35px;
              border: none;
              border-radius: 50px;
              margin: 40px 0;
              font-size: 20px;
          }
          .boton:hover{
              background-color: #FF8605;
              cursor: pointer;
          }
      </style>
  </head>
  <body>
      <div class="contenedor">

          <h1>Bienvenido a Orange 2</h1>
          <h2>Saludos {{ $user->name }} {{ $user->last_name }}</h2>
          <p>Gracias por registrarte!
              Haz click en el siguiente enlace para continuar con el proceso de registro.
          </p>
          <center><span style="color: #8f8e8e;">CODIGO: <b style="color:black;"><?=$user->verify_token?></b></span></center>

          <a href="<?='https://'.$frontendURL.'/#/confirm?token='.$user->verify_token?>" ><button class="boton">Confirma tu correo</button></a>
      </div>
  </body>
</html>
