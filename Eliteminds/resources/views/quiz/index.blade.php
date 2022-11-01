<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Free Quiz Page</title>

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('indexassets/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/flaticon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('indexassets/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/video.min.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/lightbox.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/progess.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/responsive.css')}}">
    <link rel="stylesheet"  href="{{asset('indexassets/css/colors/switch.css')}}">
    <link href="{{asset('indexassets/css/colors/color-2.css')}}" rel="alternate stylesheet" type="text/css" title="color-2">
    <link href="{{asset('indexassets/css/colors/color-3.css')}}" rel="alternate stylesheet" type="text/css" title="color-3">
    <link href="{{asset('indexassets/css/colors/color-4.css')}}" rel="alternate stylesheet" type="text/css" title="color-4">
    <link href="{{asset('indexassets/css/colors/color-5.css')}}" rel="alternate stylesheet" type="text/css" title="color-5">
    <link href="{{asset('indexassets/css/colors/color-6.css')}}" rel="alternate stylesheet" type="text/css" title="color-6">
    <link href="{{asset('indexassets/css/colors/color-7.css')}}" rel="alternate stylesheet" type="text/css" title="color-7">
    <link href="{{asset('indexassets/css/colors/color-8.css')}}" rel="alternate stylesheet" type="text/css" title="color-8">
    <link href="{{asset('indexassets/css/colors/color-9.css')}}" rel="alternate stylesheet" type="text/css" title="color-9">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
<div id="preloader"></div>
<div id="switch-color" class="color-switcher">
    <div class="open"><i class="fas fa-cog fa-spin"></i></div>
    <h4>COLOR OPTION</h4>
    <ul>
        <li><a class="color-2" onclick="setActiveStyleSheet('color-2'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-3" onclick="setActiveStyleSheet('color-3'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-4" onclick="setActiveStyleSheet('color-4'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-5" onclick="setActiveStyleSheet('color-5'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-6" onclick="setActiveStyleSheet('color-6'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-7" onclick="setActiveStyleSheet('color-7'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-8" onclick="setActiveStyleSheet('color-8'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-9" onclick="setActiveStyleSheet('color-9'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
    </ul>
    <button class="switcher-light">WIDE </button>
    <button class="switcher-dark">BOX </button>
    <a class="rtl-v" href="RTL_Genius/index.html">RTL </a> </div>

<!-- Start of Header section
		============================================= -->
<header>
    <div id="main-menu"  class="main-menu-container">
        <div  class="main-menu">
            <div class="container">
                <div class="navbar-default">
                    <div class="navbar-header float-left"> <a class="navbar-brand text-uppercase" href="#">
                            <img src="{{asset('indexassets/img/logo/pmlogo2.png')}}" alt="logo" style="width: 250 px;height: 50px"></a> </div>
                    <div class="log-in float-right">
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal1" tabindex="-2" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header backgroud-style">
                                        <div class="gradient-bg"></div>
                                        <div class="popup-logo"> <img src="indexassets/img/logo/p-logo.jpg" alt=""> </div>
                                        <div class="popup-text text-center">
                                            <h2> <span>Sign Up and Start Learning!</span></h2>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>


                    <nav class="navbar-menu float-right">
                        <div class="nav-menu ul-li">
                            <ul>
                                <li><a href="{{route('index')}}">Home</a></li>
                                <li><a href="{{route('index')}}#search-course">Course</a></li>

                                <li class="menu-item-has-children ul-li-block">
                                    <a href="">Free Resource</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{route('FreeQuiz')}} ">Free Exam</a></li>
                                        <li><a href="{{route('FreeVideo')}}"> Free Video</a></li>

                                    </ul>
                                </li>
                                <li><a href="{{route('reviews')}}">Review</a></li>
                                <li><a href="{{route('index')}}#faq">faq</a></li>
                                <li><a href="{{route('index')}}#contact-area">Contact Us</a></li>
                                @if(Auth::guard('web')->check())
                                    <li><a href="{{route('user.dashboard')}}" title="dashboard"><i class="fas fa-asterisk"></i></a></li>

                                @elseif(Auth::guard('admin')->check())
                                    <li><a href="{{route('admin.dashboard')}}" title="dashboard"><i class="fas fa-asterisk"></i></a></li>
                                @else
                                    <li><a href="{{route('login')}}"><i class="fas fa-user"></i></a></li>
                                    <li><a href="{{route('register')}}" title="signup"><i class="fas fa-user-plus"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                    <!--start mobile-menu-->
                    <div class="mobile-menu">
                        <div class="logo"><a href="#"><img src="{{asset('indexassets/img/logo/pmlogo2.png')}}" alt="Logo"></a></div>
                        <nav>
                            <ul>
                                <li><a href="{{route('index')}}">Home</a></li>
                                <li><a href="{{route('index')}}#search-course">Course</a></li>

                                <li class="menu-item-has-children ul-li-block">
                                    <a href="">Free Resource</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{route('FreeQuiz')}} ">Free Exam</a></li>
                                        <li><a href="{{route('FreeVideo')}}"> Free Video</a></li>

                                    </ul>
                                </li>
                                <li><a href="{{route('reviews')}}">Review</a></li>
                                <li><a href="{{route('index')}}#faq">faq</a></li>
                                <li><a href="{{route('index')}}#contact-area">Contact Us</a></li>
                                @if(Auth::guard('web')->check())
                                    <li><a href="{{route('user.dashboard')}}" title="dashboard"><i class="fas fa-asterisk"></i></a></li>

                                @elseif(Auth::guard('admin')->check())
                                    <li><a href="{{route('admin.dashboard')}}" title="dashboard"><i class="fas fa-asterisk"></i></a></li>
                                @else
                                    <li><a href="{{route('login')}}">Login</a></li>
                                    <li><a href="{{route('register')}}" title="signup">SginUp</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Start of Header section
 		============================================= -->

