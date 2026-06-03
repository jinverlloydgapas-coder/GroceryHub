<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $users = User::all();
        $customers = User::where('role', 'customer')->get();
        return view('profile.edit', ['user' => Auth::user(), 'users' => $users, 'customers' => $customers]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'address' => ['nullable', 'string', 'max:500'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->gender = $validated['gender'];
        $user->address = $validated['address'];

        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $filename = Str::slug($user->name) . '-' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('profile_photos'), $filename);
            $user->profile_photo = 'profile_photos/' . $filename;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy()
    {
        $user = Auth::user();

        // Delete user's profile photo if exists
        if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
            unlink(public_path($user->profile_photo));
        }

        // Delete user's related data (if you have any)
        // For example, if user has tasks, delete them
        if (method_exists($user, 'tasks')) {
            $user->tasks()->delete();
        }

        // Delete user's cart items
        if (method_exists($user, 'cart')) {
            $user->cart()->delete();
        }

        // Delete the user account
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

    // User Management Methods
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:customer,admin'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('profile.edit')->with('success', 'User added successfully!');
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:customer,admin'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('profile.edit')->with('success', 'User updated successfully!');
    }

    public function destroyUser(User $user)
    {
        // Delete user's profile photo if exists
        if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
            unlink(public_path($user->profile_photo));
        }

        // Delete user's related data
        if (method_exists($user, 'tasks')) {
            $user->tasks()->delete();
        }

        if (method_exists($user, 'cart')) {
            $user->cart()->delete();
        }

        $user->delete();

        return redirect()->route('profile.edit')->with('success', 'User deleted successfully!');
    }

    // Customer Management Methods (Admin Only)
    public function storeCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        return redirect()->route('profile.edit')->with('success', 'Customer account created successfully!');
    }

    public function updateCustomer(Request $request, User $customer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $customer->id],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('profile.edit')->with('success', 'Customer account updated successfully!');
    }

    public function destroyCustomer(User $customer)
    {
        // Delete customer's profile photo if exists
        if ($customer->profile_photo && file_exists(public_path($customer->profile_photo))) {
            unlink(public_path($customer->profile_photo));
        }

        // Delete customer's related data
        if (method_exists($customer, 'tasks')) {
            $customer->tasks()->delete();
        }

        if (method_exists($customer, 'cart')) {
            $customer->cart()->delete();
        }

        $customer->delete();

        return redirect()->route('profile.edit')->with('success', 'Customer account deleted successfully!');
    }

    public function applyForAdmin()
    {
        $user = Auth::user();

        // If already admin, show message
        if ($user->role === 'admin') {
            return redirect()->route('profile.edit')->with('success', 'You are already an admin!');
        }

        // Upgrade customer to admin
        $user->update(['role' => 'admin']);

        return redirect()->route('profile.edit')->with('success', 'You have successfully upgraded to admin! You now have access to all admin features.');
    }
}
