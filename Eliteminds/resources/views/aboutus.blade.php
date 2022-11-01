@extends('layouts.public')
@section('head')
<title>{{env('APP_NAME')}} | About us</title>
<style>
    * {
      box-sizing: border-box;
    }
    
    /* Create two equal columns that floats next to each other */
    .column {
      float: left;
      width: 50%;
      padding: 10px;
      height: 500px; /* Should be removed. Only for demonstration */
    }
    
    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    .single-testimonial::before {
        background-image: unset !important;
    }
    
    .single-testimonial {
        height: 280px;
    }
    </style>
@endsection
@section('content')
<div class="section page-banner" style="background: url('{{asset('img/cover-1.jpg')}}'); margin-bottom: 20px;">

    <img class="shape-1 animation-round" src="{{asset('index-assets/images/shape/shape-8.png')}}" alt="Shape">

    <img class="shape-2" src="{{asset('index-assets/images/shape/shape-23.png')}}" alt="Shape">

    <div class="container">
        <!-- Page Banner Start -->
        <div class="page-banner-content">
            <ul class="breadcrumb">
                <li><a href="#" style="color:white">Home</a></li>
                <li class="active">About</li>
            </ul>
            <h2 class="title" style="color:white">About <span>{{env('APP_NAME')}}.</span></h2>
        </div>
        <!-- Page Banner End -->
    </div>

    <!-- Shape Icon Box Start -->
    <div class="shape-icon-box">

        <img class="icon-shape-1 animation-left" src="{{asset('index-assets/images/shape/shape-5.png')}}" alt="Shape">

        <div class="box-content">
            <div class="box-wrapper">
                <i class="flaticon-badge"></i>
            </div>
        </div>

        <img class="icon-shape-2" src="{{asset('index-assets/images/shape/shape-6.png')}}" alt="Shape">

    </div>
    <!-- Shape Icon Box End -->

    <img class="shape-3" src="{{asset('index-assets/images/shape/shape-24.png')}}" alt="Shape">

    <img class="shape-author" src="{{asset('index-assets/images/author/author-11.jpg')}}" alt="Shape">