<!-- Start of breadcrumb section
		============================================= -->
<section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
    <div class="blakish-overlay"></div>
    <div class="container">
        <div class="page-breadcrumb-content text-center">
            <div class="page-breadcrumb-title">
                <h2 class="breadcrumb-head black bold">Free Resource <span>Exam</span></h2>
            </div>
            <div class="page-breadcrumb-item ul-li">
                <ul class="breadcrumb text-uppercase black">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Exam</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End of breadcrumb section
		============================================= -->

<!-- Start FAQ section
		============================================= -->
<section id="faq-page" class="faq-page-section">
    <div class="container">
        <div class="faq-element">
            <div class="row">
                <div class="col-md-12">
                    <div class="faq-page-tab">
                        <div class="section-title-2 mb65 headline text-left">
                            <h2>Free Resource <span>Exam</span></h2>
                        </div>
                        <div class="faq-tab faq-secound-home-version mb35">
                            <div class="faq-tab-ques  ul-li">
                                <div id="tab2" class="tab-content-1 pt35" style="padding:0 !important;">
                                    <div class="container-fluid" id="app-1">
                                        <div class="row">
                                            <div class="col-md-12 form-1" >
                                                {{-- optimize Quiz Questions Form --}}
                                                {{--
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    --}}
                                                <form @submit.prevent="optimizeQuiz" id="optimizeForm" style="">
                                                    <div class="row" style="padding-top: 16px;">
                                                        <div class="col-lg-5">
                                                            <div class="form-group form-inline">
                                                                <strong><label for="type">Question Type : </label></strong>
                                                                <select name="type" id="type" v-model="question_type" v-on:change="reloadQuestionsNumber" class="form-control">
                                                                    <option v-for="i in question_type_list">@{{i}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <div class="form-group-form-inline" >
                                                                <strong><label for="num">Question Number : </label></strong>
                                                                <input type="number" min="1" v-bind:max="max_questions_num" id="num" class="form-control" v-model="question_num"><strong> /@{{max_questions_num}} questions</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <a v-on:click="optimizeQuiz" class="btn btn-primary" style="margin-top:23px; color:white;" >Start Quiz</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                {{-- Quiz View --}}
                                                {{--
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    *******************************
                                                    --}}

                                                <div class="container-fluid primeQuizViewWM" id="quiz" style="min-height: 50px; margin:20px 0; display:none;">
                                                    <div class="row" style=" ">
                                                        <div class="col-md-1" style="padding: 0 !important;">
                                                            <strong>@{{current_question_number}}</strong>/@{{q_number}}
                                                        </div>

                                                        <div class="col-md-9">
                                                            <div class="progress" style="border: 1px solid #ccc;">
                                                                <div class="progress-bar progress-bar-striped" id="progress_bar" role="progressbar" style="width: 10%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-1" style=" text-align: center;">
                                                            <div class="row" style="color: #333;  font-weight: lighter;" id="timer">00:00:00</div>
                                                        </div>


                                                        <div class="col-md-1" style="text-align: center; padding:0 !important;">


                                                            <a class="aElement" v-on:click="markExam">
                                                                <i class="fa fa-stop" style=""></i>
                                                            </a>
                                                        </div>

                                                    </div>

                                                    <hr>
                                                    <div class="row" style=" font-size: 21px; border-radius: 10px !important; background-color: #e8ebef; font-weight:bold; margin: 10px 0 20px 0;">
                                                        <p class="col-md-12" style="margin: 8px 0; padding: 0 10px; color:black;">
                                                            @{{question_title}}
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <div class="fig" id="fig" style="display:none; margin: 0 0 10px 50px;">
                                                            <img class="img-responsive" v-bind:src="img_link" width="550" alt="fig0-0">
                                                        </div>
                                                    </div>

                                                    <div class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                        <div class="radio" id="radio1" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px; margin-bottom: 10px;">
                                                            <label ><input style="display:inline-block;" v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt1'>@{{opt1}}</label>
                                                        </div>
                                                        <div class="radio" id="radio2" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px; margin-bottom: 10px;">
                                                            <label ><input style="display:inline-block;" v-on:click="answerd_counter" type="radio" name="optradio"  v-model="rad" v-bind:value='opt2'>@{{opt2}}</label>
                                                        </div>
                                                        <div class="radio" id="radio3" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px; margin-bottom: 10px;">
                                                            <label ><input style="display:inline-block;" v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt3'>@{{opt3}}</label>
                                                        </div>
                                                        <div class="radio" id="radio4" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px;">
                                                            <label ><input style="display:inline-block;" v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt4'>@{{opt4}}</label>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-2" style="  min-height: 30px; font-size: 18px;">
                                                            <a id="prev" v-on:click="prev">
                                                                <i class="fa fa-angle-left" style="font-weight: bold; font-size: 21px; padding-right:5px;"></i>  PREVIOUS
                                                            </a>
                                                        </div>
                                                        <div class="col-md-8"></div>
                                                        <div class=" col-md-2" style="  min-height: 30px; text-align: right; font-size: 18px;">
                                                            <a id="next" v-on:click="next" >
                                                                NEXT <i class="fa fa-angle-right" style="font-weight: bold; font-size: 21px; padding-left:5px;"></i>
                                                            </a>
                                                            <a id="finish_btn" v-on:click="markExam" style="display:none;" >
                                                                <b>Finish test <i class="fa fa-angle-right" style="font-weight: bold; font-size: 21px; padding-left:5px;"></i></b>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="container-fluid" id="result" style="display:none;" >
                                                    <h2>
                                                        Your Score is : @{{score}} %
                                                        <i v-html="ScoreMsg"></i>
                                                    </h2>

                                                    <h3>Score Analysis</h3>

                                                    <div class="mx-auto">
                                                        <a class="btn green-meadow" v-on:click="return_to_quiz">Review</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End FAQ section
		============================================= -->

<!-- Start of recent view product
		============================================= -->

<!-- End of recent view product
		============================================= -->

<!-- Start of footer section
		============================================= -->
<footer>
    <section id="footer-area" class="footer-area-section">
        <div class="container">

            <!-- /footer-widget-content -->

            <div class="copy-right-menu">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="copy-right-text">
                                <p>© 2019-2020 <u>{{env('APP_NAME')}}</u> All rights reserved - Powered By <a href="http://marvelits.com" target="_blank"><u>MarvelIts</u></a></p>
                            </div>
                            
                            
                        </div>
                        <div class="col-md-6">
                            <div class="copy-right-menu-item float-right ul-li">
                                <ul>
                                    <li><a href="{{route('terms.show.public')}}">Term Of Service</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
</footer>
<!-- End of footer section
		============================================= -->

<!-- For Js Library -->
<script src="{{asset('indexassets/js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('indexassets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('indexassets/js/popper.min.js')}}"></script>
<script src="{{asset('indexassets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('indexassets/js/jarallax.js')}}"></script>
<script src="{{asset('indexassets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('indexassets/js/lightbox.js')}}"></script>
<script src="{{asset('indexassets/js/jquery.meanmenu.js')}}"></script>
<script src="{{asset('indexassets/js/scrollreveal.min.js')}}"></script>
<script src="{{asset('indexassets/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('indexassets/js/waypoints.min.js')}}"></script>
<script src="{{asset('indexassets/js/jquery-ui.js')}}"></script>
<script src="{{asset('indexassets/js/gmap3.min.js')}}"></script>
<script src="{{asset('indexassets/js/switch.js')}}"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyC61_QVqt9LAhwFdlQmsNwi5aUJy9B2SyA"></script>
<script src="{{asset('indexassets/js/script.js')}}"></script>

<script src="{{asset('js/easyTimer.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script>




    var app = new Vue({
        el: '#app-1',
        data: {
            feedback: '',
            current_question_answer: '',
            rad:'',
            questions: [],
            question_title_list: [],
            current_question_number: 0,
            q_number: 0,
            question_title: '',
            opt1: '',
            opt2: '',
            opt3: '',
            opt4: '',
            q_answerd: 0,
            q_answerd_list: [],
            user_answers:[],
            timer: new Timer(),
            timeTaken: '',
            score: 0,
            question_type_list: [
                'All',
                @if(count($type_list))
                        @foreach($type_list as $type)
                    '{{$type}}',
                @endforeach
                @endif
            ],
            question_type: 'All',
            question_num: {{$questions_number}},
            max_questions_num: {{$questions_number}},
            img_link: '',
            make_exam: {
                taken: 0,
                text: 'Submit Exam'
            }, // exam has been taken or not
            ScoreMsg: '',
            scoreAnalysis: {
                @if(count($type_list))
                        @foreach($type_list as $type)
                '{{$type}}': {msg: '',count: 0 , data: []},
                @endforeach
                @endif
            },
            flaged: [],

        },
        methods: {
            _:function(ele){
                return document.getElementById(ele);
            },
            update_progress: function(add){
                if(app.make_exam.taken == 0){
                    percent = Math.round((app.q_answerd)/app.q_number*100);
                    $('.progress-bar').attr('aria-valuenow', percent);
                    $('.progress-bar').attr('style', 'width: '+percent+'%');
                    this._('progress_bar').innerHTML = percent.toString().substr(0,5)+' %';
                }
            },
            reloadQuestionsNumber: function(e){
                Data = {
                    name: this.question_type
                };


                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax ({
                    type: 'POST',
                    url: '{{ route('quiz.reloadQuestionsNumber')}}',
                    data: Data,
                    success: function(res){

                        app.max_questions_num = res;
                        app.question_num = res;
                    },
                    error: function(res){
                        console.log('Error:', res);
                    }
                });
            },
            storeAnswers:function(){
                this.user_answers.forEach(ele => {
                    if(ele.question_num == this.current_question_number){
                        ele.user_answer = this.rad;
                    }
                });
            },
            answerd_counter: function(){
                if(!this.q_answerd_list.includes(this.current_question_number)){
                    this.q_answerd_list.push(this.current_question_number);
                    this.q_answerd++;
                }
            },
            optimizeQuiz: function(e){
                $("#optimizeForm").hide();

                done  = 0;
                // send request to generate the questions
                Data = {
                    num: this.question_num,
                    type: this.question_type
                };


                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });

                $.ajax ({
                    type: 'POST',
                    url: '{{ route('quiz.generate')}}',
                    data: Data,
                    success: function(res){
                        console.log(res);
                        if (res[0] == '222'){
                            alert(res[1]);
                            exit();
                        }
                        app.q_number = res.length;
                        app.current_question_number = 1;
                        app.questions = res;
                        counter = 1;
                        res.forEach(ele => {
                            app.question_title_list.push({
                                id: counter,
                                title: counter+'. '+ele['title'].substring(0,80)+'..',
                                score: 0,
                            });
                            counter++;
                        });
                        app.push_question(app.current_question_number);

                        c = 1;
                        app.questions.forEach(q => {
                            app.user_answers.push({
                                question_num: c,
                                user_answer: '',
                                correct_answer: q['correct_answer'],
                                process_group: q['process_group']
                            });
                            c++;
                        });

                        console.log(app.questions);

                    },
                    error: function(res){
                        console.log('Error:', res);
                    }
                });

                // show the quiz form and fire the timer on

                app.timer.start({countdown: true, startValues: {seconds: this.question_num *72}});
                app.timer.addEventListener('secondsUpdated', function (e) {
                    $('#timer').html(app.timer.getTimeValues().toString());
                });
                app.timer.addEventListener('targetAchieved', function(e){
                    app.markExam();
                });
                $("#quiz").show();
                $("#prev").hide();
                if(app.question_num <= 1){
                    $("#next").hide();
                }
                done= 1;
                while(1){
                    if(done==1){
                        app.update_progress();
                        break;
                    }
                }

            },
            push_question: function(CQN/* Current question Number */){
                this.question_title = this.questions[CQN-1]['title'];
                this.opt1 = this.questions[CQN-1]['answers'][0];
                this.opt2 = this.questions[CQN-1]['answers'][1];
                this.opt3 = this.questions[CQN-1]['answers'][2];
                this.opt4 = this.questions[CQN-1]['answers'][3];
                this.feedback = this.questions[CQN-1]['feedback'];
                this.current_question_answer = this.questions[CQN-1]['correct_answer'];
                if(this.questions[CQN-1]['img'] != 'null'){
                    this.img_link = './storage/questions/'+this.questions[CQN-1]['img'];
                    $("#fig").show();
                }else{
                    this.img_link = '';
                    $("#fig").hide();
                }

            },
            push_question_and_store_last_answer: function(QN /* question number */){

                this.storeAnswers();
                this.push_question(QN);
                this.current_question_number = QN;
                this.selectUserAnswer();

                //check the question number to adjustfy the next and prev btns
                if(this.current_question_number == this.q_number && this.q_number > 1){
                    $("#prev").show();
                    $("#next").hide();
                }else if(this.current_question_number == 1 && this.q_number > 1){
                    $("#next").show();
                    $("#prev").hide();
                }else if(this.current_question_number == this.q_number && this.q_number == 1){
                    $("#prev").hide();
                    $("#next").hide();
                }else {
                    $("#next").show();
                    $("#prev").show();
                }
                if(this.make_exam.taken == 1){
                    this.selectCorrectAnswer();
                }
                this.colorMyflag();
            },
            next: function(){
                // store the answer if exist
                app.update_progress();
                this.storeAnswers();

                //show the next question
                if((this.current_question_number+2) > this.q_number){
                    $("#next").hide();
                    if(app.make_exam.taken == 0){
                        $("#finish_btn").show();
                    }
                    $("#prev").show();
                }else{
                    $("#prev").show();

                }
                this.current_question_number++;


                this.push_question(this.current_question_number);

                //select the answer if exits
                this.selectUserAnswer();
                if(this.make_exam.taken == 1){
                    this.selectCorrectAnswer();
                }
                this.colorMyflag();
            },
            prev: function(){
                // store the answer if exist
                app.update_progress();
                this.storeAnswers();


                //show the previous question
                if((this.current_question_number - 2) < 1){
                    $("#prev").hide();
                    $("#next").show();
                }else{
                    $("#next").show();
                    if(app.make_exam.taken == 0){
                        $("#finish_btn").hide();
                    }
                }
                this.current_question_number--;
                this.push_question(this.current_question_number);
                //select the answer if exits
                this.selectUserAnswer();
                if(this.make_exam.taken == 1){
                    this.selectCorrectAnswer();
                }
                this.colorMyflag();
            },
            unselectRadio: function(){
                this.rad = '';
            },
            selectUserAnswer: function(){
                found = 0;
                this.user_answers.forEach(ele => {
                    if(ele.question_num == this.current_question_number){
                        this.rad = ele.user_answer;
                        found = 1;
                    }
                });
                if (!found){
                    this.unselectRadio();
                }
            },
            selectCorrectAnswer: function(){
                $("#radio1").find('.fa').remove();
                $("#radio2").find('.fa').remove();
                $("#radio3").find('.fa').remove();
                $("#radio4").find('.fa').remove();

                switch (this.questions[this.current_question_number-1].correct_answer) {
                    case this.opt1:
                        $("#radio1").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                        break;
                    case this.opt2:
                        $("#radio2").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                        break;
                    case this.opt3:
                        $("#radio3").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                        break;
                    case this.opt4:
                        $("#radio4").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                        break;
                }
            },
            markExam: function(){

                app.update_progress();

                if(this.flaged.length > 0 && !confirm("you have Flaged questions, Do you like to Process ?")){
                    console.log('stay down !');
                }else{
                    if(this.make_exam.taken == 1){
                        $("#quiz").hide();
                        $("#result").show();

                    }else{
                        // stop the timer and stor the time .
                        this.storeAnswers();

                        app.timer.stop();
                        // this.timeTaken = $("#timer").html();
                        $("#quiz").hide();

                        counter = 0;
                        this.user_answers.forEach(ele => {
                            if(ele.user_answer == ele.correct_answer){
                                this.score++;
                                this.question_title_list[counter].score = '1  <i class="fa fa-check" style="color:green"></i>';


                            }else{
                                this.question_title_list[counter].score = '0 <i class="fa fa-times" style="color: red"></i>';
                            }

                            counter++;
                        });


                        this.score /= this.q_number;
                        this.score *= 100;
                        this.score = Math.round(this.score);

                        if(this.score > 75){
                            this.ScoreMsg = '<small style="color:springgreen;">Congraulation you have Passed</small>';
                        }else{
                            this.ScoreMsg = '<small style="color:#DC143C;">Sorry You Failed !</small>';
                        }

                        // score analysis..

                        this.user_answers.forEach(answer => {
                            score = 0;
                            if(answer.user_answer == answer.correct_answer){
                                score = 1;
                            }
                            this.scoreAnalysis[answer.process_group].data.push({
                                q_num: answer.question_num,
                                q_score: score
                            });
                        });
                        // calculate number of question per process group..
                        for(i in this.scoreAnalysis){
                            this.scoreAnalysis[i].count = this.scoreAnalysis[i].data.length;
                        }
                        // generate the massage
                        number_de_correct_answers = 0;
                        for(i in this.scoreAnalysis){
                            this.scoreAnalysis[i].data.forEach(ele => {
                                if(ele.q_score == 1){
                                    number_de_correct_answers++;
                                }
                            });
                            process_score = number_de_correct_answers / this.scoreAnalysis[i].count;
                            process_score *= 100;
                            process_score = Math.round(process_score);

                            if(process_score <= 60){
                                this.scoreAnalysis[i].msg = '<i style="color: red;">Need Improvment</i>';
                            }else if(process_score > 60 && process_score<=70){
                                this.scoreAnalysis[i].msg = '<i style="color: red;">below target</i>';
                            }else if(process_score >= 75 && process_score <= 80){
                                this.scoreAnalysis[i].msg = '<i style="color: #999900;">target</i>';
                            }else if(process_score > 80){
                                this.scoreAnalysis[i].msg = '<i style="color:green;">above target</i>';
                            }
                            number_de_correct_answers = 0;
                        }
                        // delete unused process groups from the object..
                        for(i in this.scoreAnalysis){
                            if(this.scoreAnalysis[i].count == 0){
                                delete this.scoreAnalysis[i];
                            }

                        }

                        // generate the analysis with jquery ..


                        r = $("#result");
                        html_ = '';
                        for(var k in this.scoreAnalysis){
                            if(this.scoreAnalysis.hasOwnProperty(k)){
                                html_ += '<h4>'+k+' :</h4><h5>'+this.scoreAnalysis[k].msg+'</h5><table class="table table-bordered table-hover"><thead><th>Question No.</th><th>Score</th></thead><tbody>';
                                this.scoreAnalysis[k].data.forEach(x => {
                                    if(x.q_score == 1){
                                        html_ += '<tr><td>'+x.q_num+'</td><td><i class="fa fa-check" style="color:green"></i></td></tr>';
                                    }else{
                                        html_ += '<tr><td>'+x.q_num+'</td><td><i class="fa fa-times" style="color: red"></i></td></tr>';
                                    }
                                });
                                html_ += '</tbody></table>';
                                r.append(html_);
                                html_ = '';
                            }
                        }


                        this.make_exam.taken = 1;
                        this.make_exam.text = 'Your Score';

                        this.selectCorrectAnswer();

                        $("#feedback_btn").show();
                        $("#result").show();
                    }
                }
            },
            return_to_quiz: function(){
                $("#result").hide();
                $("#quiz").show();
            },
            flagMe: function(){
                located = 0;
                this.flaged.forEach(ele => {
                    if(ele == this.current_question_number)
                    {
                        //remove from array
                        this.flaged.splice(this.flaged.indexOf(this.current_question_number), 1);
                        located = 1;
                    }
                });
                if(located == 0 ){
                    // add it to array
                    this.flaged.push(this.current_question_number);
                }
                // add color,
                this.colorMyflag();
            },
            colorMyflag:function(){
                located = 0;
                this.flaged.forEach(ele => {
                    if(ele == this.current_question_number){
                        //color to red
                        $("#flag").css('color','red');
                        located =1;
                    }
                });
                if(located ==  0)
                {
                    $("#flag").css('color','gray');
                }
            }

        }
    });
</script>

</body>
</html>
