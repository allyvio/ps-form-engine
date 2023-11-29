<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Magnifica Questionnaire Form Wizard includes Corona Virus Covid-19 questionnaire">
    <meta name="author" content="Ansonika">
    <title>Peopleshift | Assessment Test</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/menu.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/vendors.css')}}" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
	
	<!-- MODERNIZR MENU -->
	<script src="{{asset('assets/js/modernizr.js')}}"></script>

</head>

<body class="layout_2">
	
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div><!-- /Preload -->
	
	<div id="loader_form">
		<div data-loader="circle-side-2"></div>
	</div><!-- /loader_form -->

	<header>
        <div class="container-fluid">
            <a href="index.html"><img src="img/logo_white.svg" alt="" width="178" height="45" class="d-none d-md-inline"><img src="img/logo_white_mobile.svg" alt="" width="62" height="45" class="d-inline d-md-none"></a>
            <h1>{{$project->name}}</h1>
            <div class="top_elements">
                <a href="#0" class="cd-nav-trigger">Menu<span class="cd-icon"></span></a>
                <!-- /menu button -->
                <nav>
                    <ul class="cd-primary-nav">
                        <li><a href="index.html" class="animated_link">Questionnaire without branch</a></li>
                        <li><a href="index-2.html" class="animated_link">Questionnaire with branch</a></li>
                        <li><a href="prevention.html" class="animated_link">Prevention Tips</a></li>
                        <li><a href="faq.html" class="animated_link">Faq</a></li>
                        <li><a href="contacts.html" class="animated_link">Contact Us</a></li>
                        <li><a href="#0" class="animated_link">Purchase Template</a></li>
                    </ul>
                </nav>
                <!-- /menu -->
            </div>
            <!-- /top_elements -->
        </div>
        <!-- /container -->
    </header>
    <!-- /Header -->

	<div class="container-fluid">
    <div id="form_container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div id="wizard_container">
                    <div id="top-wizard">
                        <div id="progressbar"></div>
                    </div>
                    <!-- /top-wizard -->
                    <form id="wrapped" method="post">
                        <input id="website" name="website" type="text" value="">
                        <!-- Leave for security protection, read docs for details -->
                        <div id="middle-wizard">
                        <div class="step">
                                <h3 class="main_question"><i class="arrow_right"></i>Please fill with your personal data</h3>
                                <div class="form-group add_top_30">
                                    <label for="name">First and Last Name</label>
                                    <input type="text" name="name" id="name" class="form-control required" onchange="getVals(this, 'name_field');">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control required" onchange="getVals(this, 'email_field');">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control required">
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                        <label for="age">Age</label>
                                        <div class="form-group radio_input">
                                            <input type="text" name="age" id="age" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-6 col-8">
                                        <div class="form-group radio_input">
                                            <label class="container_radio mr-3">Male
                                                <input type="checkbox" name="gender" value="Male" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="container_radio">Female
                                                <input type="checkbox" name="gender" value="Female" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row-->
                            </div>

                            @foreach($question as $item)
                            <div class="step">
                                <h3 class="main_question"><i class="arrow_right"></i>{{$item->question}}</h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="container_check version_2">{{$item->value_a}}
                                                <input type="radio" name="question_1[]" value="China" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="container_check version_2">{{$item->value_b}}
                                                <input type="radio" name="question_1[]" value="South Korea" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="container_check version_2">{{$item->value_c}}
                                                <input type="radio" name="question_1[]" value="Europe" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="container_check version_2">{{$item->value_d}}
                                                <input type="radio" name="question_1[]" value="US States" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                            <label class="container_check version_2">{{$item->value_e}}
                                                <input type="radio" name="question_1[]" value="US States" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                            </div>
                            @endforeach
                            <!-- /step-->

                            <div class="submit step" id="end">
                                <div class="summary text-center">
                                    <div class="wrapper">
                                        <h3>Thank your for your time<br><span id="name_field"></span>!</h3>
                                        <p>We will contat you shorly at the following email address <strong id="email_field"></strong> and if necessary take measures.</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="form-group terms">
                                            <label class="container_check">Please accept our <a href="#" data-toggle="modal" data-target="#terms-txt">Terms and conditions</a> before Submit
                                                <input type="checkbox" name="terms" value="Yes" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /step last-->

                        </div>
                        <!-- /middle-wizard -->
                        <div id="bottom-wizard">
                            <button type="button" name="backward" class="backward">Prev</button>
                            <button type="button" name="forward" class="forward">Next</button>
                            <button type="submit" name="process" class="submit">Submit</button>
                        </div>
                        <!-- /bottom-wizard -->
                    </form>
                </div>
                <!-- /Wizard container -->
            </div>
        </div><!-- /Row -->
    </div><!-- /Form_container -->
</div>
<!-- /container -->

<footer class="footer_in clearfix">
        <div class="container">
            <p>© 2021 Magnifica</p>
            <ul>
                <li><a href="#0" class="animated_link">Purchase this template</a></li>
                <li><a href="without_branch_layout_2.html" class="animated_link">Layout 2</a></li>
                <li><a href="faq.html" class="animated_link">Faq</a></li>
                <li><a href="prevention.html" class="animated_link">Prevention Tips</a></li>
            </ul>
        </div>
</footer>
<!-- /footer -->

<div class="cd-overlay-nav">
    <span></span>
</div>
<!-- /cd-overlay-nav -->
<div class="cd-overlay-content">
    <span></span>
</div>
<!-- /cd-overlay-content -->

	<!-- Modal terms -->
	<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="termsLabel">Terms and conditions</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn_1" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<!-- Modal info -->
	<div class="modal fade" id="more-info" tabindex="-1" role="dialog" aria-labelledby="more-infoLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="more-infoLabel">Frequently asked questions</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn_1" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	
	<!-- COMMON SCRIPTS -->
	<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/js/common_scripts.min.js')}}"></script>
	<script src="{{asset('assets/js/velocity.min.js')}}"></script>
	<script src="{{asset('assets/js/common_functions.js')}}"></script>

	<!-- Wizard script without branch -->
	<script src="{{asset('assets/js/wizard_without_branch.js')}}"></script>

</body>
</html>