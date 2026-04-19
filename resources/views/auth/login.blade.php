<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Login - User Management System</title>
  
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
    
    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }
    
    .login-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      padding: 40px;
    }
    
    .login-logo {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .login-logo h4 {
      color: #667eea;
      font-weight: 700;
      margin-bottom: 10px;
    }
    
    .login-logo p {
      color: #999;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin: 0;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-logo">
        <h4>User Management System</h4>
        <p>Administrator Login</p>
      </div>

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
          <strong>Login Failed!</strong>
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
          <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <form method="POST" action="{{ route('login.store') }}" class="mb-3">
        @csrf

        <div class="mb-3">
          <label class="form-label" for="email">Email Address</label>
          <input 
            type="email" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email" 
            name="email" 
            placeholder="admin@example.com"
            value="{{ old('email') }}"
            required 
            autofocus
          >
          @error('email')
            <small class="invalid-feedback">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="password">Password</label>
          <input 
            type="password" 
            class="form-control @error('password') is-invalid @enderror" 
            id="password" 
            name="password" 
            placeholder="••••••••"
            required
          >
          @error('password')
            <small class="invalid-feedback">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember" name="remember">
          <label class="form-check-label" for="remember">
            Remember me
          </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2">
          Sign In
        </button>
      </form>

      <div class="divider text-center my-3" style="position: relative;">
        <span style="background: white; padding: 0 10px; color: #ccc; font-size: 12px;">OR</span>
      </div>

      <p class="text-center small text-muted mb-0">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a>
      </p>
    </div>

    <!-- Demo Credentials -->
    <div style="background: rgba(255, 255, 255, 0.1); color: white; padding: 20px; border-radius: 8px; margin-top: 20px; font-size: 12px; backdrop-filter: blur(10px);">
      <strong>Demo Credentials:</strong>
      <div style="margin-top: 10px; line-height: 1.8;">
        <p class="mb-1"><strong>Admin:</strong> admin@example.com / password123</p>
        <p class="mb-1"><strong>Manager:</strong> manager@example.com / password123</p>
        <p class="mb-0"><strong>User:</strong> user@example.com / password123</p>
      </div>
    </div>
  </div>

  <!-- Core JS -->
  <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
