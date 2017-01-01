<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
      html,
      body{
        position: relative;
        width: 100%;
        height: 100%;
        margin: 0;
        background: #f5f1f1;
        font-family: 'Lato';
        font-weight: bold;
      }
      .error{
        text-align: center;
        vertical-align: middle;
        padding: 20% 0 0 0;
        font-size: 40px;
      }
      .error a{
        font-size: 20px;
        color: dimgrey;
        text-decoration: none;
      }
      .error a:hover{
        color: #404040;
      }
      .error span{
        font-size: 20px;
      }
    </style>
  </head>
  <body>
    <div class="error">
      Erreur 404<br/>
      <span>Retourne d'où tu viens !</span><br/>
      <a href="{{ url('/') }}">Retour à l'accueil</a>
    </div>
  </body>
</html>
