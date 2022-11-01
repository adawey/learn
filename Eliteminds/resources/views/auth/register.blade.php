<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>  Elite Minds Community | Register </title>
    <meta name="description" content="Register Page" />
    <!-- Favicon Tags Start -->
    <!--<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{asset('user-assets/img/favicon/apple-touch-icon-57x57.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('user-assets/img/favicon/apple-touch-icon-114x114.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('user-assets/img/favicon/apple-touch-icon-72x72.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('user-assets/img/favicon/apple-touch-icon-144x144.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{asset('user-assets/img/favicon/apple-touch-icon-60x60.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{asset('user-assets/img/favicon/apple-touch-icon-120x120.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{asset('user-assets/img/favicon/apple-touch-icon-76x76.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{asset('user-assets/img/favicon/apple-touch-icon-152x152.png')}}" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-196x196.png')}}" sizes="196x196" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-96x96.png')}}" sizes="96x96" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-32x32.png')}}" sizes="32x32" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-16x16.png')}}" sizes="16x16" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-128.png')}}" sizes="128x128" />-->
    <!--<meta name="application-name" content="&nbsp;" />-->
    <!--<meta name="msapplication-TileColor" content="#FFFFFF" />-->
    <!--<meta name="msapplication-TileImage" content="{{asset('index-assets/images/favicon.ico')}}" />-->
    <!--<meta name="msapplication-square70x70logo" content="{{asset('index-assets/images/favicon.ico')}}" />-->
    <!--<meta name="msapplication-square150x150logo" content="{{asset('index-assets/images/favicon.ico')}}" />-->
    <!--<meta name="msapplication-wide310x150logo" content="{{asset('index-assets/images/favicon.ico')}}" />-->
    <!--<meta name="msapplication-square310x310logo" content="{{asset('index-assets/images/favicon.ico')}}" />-->
    
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('index-assets/images/favicon.ico')}}">
    <meta property="og:image" content="{{asset('index-assets/images/favicon.ico')}}" />
    <!-- Favicon Tags End -->
    <!-- Font Tags Start -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="font/CS-Interface/style.css')}}" />
    <!-- Font Tags End -->
    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="{{asset('user-assets/css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('user-assets/css/vendor/OverlayScrollbars.min.css')}}" />

    <!-- Vendor Styles End -->
    <!-- Template Base Styles Start -->
    <link rel="stylesheet" href="{{asset('user-assets/css/styles.css')}}" />
    <!-- Template Base Styles End -->

    <link rel="stylesheet" href="{{asset('user-assets/css/main.css')}}" />
    <script src="{{asset('user-assets/js/base/loader.js')}}"></script>
</head>

