<html>
<head></head>
<body>
  <div style="background:#ededed;border:1px solid grey;border-radius:2px;padding:5px;text-align:justify;font-family:monospace;">
    <h1>{{$title}} - {{ $user }}</h1>
    <p>Message envoyé le : {{ date('d/m/Y à G:i:s') }}</p>
    @if(copie){
      <p>Copie de votre demande de contact</p>
    }
    <p style="max-width: 500px;font-size:20px;">
      {{$content}}
    </p>
  </div>
</body>
</html>
