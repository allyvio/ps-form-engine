<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Assessment Engine - Login">
  <meta name="author" content="Assessment Team">
  <title>Login - Assessment Engine</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('dashboard/img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap/bootstrap.min.css') }}" type="text/css">
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('dashboard/css/argon.css') }}" type="text/css">
</head>

<body class="bg-default">
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Assessment Engine</h1>
              <p class="text-lead text-white">Sistem Asesmen Kompetensi Karyawan</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-header bg-transparent pb-5">
              <div class="text-muted text-center mt-2 mb-3"><small>Masuk dengan email dan password</small></div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus>
                  </div>
                  @error('email')
                    <div class="invalid-feedback d-block">
                      <strong>{{ $message }}</strong>
                    </div>
                  @enderror
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password">
                  </div>
                  @error('password')
                    <div class="invalid-feedback d-block">
                      <strong>{{ $message }}</strong>
                    </div>
                  @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for="customCheckLogin">
                    <span class="text-muted">Ingat saya</span>
                  </label>
                </div>
                
                <!-- Submit Button -->
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-12">
          <div class="copyright text-center text-muted">
            &copy; {{ date('Y') }} <a href="https://peopleshift.id/" class="font-weight-bold ml-1" target="_blank">Peopleshift</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <!-- Argon JS -->
  <script src="{{ asset('dashboard/js/argon.js') }}"></script>
</body>

</html>