</div>
    <div class="row">
        <div class="col-md-6 pb-98  text-center" >
            <div class=" container" >
            <img src="https://www.filepicker.io/api/file/AKKYI2ieQyyMN2hoM6OO" width="60" height="60" >
            <h5 class="main-title">We help you grow through knowledge and skills</h5>
            <p  style=" font-size:16px;" >Elite Minds LLC is a Trusted and Experienced Education Provider based in Amman, Jordan. We are one of the leading online training companies for Project Management exams preparation. We have helped nearly 20,000 students with our exam prep training courses and exams simulators since 2017. We provide self-paced, high-quality, innovative, and cost-effective materials to help you and your team study wherever you are.
                We provide rigorous online training in disciplines such as Project Management, Risk Management, Agile, Business Analysis, and Program and Portfolio Management, among others. In other words, we specialize in areas where best practices are changing rapidly, and the demand for qualified candidates significantly exceeds supply.
                As part of our courses, many of our past students strongly recommend our highly rated PMP® Exam Simulator. Students can face the latest PMI® exam format with confidence and pass comfortably based on practice tests, reviews, and various exam tips included in the course material. The simulator offers an online realistic exam experience to test your and your team's knowledge. It enables students to learn and use their exam preparation time effectively.
                </p>

        </div>
        </div>                                                                          
        <div class="col-md-6">
            <img src="{{asset('index-assets/images/blog/img1.png')}}" class="rounded-3 w-100" >
         </div>
    </div>
   <div class="row pt-1">
    <div class="col-md-6 ">
    <img src="{{asset('index-assets/images/blog/img2.png')}}" class="rounded-3 float-end w-100">
    </div>
    <div class=" col-md-6  text-center" >
        <div class=" container" style="" >
            <img src="https://www.filepicker.io/api/file/yf6nk2KpSD6W5S9MiSVw" width="88" height="88">
            <h5 class="main-title ">Vision</h5>
            <p >To become the pioneer among online training providers over the world through enabling professionals to achieve their career goals and become better at what they do
                </p>
        </div>
    </div>
   </div>
  <div class="row  ">
    <div class=" col-md-6 pb-10 text-center" >
        <div class=" container" style="width:100%;height:100%;" >
            <img src="https://www.filepicker.io/api/file/cKrf25DyQaqFMPugdZPu" width="88" height="88">
            <h5 class="main-title ">Mission</h5>
            <p >To deliver affordable and high quality self-paced courses in a convenient manner to help professionals achieve their learning goals anytime anywhere</p>
        </div>
    </div>
    <div class=" col-md-6">
        <img src="{{asset('index-assets/images/blog/img3.png')}}" class="rounded-3 w-100">
    </div>
   
  </div>
  {{-- <div class="section-title shape-03 text-center">
    <img class="sub-title" src="https://www.filepicker.io/api/file/8Snj18ZhQy2x8eNOheKl" width="88" height="88">
    <h3 class="main-title">Our Core Values</h3>
</div>
  <div class="row section ">
    <div class="column col-md-6  " style="background-image:url('{{asset("index-assets/images/blog/kk.jpg")}}');background-repeat: no-repeat;">
    
    </div>
    <div class="column col-md-6 pb-10" >
        <div class="about-content" style="width: max-content;">
            <img src="https://www.filepicker.io/api/file/8Snj18ZhQy2x8eNOheKl" width="88" height="88">
            <h5 class="sub-title ">Our Core Values</h5>
            <ul>
                <li>1.Professionalism. We strive to provide high quality products and services with accuracy, consistency</li>
                <li>2.People focused. We keep the students that we serve at the forefront of our work </li>
                <li>3.Optimism. We believe that we can solve public education’s challenges. At the same time, we are open, honest, and direct about the current problems in the sector.</li>
            </ul>

        </div>
    </div>
    
  </div>  --}}


  <div class="section section-padding-02 mt-n1">
    <div class="container">

        <!-- Section Title Start -->
        <div class="section-title shape-03 text-center">
            <img class="sub-title" src="https://www.filepicker.io/api/file/8Snj18ZhQy2x8eNOheKl" width="88" height="88">
            <h3 class="main-title">Our Core Values</h3>
        </div>
        <!-- Section Title End -->

        <!-- Testimonial Wrapper End -->
        <div class="testimonial-wrapper testimonial-active">
            <div class="swiper-container">
                <div class="swiper-wrapper">
               
                    <!-- Single Testimonial Start -->
                    <div class="single-testimonial swiper-slide">
                        
                        <div class="testimonial-content">
                            <h4 class="name">Professionalism</h4>
                            <p>We strive to provide high quality products and services with accuracy, consistency</p>
                            
                           
                        </div>
                    </div>
                    <div class="single-testimonial swiper-slide">
                        
                        <div class="testimonial-content">
                            <h4 class="name">People focused</h4>
                            <p>We keep the students that we serve at the forefront of our work </p>
                            
                           
                        </div>
                    </div>
                    <div class="single-testimonial swiper-slide">
                        
                        <div class="testimonial-content">
                            <h4 class="name">Optimism</h4>
                            <p>We believe that we can solve public education’s challenges. At the same time, we are open, honest, and direct about the current problems in the sector</p>
                            
                           
                        </div>
                    </div>
                    <!-- Single Testimonial End -->
                </div>
                
               
               
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!-- Testimonial Wrapper End -->

    </div>
</div>


<div class="section-title shape-03 text-center ">
    <img class="sub-title" src="https://www.filepicker.io/api/file/CbmNFzbXTE6QQJ2B2lR7" width="88" height="88">
    <h3 class="main-title">Our Story</h3>
    <p >
        Elite Minds was created out of a desire to deliver flexible, affordable, and quality educational content as our founder believes that every professional should have the same opportunities
    </p>
</div>
<br><br><br>

{{--   
  <div class="row section ">
    
    <div class="column col-md-6 " >
        <div class="about-content" >
            <img src="https://www.filepicker.io/api/file/CbmNFzbXTE6QQJ2B2lR7" width="88" height="88" >
            <h5 class="sub-title ">Our Story</h5>
            <p >
                Elite Minds was created out of a desire to deliver flexible, affordable, and quality educational content as our founder believes that every professional should have the same opportunities
            </p>
        
        </div>
    </div>
    <div class="column col-md-6  " style="background-image:url('{{asset("index-assets/images/blog/kk.jpg")}}');background-repeat: no-repeat;">
    
    </div>
    
  </div> 
   --}}
  
@endsection