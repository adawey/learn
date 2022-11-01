<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vimeo | {{env('APP_NAME')}}</title>
</head>
<body style="width: 100vw; height: 100vh;">
<iframe id="player1" src="https://player.vimeo.com/video/{{$vimeo_id}}?api=1&player_id=player1" width="100%" height="98%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
</body>
</html>
