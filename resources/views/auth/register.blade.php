<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register - User Management System</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">
  
  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css">
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
  
  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
  
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .register-container {
      width: 100%;
      max-width: 450px;
      padding: 20px;
    }
    
    .register-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      padding: 40px;
    }
    
    .register-logo {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .register-logo h4 {
      color: #667eea;
      font-weight: 700;
      margin-bottom: 10px;
    }
    
    .register-logo p {
      color: #999;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin: 0;
    }
  </style>
</head>

<body>
  <div class="register-container">
    <div class="register-card">
      <div class="register-logo">
        <h4>User Management System</h4>
        <p>Create New Account</p>
      </div>

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
          <strong>Registration Failed!</strong>
          <ul class="mb-0 mt-2 ps-3">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <form method="POST" action="{{ route('register.store') }}" class="mb-3">
        @csrf

        <div class="mb-3">
          <label class="form-label" for="name">Full Name</label>
          <input 
            type="text" 
            class="form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            placeholder="John Doe"
            value="{{ old('name') }}"
            required
          >
          @error('name')
            <small class="invalid-feedback">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="email">Email Address</label>
          <input 
            type="email" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email" 
            name="email" 
            placeholder="john@example.com"
            value="{{ old('email') }}"
            required
          >
          @error('email')
            <small class="invalid-feedback">{{ $message }}</small>
          @enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="password">Password</label>
            <input 
              type="password" 
              class="form-control @error('password') is-invalid @enderror" 
              id="password" 
              name="password" 
              placeholder="••••••••"
              required
            >
            <small class="text-muted">Min. 8 characters</small>
            @error('password')
              <small class="invalid-feedback d-block">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input 
              type="password" 
              class="form-control @error('password_confirmation') is-invalid @enderror" 
              id="password_confirmation" 
              name="password_confirmation" 
              placeholder="••••••••"
              required
            >
            @error('password_confirmation')
              <small class="invalid-feedback d-block">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
          <label class="form-check-label small" for="agree">
            I agree to the terms and conditions
          </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2">
          Create Account
        </button>
      </form>

      <div class="divider text-center my-3" style="position: relative;">
        <span style="background: white; padding: 0 10px; color: #ccc; font-size: 12px;">OR</span>
      </div>

      <p class="text-center small text-muted mb-0">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a>
      </p>
    </div>
  </div>

  <!-- Core JS -->
  <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
