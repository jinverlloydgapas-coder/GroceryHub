<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        // Most bought items
        $mostBought = Task::select('title')
            ->where('status', 'bought')
            ->groupBy('title')
            ->selectRaw('count(*) as total')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Least bought items (that have been bought at least once)
        $leastBought = Task::select('title')
            ->where('status', 'bought')
            ->groupBy('title')
            ->selectRaw('count(*) as total')
            ->orderBy('total')
            ->limit(5)
            ->get();

        // Top pending (most requested)
        $mostPending = Task::select('title')
            ->where('status', 'pending')
            ->groupBy('title')
            ->selectRaw('count(*) as total')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('mostBought', 'leastBought', 'mostPending'));
    }

    // Product Management
    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.1',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        // Create public catalog item (user_id = NULL)
        Task::create([
            'title' => $validated['title'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'user_id' => null, // Public catalog
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product added to catalog!');
    }

    public function listProducts()
    {
        $products = Task::whereNull('user_id')->orderByDesc('created_at')->get();
        return view('admin.products.index', compact('products'));
    }

    public function editProduct(Task $product)
    {
        abort_if($product->user_id !== null, 403);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Task $product)
    {
        abort_if($product->user_id !== null, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.1',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product updated!');
    }

    public function deleteProduct(Task $product)
    {
        abort_if($product->user_id !== null, 403);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }

    // User Management
    public function listUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users.index', compact('users'));
    }
}
