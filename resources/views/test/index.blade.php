<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="MASTENIA - Register, Reservation, Questionare, Reviews form wizard">
	<meta name="author" content="Ansonika">
	<title>Pesople Form | Give us the best answer !</title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="{{asset('test-form/img/favicon.ico')}}" type="image/x-icon">
	<link rel="apple-touch-icon" type="image/x-icon" href="{{asset('test-form/img/apple-touch-icon-57x57-precomposed.png')}}">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{asset('test-form/img/apple-touch-icon-72x72-precomposed.png')}}">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{asset('test-form/img/apple-touch-icon-114x114-precomposed.png')}}">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{asset('test-form/img/apple-touch-icon-144x144-precomposed.png')}}">

	<!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<!-- BASE CSS -->
	<link href="{{asset('test-form/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('test-form/css/style.css')}}" rel="stylesheet">
	<link href="{{asset('test-form/css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('test-form/css/menu.css')}}" rel="stylesheet">
	<link href="{{asset('test-form/css/animate.min.css')}}" rel="stylesheet">
	<link href="{{asset('test-form/css/icon_fonts/css/all_icons_min.css')}}" rel="stylesheet">
	<link href="{{asset('test-form/css/skins/square/grey.css')}}" rel="stylesheet">

	<!-- YOUR CUSTOM CSS -->
	<link href="{{asset('test-form/css/custom.css')}}" rel="stylesheet">

	<script src="{{asset('test-form/js/modernizr.js')}}"></script>
	<!-- Modernizr -->
</head>

<body>
	
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div><!-- /Preload -->

