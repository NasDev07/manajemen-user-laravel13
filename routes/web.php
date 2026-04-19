<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Welcome/home page - accessible to everyone
Route::get('/', function () {
    // Redirect authenticated users to their dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Guest middleware group
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    })->name('login.store');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'email_verified_at' => now(),
        ]);

        // Assign default 'user' role
        $user->syncRoles(['user']);

        Auth::login($user);

        return redirect()->route('dashboard');
    })->name('register.store');
});

// Logout route
Route::middleware('auth')->post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Protected Routes - Authenticated Users Only
Route::middleware('auth')->group(function () {

    // Dashboard routes - role-specific redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('dashboards.admin');
        } elseif ($user->hasRole('manager')) {
            return redirect()->route('dashboards.manager');
        } else {
            return redirect()->route('dashboards.user');
        }
    })->name('dashboard');

    // Admin Dashboard
    Route::get('/dashboards/admin', function () {
        return view('dashboards.admin');
    })->middleware('role:admin')->name('dashboards.admin');

    // Manager Dashboard
    Route::get('/dashboards/manager', function () {
        return view('dashboards.manager');
    })->middleware('role:admin,manager')->name('dashboards.manager');

    // User Dashboard
    Route::get('/dashboards/user', function () {
        return view('dashboards.user');
    })->middleware('role:user,admin,manager')->name('dashboards.user');

    // User Management Routes - Admin/Manager only
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Profile Routes
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});
