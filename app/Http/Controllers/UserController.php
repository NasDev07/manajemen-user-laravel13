<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  /**
   * Display a listing of all users with their roles via eager loading
   * Using eager loading prevents N+1 query problem
   */
  public function index(Request $request)
  {
    $query = User::query()
      ->with('roles')  // Eager load roles relationship
      ->orderBy('created_at', 'desc');

    // Filter by role if provided
    if ($request->has('role') && !empty($request->role)) {
      $query->whereHas('roles', function (Builder $q) use ($request) {
        $q->where('name', $request->role);
      });
    }

    // Search by name or email
    if ($request->has('search') && !empty($request->search)) {
      $search = $request->search;
      $query->where(function (Builder $q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%");
      });
    }

    $users = $query->paginate(15);
    $roles = Role::all(); // For filter dropdown

    return view('users.index', compact('users', 'roles'));
  }

  /**
   * Show the form for creating a new user
   */
  public function create()
  {
    $roles = Role::all();
    return view('users.create', compact('roles'));
  }

  /**
   * Store a newly created user in storage
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:8|confirmed',
      'phone' => 'nullable|string|max:20',
      'address' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'country' => 'nullable|string|max:255',
      'postal_code' => 'nullable|string|max:10',
      'is_active' => 'boolean',
      'roles' => 'required|array|min:1',
      'roles.*' => 'exists:roles,id',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => bcrypt($validated['password']),
      'phone' => $validated['phone'] ?? null,
      'address' => $validated['address'] ?? null,
      'city' => $validated['city'] ?? null,
      'country' => $validated['country'] ?? null,
      'postal_code' => $validated['postal_code'] ?? null,
      'is_active' => $validated['is_active'] ?? true,
      'email_verified_at' => now(),
      'profile_completion_percentage' => 50,
    ]);

    // Assign roles - fetch Role models by ID
    $roles = Role::whereIn('id', $validated['roles'])->get();
    $user->syncRoles($roles);

    return redirect()->route('users.index')
      ->with('success', 'User created successfully!');
  }

  /**
   * Display the specified user
   */
  public function show(User $user)
  {
    $user->load('roles'); // Eager load roles
    return view('users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified user
   */
  public function edit(User $user)
  {
    $user->load('roles'); // Eager load current roles
    $roles = Role::all();
    return view('users.edit', compact('user', 'roles'));
  }

  /**
   * Update the specified user in storage
   */
  public function update(Request $request, User $user)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'nullable|string|min:8|confirmed',
      'phone' => 'nullable|string|max:20',
      'address' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'country' => 'nullable|string|max:255',
      'postal_code' => 'nullable|string|max:10',
      'is_active' => 'boolean',
      'roles' => 'required|array|min:1',
      'roles.*' => 'exists:roles,id',
    ]);

    $updateData = [
      'name' => $validated['name'],
      'email' => $validated['email'],
      'phone' => $validated['phone'] ?? null,
      'address' => $validated['address'] ?? null,
      'city' => $validated['city'] ?? null,
      'country' => $validated['country'] ?? null,
      'postal_code' => $validated['postal_code'] ?? null,
      'is_active' => $validated['is_active'] ?? true,
    ];

    // Only update password if provided
    if (!empty($validated['password'])) {
      $updateData['password'] = bcrypt($validated['password']);
    }

    $user->update($updateData);

    // Update roles - fetch Role models by ID
    $roles = Role::whereIn('id', $validated['roles'])->get();
    $user->syncRoles($roles);

    return redirect()->route('users.index')
      ->with('success', 'User updated successfully!');
  }

  /**
   * Remove the specified user from storage
   */
  public function destroy(User $user)
  {
    // Prevent deleting the logged-in user
    if (auth()->id() === $user->id) {
      return back()->with('error', 'You cannot delete your own account!');
    }

    $user->delete();

    return redirect()->route('users.index')
      ->with('success', 'User deleted successfully!');
  }
}