<div class="min-vh-100 d-flex flex-column">

	<header>
		<div class="container-fluid">
		    <div class="row d-flex align-items-center">
                <div class="col-3">
                    <a href="index.html"><img src="{{asset('test-form/img/logo.png')}}" alt="" width="45" height="45"></a>
                </div>
                <div class="col-9">
                    <div id="social">
                        <ul>
                            <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
                            <li><a href="#0"><i class="bi bi-instagram"></i></a></li>
                            <li><a href="#0"><i class="bi bi-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <!-- /social -->
                    <nav>
                        <ul class="cd-primary-nav">
                            <li><a href="index.html" class="animated_link">Register Version</a></li>
                            <li><a href="reservation_version.html" class="animated_link">Reservation Version</a></li>
                            <li><a href="questionnaire_version.html" class="animated_link">Questionnaire Version</a></li>
                            <li><a href="review_version.html" class="animated_link">Review Version</a></li>
                            <li><a href="about.html" class="animated_link">About Us</a></li>
                            <li><a href="contacts.html" class="animated_link">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
		</div>
		<!-- container -->
	</header>
	<!-- End Header -->

	<div class="d-flex flex-column my-auto">
		<main class="container">
		    <div class="row justify-content-center">
		        <div class="col-xl-11">
		            <div class="form_container">
		                <div class="row">
		                    <div class="col-lg-4">
		                        <div id="left_form">
		                            <figure><img src="{{asset('test-form/img/registration_bg.svg')}}" alt="" width="120" height="120"></figure>
		                            <h2>Feedback Form</h2>
		                            <p>Terima kasih karena telah menyelesaikan  Leadership Development Program XX x Squad Games!
									Silahkan isi form berikut untuk membantu meningkatkan kualitas layanan yang kami berikan kepada Anda di kemudian hari.</p>
		                            <a href="#0" id="more_info" data-bs-toggle="modal" data-bs-target="#more-info"><i class="pe-7s-info"></i></a>
		                        </div>
		                    </div>
		                    <div class="col-lg-8">
		                        <form id="custom" action="" method="POST">
		                            <input id="website" name="website" type="text" value="">
		                            <fieldset title="Step 1">
		                                <legend>Peserta</legend>
		                                <div class="row">
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <input type="text" name="firstname" class="form-control" placeholder="Nama Lengkap">
		                                        </div>
		                                    </div>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <input type="text" name="lastname" class="form-control" placeholder="Jabatan">
		                                        </div>
		                                    </div>
		                                </div>
		                                <!-- /row -->
		                                <div class="row">
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <input type="text" name="instagram" class="form-control" placeholder="Instagram">
		                                        </div>
		                                    </div>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <input type="text" name="telephone" class="form-control" placeholder="Nomor Telpon">
		                                        </div>
		                                    </div>
		                                </div>
		                                <!-- /row -->
		                                <div class="row">
		                                    <div class="col-md-6">
		                                        <div class="form-group radio_input">
		                                            <label><input type="radio" value="Male" checked name="gender" class="icheck">Male</label>
		                                            <label><input type="radio" value="Female" name="gender" class="icheck">Female</label>
		                                        </div>
		                                    </div>
		                                </div>
		                                <!-- /row -->
		                            </fieldset><!-- End Step one -->
		                            <fieldset title="Step 2">
		                                <legend>Pelatihan</legend>
		                                <div class="row">
		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <input type="text" name="address" class="form-control" placeholder="Terinspirasi untuk mulai membangun bisnis sendiri yang dapat dikaitkan dengan life purpose?">
		                                        </div>
		                                    </div>
											<div class="col-md-12">
		                                        <div class="form-group">
		                                            <input type="text" name="address" class="form-control" placeholder="Mengetahui proses jatuh bangun serta tantangan dalam membangun suatu bisnis?">
		                                        </div>
		                                    </div>
											<div class="col-md-12">
		                                        <div class="form-group">
		                                            <input type="text" name="address" class="form-control" placeholder="Mengetahui dinamika bisnis dan cara untuk bisa tetap bertahan selama proses membangun bisnis?">
		                                        </div>
		                                    </div>
		                                    <!-- /col-sm-12 -->
		                                </div>
		                                <!-- /row -->
		                            </fieldset><!-- End Step two -->
									<fieldset title="Step 3">
										<legend>Penilaian</legend>
										<h3 class="main_question">Penilaian Umum & Teknis</h3>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group clearfix">
													<label class="rating_type">Penyelenggara menggunakan metodologi pelatihan yang efektif dalam meningkatkan pemahaman peserta</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-1-6-a" name="rating_input_1-a" value="6 Stars"><label for="rating-input-1-6-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-5-a" name="rating_input_1-a" value="5 Stars"><label for="rating-input-1-5-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-4-a" name="rating_input_1-a" value="4 Stars"><label for="rating-input-1-4-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-3-a" name="rating_input_1-a" value="3 Stars"><label for="rating-input-1-3-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-2-a" name="rating_input_1-a" value="2 Stars"><label for="rating-input-1-2-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-1-a" name="rating_input_1-a" value="1 Star"><label for="rating-input-1-1-a" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type"> Penyelenggara melaksanakan pelatihan dengan profesional dan rapi</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-2-6-a" name="rating_input_2-a" value="6 Stars"><label for="rating-input-2-6-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-5-a" name="rating_input_2-a" value="5 Stars"><label for="rating-input-2-5-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-4-a" name="rating_input_2-a" value="4 Stars"><label for="rating-input-2-4-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-3-a" name="rating_input_2-a" value="3 Stars"><label for="rating-input-2-3-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-2-a" name="rating_input_2-a" value="2 Stars"><label for="rating-input-2-2-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-1-a" name="rating_input_2-a" value="1 Star"><label for="rating-input-2-1-a" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Penyelenggara memberikan pelayanan peserta yang memuaskan (Training tools, marchandise, materi, dll)</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-3-6-a" name="rating_input_3-a" value="6 Stars"><label for="rating-input-3-6-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-5-a" name="rating_input_3-a" value="5 Stars"><label for="rating-input-3-5-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-4-a" name="rating_input_3-a" value="4 Stars"><label for="rating-input-3-4-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-3-a" name="rating_input_3-a" value="3 Stars"><label for="rating-input-3-3-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-2-a" name="rating_input_3-a" value="2 Stars"><label for="rating-input-3-2-a" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-1-a" name="rating_input_3-a" value="1 Star"><label for="rating-input-3-1-a" class="rating-star"></label>
													</span>
												</div>
											</div>
										</div>
										<!-- /row -->
									</fieldset><!-- End Step theree -->
									<fieldset title="Step 4">
										<legend>Trainer</legend>
										<h3 class="main_question"> Penilaian Trainer, Fasilitator, & Learning Partner</h3>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group clearfix">
													<label class="rating_type">Materi training disusun dengan struktur yang rapih dan didukung dengan ilustrasi yang relevan</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-1-6-b" name="rating_input_1-b" value="6 Stars"><label for="rating-input-1-6-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-5-b" name="rating_input_1-b" value="5 Stars"><label for="rating-input-1-5-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-4-b" name="rating_input_1-b" value="4 Stars"><label for="rating-input-1-4-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-3-b" name="rating_input_1-b" value="3 Stars"><label for="rating-input-1-3-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-2-b" name="rating_input_1-b" value="2 Stars"><label for="rating-input-1-2-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-1-b" name="rating_input_1-b" value="1 Star"><label for="rating-input-1-1-b" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Materi training menjawab kebutuhan saya sebagai peserta dan memberikan inspirasi baru</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-2-6-b" name="rating_input_2-b" value="6 Stars"><label for="rating-input-2-6-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-5-b" name="rating_input_2-b" value="5 Stars"><label for="rating-input-2-5-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-4-b" name="rating_input_2-b" value="4 Stars"><label for="rating-input-2-4-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-3-b" name="rating_input_2-b" value="3 Stars"><label for="rating-input-2-3-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-2-b" name="rating_input_2-b" value="2 Stars"><label for="rating-input-2-2-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-1-b" name="rating_input_2-b" value="1 Star"><label for="rating-input-2-1-b" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Trainer menyampaikan materi dengan teknik yang baik (suara, sikap tubuh, dan antusiasme)</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-3-6-b" name="rating_input_3-b" value="6 Stars"><label for="rating-input-3-6-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-5-b" name="rating_input_3-b" value="5 Stars"><label for="rating-input-3-5-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-4-b" name="rating_input_3-b" value="4 Stars"><label for="rating-input-3-4-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-3-b" name="rating_input_3-b" value="3 Stars"><label for="rating-input-3-3-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-2-b" name="rating_input_3-b" value="2 Stars"><label for="rating-input-3-2-b" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-1-b" name="rating_input_3-b" value="1 Star"><label for="rating-input-3-1-b" class="rating-star"></label>
													</span>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<input type="text" name="perbaikan_trainer_text_area" class="form-control" placeholder="Masukan dan saran untuk perbaikan trainer">
														</div>
													</div>
													<!-- /col-sm-12 -->
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<div class="styled-select">
														<select name="fasilitator_list">
															<option value="" selected>Pilih fasilitator</option>
															<option value="Single bed">Nurdin M Top</option>
															<option value="Double Bed">Imam Samudra</option>
															<option value="Luxury double bed">Ali imron</option>
															<option value="Suite">Dr Azahri</option>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group clearfix">
													<label class="rating_type">Penilaian performa fasilitator kelompok anda secara keseluruhan</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-1-6-c" name="rating_input_1-c" value="6 Stars"><label for="rating-input-1-6-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-5-c" name="rating_input_1-c" value="5 Stars"><label for="rating-input-1-5-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-4-c" name="rating_input_1-c" value="4 Stars"><label for="rating-input-1-4-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-3-c" name="rating_input_1-c" value="3 Stars"><label for="rating-input-1-3-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-2-c" name="rating_input_1-c" value="2 Stars"><label for="rating-input-1-2-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-1-c" name="rating_input_1-c" value="1 Star"><label for="rating-input-1-1-c" class="rating-star"></label>
													</span>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<input type="text" name="perbaikan_fasil_text_area" class="form-control" placeholder="Masukan dan saran untuk perbaikan Fasilitator">
														</div>
													</div>
													<!-- /col-sm-12 -->
												</div>
										</div>
										<!-- /row -->
									</fieldset><!-- End Step four -->
									<fieldset title="Step 5">
										<legend>Challenge</legend>
										<h3 class="main_question">Tuliskan penilaian Anda terhadap setiap challenge yang diberikan. Silakan nilai tepat atau tidaknya digunakan dalam LDP XX</h3>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group clearfix">
													<label class="rating_type">Cacth The Stranger</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-1-6-f" name="rating_input_1-f" value="6 Stars"><label for="rating-input-1-6-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-5-f" name="rating_input_1-f" value="5 Stars"><label for="rating-input-1-5-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-4-f" name="rating_input_1-f" value="4 Stars"><label for="rating-input-1-4-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-3-f" name="rating_input_1-f" value="3 Stars"><label for="rating-input-1-3-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-2-f" name="rating_input_1-f" value="2 Stars"><label for="rating-input-1-2-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-1-1-f" name="rating_input_1-f" value="1 Star"><label for="rating-input-1-1-f" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Paper Project</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-2-6-f" name="rating_input_2-f" value="6 Stars"><label for="rating-input-2-6-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-5-f" name="rating_input_2-f" value="5 Stars"><label for="rating-input-2-5-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-4-f" name="rating_input_2-f" value="4 Stars"><label for="rating-input-2-4-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-3-f" name="rating_input_2-f" value="3 Stars"><label for="rating-input-2-3-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-2-f" name="rating_input_2-f" value="2 Stars"><label for="rating-input-2-2-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-2-1-f" name="rating_input_2-f" value="1 Star"><label for="rating-input-2-1-f" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Conveying Messeges</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-3-6-c" name="rating_input_3-c" value="6 Stars"><label for="rating-input-3-6-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-5-c" name="rating_input_3-c" value="5 Stars"><label for="rating-input-3-5-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-4-c" name="rating_input_3-c" value="4 Stars"><label for="rating-input-3-4-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-3-c" name="rating_input_3-c" value="3 Stars"><label for="rating-input-3-3-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-2-c" name="rating_input_3-c" value="2 Stars"><label for="rating-input-3-2-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-3-1-c" name="rating_input_3-c" value="1 Star"><label for="rating-input-3-1-c" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Food for People</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-4-6-f" name="rating_input_4-f" value="6 Stars"><label for="rating-input-4-6-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-4-5-f" name="rating_input_4-f" value="5 Stars"><label for="rating-input-4-5-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-4-4-f" name="rating_input_4-f" value="4 Stars"><label for="rating-input-4-4-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-4-3-f" name="rating_input_4-f" value="3 Stars"><label for="rating-input-4-3-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-4-2-f" name="rating_input_4-f" value="2 Stars"><label for="rating-input-4-2-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-4-1-f" name="rating_input_4-f" value="1 Star"><label for="rating-input-4-1-f" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Revenue Rocket</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-5-6-c" name="rating_input_5-c" value="6 Stars"><label for="rating-input-5-6-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-5-5-c" name="rating_input_5-c" value="5 Stars"><label for="rating-input-5-5-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-5-4-c" name="rating_input_5-c" value="4 Stars"><label for="rating-input-5-4-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-5-3-c" name="rating_input_5-c" value="3 Stars"><label for="rating-input-5-3-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-5-2-c" name="rating_input_5-c" value="2 Stars"><label for="rating-input-5-2-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-5-1-c" name="rating_input_5-c" value="1 Star"><label for="rating-input-5-1-c" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Talking to Customer</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-6-6-c" name="rating_input_6-c" value="6 Stars"><label for="rating-input-6-6-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-6-5-c" name="rating_input_6-c" value="5 Stars"><label for="rating-input-6-5-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-6-4-c" name="rating_input_6-c" value="4 Stars"><label for="rating-input-6-4-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-6-3-c" name="rating_input_6-c" value="3 Stars"><label for="rating-input-6-3-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-6-2-c" name="rating_input_6-c" value="2 Stars"><label for="rating-input-6-2-c" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-6-1-c" name="rating_input_6-c" value="1 Star"><label for="rating-input-6-1-c" class="rating-star"></label>
													</span>
												</div>
												<div class="form-group clearfix">
													<label class="rating_type">Book Review</label>
													<span class="rating">
													<input type="radio" class="rating-input" id="rating-input-7-6-f" name="rating_input_7-f" value="6 Stars"><label for="rating-input-7-6-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-7-5-f" name="rating_input_7-f" value="5 Stars"><label for="rating-input-7-5-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-7-4-f" name="rating_input_7-f" value="4 Stars"><label for="rating-input-7-4-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-7-3-f" name="rating_input_7-f" value="3 Stars"><label for="rating-input-7-3-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-7-2-f" name="rating_input_7-f" value="2 Stars"><label for="rating-input-7-2-f" class="rating-star"></label>
													<input type="radio" class="rating-input" id="rating-input-7-1-f" name="rating_input_7-f" value="1 Star"><label for="rating-input-7-1-f" class="rating-star"></label>
													</span>
												</div>
											</div>
										</div>
										<!-- /row -->
									</fieldset><!-- End Step five -->
									<fieldset title="Step 6">
		                                <legend>Testimoni</legend>
										<!--  -->
										<div class="form-group clearfix">
											<div class="row">
											<label class="rating_type">Apa yang membuat pelatihan ini berkesan menurut Anda</label>
												<div class="col-md-6">
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_1[]" class="icheck" id="form-check-1-a">
															</div>
															<div class="col-10">
																<label for="form-check-1-a">Materi yang diberikan menjawab kebutuhan</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<!--  -->
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_1[]" class="icheck" id="form-check-2-a">
															</div>
															<div class="col-10">
																<label for="form-check-2-a">Aktivitas dalam pelatihan yang menarik dan beda dari yang lain</label>
															</div>
														</div>
														<!--  -->
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_1[]" class="icheck" id="form-check-3-a">
															</div>
															<div class="col-10">
																<label for="form-check-3-a">Interaksi antar peserta yang positif dan insightful</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_1[]" class="icheck" id="form-check-4-a">
															</div>
															<div class="col-10">
																<label for="form-check-4-a">Pelayanan peserta yang memadai (Alat tulis, marchendise, paparan materi, dll)</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_1[]" class="icheck" id="form-check-5-a">
															</div>
															<div class="col-10">
																<label for="form-check-5-a">Trainer membawakan materi dengan jelas dan mudah dipahami</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_1[]" class="icheck" id="form-check-6-a">
															</div>
															<div class="col-10">
																<label for="form-check-6-a">Fasilitator membantu pembelajaran secara efektif</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_1[]" class="icheck" id="form-check-7-a">
															</div>
															<div class="col-10">
																<label for="form-check-7-a">Fasilitas pendukung yang memadai (ruangan, suasana kelas, snack, dll)</label>
															</div>
														</div>
													</div>
													<div class="form-group">
														<input type="text" name="hal-lain_form" class="form-control" placeholder="Tuliskan hal lain jika ada">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group clearfix">
											<div class="row">
											<label class="rating_type">Apa yang dapat ditingkatkan dari pelatihan ini</label>
												<div class="col-md-6">
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_2[]" class="icheck" id="form-check-1-b">
															</div>
															<div class="col-10">
																<label for="form-check-1-b">Materi yang diberikan belum menjawab kebutuhan</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_2[]" class="icheck" id="form-check-2-b">
															</div>
															<div class="col-10">
																<label for="form-check-2-b">Aktivitas dalam pelatihan yang kurang menarik</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_2[]" class="icheck" id="form-check-3-b">
															</div>
															<div class="col-10">
																<label for="form-check-3-b">Interaksi antar peserta tidak dibangun dengan baik</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_2[]" class="icheck" id="form-check-4-b">
															</div>
															<div class="col-10">
																<label for="form-check-4-b">Trainer dalam membawakan materi</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_2[]" class="icheck" id="form-check-5-b">
															</div>
															<div class="col-10">
																<label for="form-check-5-b">Fasilitator dalam membantu pembelajaran</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_2[]" class="icheck" id="form-check-6-b">
															</div>
															<div class="col-10">
																<label for="form-check-6-b">Fasilitas pendukung (ruangan, suasana kelas, snack, dll)</label>
															</div>
														</div>
													</div>
													<div class="form-group radio_input">
														<div class="row">
															<div class="col-2">
															<input type="checkbox" value="Professional" name="question_2[]" class="icheck" id="form-check-7-b">
															</div>
															<div class="col-10">
																<label for="form-check-7-b">Pelayanan peserta (Alat tulis, marchendise, paparan materi, dll)</label>
															</div>
														</div>
													</div>
													<div class="form-group">
														<input type="text" name="hal-lain_form" class="form-control" placeholder="Tuliskan hal lain jika ada">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <input type="text" name="testimoni_keseluruhan" class="form-control" placeholder=" Testimoni untuk keseluruhan training">
		                                        </div>
		                                    </div>
											<div class="col-md-12">
		                                        <div class="form-group">
		                                            <input type="text" name="topik_selanjutnya" class="form-control" placeholder=" Topik training selanjutnya yang Anda butuhkan">
		                                        </div>
		                                    </div>
		                                    <!-- /col-sm-12 -->
		                                </div>
										<!--  -->
		                            </fieldset><!-- End Step six -->
		                            <input type="submit" class="finish" value="Finish!">
		                        </form>
		                    </div>
		                </div><!-- /Row -->
		            </div><!-- /Form_container -->
		            
		        </div>
		    </div>
		    <!-- End row -->
		</main>
	</div>
	<!-- /flex-column -->

	<footer>
        <div class="container-fluid">
            <p>© 2023 Mastenia</p>
			<ul>
				<li><a href="#0" class="animated_link">Purchase template</a></li>
				<li><a href="#0" class="animated_link">Contacts</a></li>
			</ul>
        </div>
        <!-- /Container -->
    </footer>
    <!-- /Footer -->

    </div>
	<!-- /flex-column -->

	<div class="cd-overlay-nav">
		<span></span>
	</div>
	<!-- cd-overlay-nav -->

	<div class="cd-overlay-content">
		<span></span>
	</div>
	<!-- cd-overlay-content -->

	<a href="#0" class="cd-nav-trigger">Menu<span class="cd-icon"></span></a>

	<!-- Modal terms -->
	<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="termsLabel">Terms and conditions</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn_1" data-bs-dismiss="modal">Close</button>
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
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
					<p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn_1" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<!-- SCRIPTS -->
	<script src="{{asset('test-form/js/common_scripts.js')}}"></script>
	<!-- Wizard script -->
	<script src="{{asset('test-form/js/sign-up-validate.js')}}"></script> 
	<!-- Menu script -->
	<script src="{{asset('test-form/js/velocity.min.js')}}"></script>
	<script src="{{asset('test-form/js/main.js')}}"></script>
	<!-- Theme script -->
	<script src="{{asset('test-form/js/functions.js')}}"></script>

</body>
</html>