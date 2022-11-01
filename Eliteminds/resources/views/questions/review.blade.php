
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
    </head>

    <body>
        <div class="container" id="app-1" style="margin-top: 40px;">
                <div class="row">
                    <div class="col-md-10 mx-auto form-1" >
                        <div class="container" id="quiz" >
                                {{-- style="display:none;" --}}
                            <div class="row st-row">
                                <div class="col-md-3 justify-content-center align-self-center">questions <strong>#</strong> of <strong>#</strong></div>
                                <div class="col-md-3 justify-content-center align-self-center"> Answerd <strong> # </strong></div>
                                
                                <div class="col-md-3 justify-content-center align-self-center" id="timer">00:00:00</div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12 question-text" style="background-color: #e8ebef;">
                                    {{$title}}
                                </div>
                                
                                <div class="fig" id="fig" style = "margin: 0 0 10px 50px;">
                                    <img src="http://via.placeholder.com/250x150?text=IMG" alt="fig0-0">
                                </div>
                            </div>
                            <div class="container" >
                                <div class="radio" id="radio1">
                                    <label ><input v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt1'>{{$a}}</label>
                                </div>
                                <div class="radio" id="radio2">
                                    <label ><input v-on:click="answerd_counter" type="radio" name="optradio"  v-model="rad" v-bind:value='opt2'>{{$b}}</label>
                                </div>
                                <div class="radio" id="radio3">
                                    <label ><input v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt3'>{{$c}}</label>
                                </div>
                                <div class="radio" id="radio4">
                                    <label ><input v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt4'>{{$d}}</label>
                                </div>
                            </div>
                            
                            <div class="row contral-question" >
                                <div class="col-lg-2">
                                    <a class="btn btn-outline-primary" id="prev" v-on:click="prev">Prev</a>
                                </div>
                                <div class="col-lg-2">
                                    <a class="btn btn-outline-primary" id="next" v-on:click="next">Next</a>
                                </div>
                                
                            </div>
                        </div>       
                    </div> 
                </div>
            </div>
        </div>
    </body>
</html>
