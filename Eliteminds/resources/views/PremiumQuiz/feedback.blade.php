<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <style>
            .wrapper {
                max-width: 500px;
                height: auto;
                border: 1px solid #ccc;
                border-radius: 3px;
                margin: 20px;
                padding: 10px;
            }
            .wrapper p {
                font-weight: bold;
                color: black;
            }
            body, html{     
                /* Prevent selection */
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;  
            }
        </style>
    </head>
    <body>
        <div class="container prsc-msg" style=" display:none; background: #fff; color: red; padding: 20px; min-width:100px; min-height: 40px; margin: 30px auto;">
            <div class="row" style="padding: 20px;">
                This action is not allowed , if you attempt to take this action again your account will be blocked !<br/><br/>
                please Click (Go Back)
    
            </div>
            <div class="row" style="padding: 20px;">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 Go Back </a>
            </div>
        </div>
        <div class="wrapper">
            <div class="title">
                <h3>Explanation: </h3>    
            </div>    
            <p>
                {!! $feedback !!}
            </p>
        </div>  
        <script>
            
            $(window).keyup(function(e){
                if(e.keyCode == 44){
                    $(".wrapper").hide();
                    $(".prsc-msg").show();
                }
            });
            
            
        </script>
    </body>
</html>
