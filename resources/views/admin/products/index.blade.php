@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-1">
            <i class="fas fa-shopping-cart me-2" style="color: var(--primary);"></i>Manage Products
        </h1>
        <p class="text-muted mb-0">Public catalog items available for customers</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-3 fw-600">
        <i class="fas fa-plus me-2"></i>Add Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background: #f8fafc;">
                <tr>
                    <th class="fw-600 text-uppercase small">Product Name</th>
                    <th class="fw-600 text-uppercase small">Quantity</th>
                    <th class="fw-600 text-uppercase small">Unit</th>
                    <th class="fw-600 text-uppercase small">Description</th>
                    <th class="fw-600 text-uppercase small">Added</th>
                    <th class="fw-600 text-uppercase small text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td class="fw-500">
                            <i class="fas fa-leaf me-2" style="color: var(--primary);"></i>{{ $product->title }}
                        </td>
                        <td>{{ $product->quantity }}</td>
                        <td><span class="badge bg-light text-dark">{{ $product->unit }}</span></td>
                        <td class="text-muted small">{{ $product->notes ? Illuminate\Support\Str::limit($product->notes, 40) : '—' }}</td>
                        <td class="text-muted">{{ $product->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary rounded-2 me-2">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title">
                                        <i class="fas fa-exclamation-triangle me-2" style="color: var(--danger);"></i>Delete Product
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body py-3">
                                    <p class="mb-0">Delete <strong>{{ $product->title }}</strong>? This cannot be undone.</p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.products.delete', $product) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 1rem;"></i>
                            No products yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