<body class="h-100">
<div id="root" class="h-100">
    <!-- Background Start -->
    <div class="fixed-background"></div>
    <!-- Background End -->

    <div class="container-fluid p-0 h-100 position-relative">
        <div class="row g-0 h-100">
            <!-- Left Side Start -->
            <div class="offset-0 col-12 d-none d-lg-flex offset-md-1 col-lg h-lg-100">
                <div class="min-h-100 d-flex align-items-center">
                    <div class="w-100 w-lg-75 w-xxl-50">
                        <div>
                            <div class="mb-5">
                                <h1 class="display-3 text-white">{{ env('APP_NAME') }}</h1>
                                <h1 class="display-3 text-white">Welcome to Elite Minds Community</h1>
                            </div>
                            <p class="h6 text-white lh-1-5 mb-5">
                                We are glad to see you here, thanks for giving us the opportunity and registering through our cozy website. Feel free to reach out whenever you have any question or clarification. You can send us a WhatsApp message, or shoot us an email, and we will get back to you very soon.
                            </p>
                            <div class="mb-5">
                                <a class="btn btn-lg btn-outline-white" href="{{route('login')}}">Login Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Side End -->

            <!-- Right Side Start -->
            <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
                <div class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
                    <div class="sw-lg-50 px-5">
                        <div class="sh-11">
                            <a href="{{route('index')}}">
                                <div class="logo-default"></div>
                            </a>
                        </div>
                        <div class="mb-5">
                            <h2 class="cta-1 mb-0 text-primary">Welcome,</h2>
                            <h2 class="cta-1 text-primary">let's get the ball rolling!</h2>
                        </div>
                        <div class="mb-5">
                            <p class="h6">Please use the form to register.</p>
                            <p class="h6">
                                If you are a member, please
                                <a href="{{route('login')}}">login</a>.
                            </p>
                        </div>
                        @if ($errors->has('name'))
                            <span class="alert alert-danger" style="display:block;">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                   @endif
                                @if ($errors->has('email'))
                                    <span class="alert alert-danger" style="display:block;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                                @if ($errors->has('password'))
                                    <span class="alert alert-danger" style="display:block;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                @endif
                                @if ($errors->has('country'))
                                <span class="alert alert-danger" style="display:block;">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                                @if ($errors->has('city'))
                                    <span class="alert alert-danger" style="display:block;">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                                @endif
                                @if ($errors->has('phone'))
                                    <span class="alert alert-danger" style="display:block;">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                        <div>
                            <form id="registerForm" class="tooltip-end-bottom" action="{{ route('register') }}" method="POST" novalidate>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-cs-icon="user"></i>
                                    <input class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" />
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-cs-icon="email"></i>
                                    <input class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" />
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z"/>
                                    </svg>
                                    <select class="form-control" placeholder="Country" name="country">
                                        <option value="" selected disabled>Country</option>
                                        <option value="United States">United States</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Afghanistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antarctica">Antarctica</option>
                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Bouvet Island">Bouvet Island</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Territories">French Southern Territories</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea-bissau">Guinea-bissau</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                        <option value="Korea, Republic of">Korea, Republic of</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macao">Macao</option>
                                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                        <option value="Moldova, Republic of">Moldova, Republic of</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Pitcairn">Pitcairn</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russian Federation">Russian Federation</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Saint Helena">Saint Helena</option>
                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                        <option value="Saint Lucia">Saint Lucia</option>
                                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                        <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Timor-leste">Timor-leste</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Viet Nam">Viet Nam</option>
                                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                                        <option value="Western Sahara">Western Sahara</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                    </select>
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z"/>
                                    </svg>
                                    <input type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}" />
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone-fill" viewBox="0 0 16 16">
                                        <path d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2zm6 11a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
                                    </svg>
                                    <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{ old('phone') }}" />
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-cs-icon="lock-off"></i>
                                    <input class="form-control" name="password" type="password" placeholder="Password" />
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-cs-icon="lock-off"></i>
                                    <input class="form-control" name="password_confirmation" type="password" placeholder="Password Confirmation" />
                                </div>
                                <div class="mb-3 position-relative form-group">
                                    <div class="form-check">
{{--                                        <input type="checkbox" class="form-check-input" id="registerCheck" name="registerCheck" />--}}
                                        <label class="form-check-label" for="registerCheck">
                                            <label>By clicking submit,<a > you agree to our terms & policy.</a></label>
{{--                                            <a href="index.html" target="_blank">terms and conditions.</a>--}}
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary">Sign up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Side End -->
        </div>
    </div>
</div>

<!-- Vendor Scripts Start -->
<script src="{{asset('user-assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/OverlayScrollbars.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/autoComplete.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/clamp.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/jquery.validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/jquery.validate/additional-methods.min.js')}}"></script>
<!-- Vendor Scripts End -->

<!-- Template Base Scripts Start -->
<script src="{{asset('user-assets/font/CS-Line/csicons.min.js')}}"></script>
<script src="{{asset('user-assets/js/base/helpers.js')}}"></script>
<script src="{{asset('user-assets/js/base/globals.js')}}"></script>
<script src="{{asset('user-assets/js/base/nav.js')}}"></script>
<script src="{{asset('user-assets/js/base/search.js')}}"></script>
<script src="{{asset('user-assets/js/base/settings.js')}}"></script>
<script src="{{asset('user-assets/js/base/init.js')}}"></script>
<!-- Template Base Scripts End -->
<!-- Page Specific Scripts Start -->
<script src="{{asset('user-assets/js/pages/auth.register.js')}}"></script>
<script src="{{asset('user-assets/js/common.js')}}"></script>
<script src="{{asset('user-assets/js/scripts.js')}}"></script>
<!-- Page Specific Scripts End -->
</body>
</html>
