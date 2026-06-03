@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-1">
            <i class="fas fa-users me-2" style="color: var(--primary);"></i>Customers
        </h1>
        <p class="text-muted mb-0">All registered customer accounts</p>
    </div>
    <a href="{{ route('register') }}" class="btn btn-primary">
        <i class="fas fa-user-plus me-2"></i>Add New User
    </a>
</div>

<div class="card border-0">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background: #f8fafc;">
                <tr>
                    <th class="fw-600 text-uppercase small">Name</th>
                    <th class="fw-600 text-uppercase small">Email</th>
                    <th class="fw-600 text-uppercase small">Gender</th>
                    <th class="fw-600 text-uppercase small">Address</th>
                    <th class="fw-600 text-uppercase small">Joined</th>
                    <th class="fw-600 text-uppercase small">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td class="fw-500">
                            @if($user->profile_photo)
                                <img src="{{ asset($user->profile_photo) }}" alt="{{ $user->name }}" class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                            @else
                                <span class="badge rounded-circle me-2" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: white;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            @endif
                            {{ $user->name }}
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td><span class="badge bg-light text-dark">{{ $user->gender ?? 'Not specified' }}</span></td>
                        <td class="text-muted small">{{ $user->address ? Illuminate\Support\Str::limit($user->address, 30) : '—' }}</td>
                        <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-2 me-2" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $user->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-2" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal{{ $user->id }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 1rem;"></i>
                            No customers yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Edit Customer Modals (Dynamic for each customer) -->
@foreach($users as $user)
<div class="modal fade" id="editCustomerModal{{ $user->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="editCustomerModalLabel{{ $user->id }}">
                    <i class="fas fa-edit me-2" style="color: var(--primary);"></i>Edit Customer Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('customer.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_name{{ $user->id }}">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" id="edit_name{{ $user->id }}" name="name" class="form-control form-control-lg" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_email{{ $user->id }}">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email
                        </label>
                        <input type="email" id="edit_email{{ $user->id }}" name="email" class="form-control form-control-lg" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_gender{{ $user->id }}">
                            <i class="fas fa-venus-mars me-2" style="color: var(--primary);"></i>Gender
                        </label>
                        <select id="edit_gender{{ $user->id }}" name="gender" class="form-select form-select-lg">
                            <option value="">-- Select Gender --</option>
                            <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_address{{ $user->id }}">
                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary);"></i>Address
                        </label>
                        <textarea id="edit_address{{ $user->id }}" name="address" class="form-control form-control-lg" rows="3">{{ $user->address }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary rounded-3">
                        <i class="fas fa-save me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Customer Modal -->
<div class="modal fade" id="deleteCustomerModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteCustomerModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="deleteCustomerModalLabel{{ $user->id }}">
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Delete Customer Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-3">
                    Are you sure you want to delete <strong>{{ $user->name }}'s</strong> customer account?
                </p>
                <p class="text-muted small">
                    This action will permanently remove the customer account and all associated data including orders, cart, and profile information.
                </p>
                <div class="alert alert-warning mt-3" role="alert">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Note:</strong> This action cannot be undone.
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <form method="POST" action="{{ route('customer.destroy', $user->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3">
                        <i class="fas fa-trash-alt me-1"></i>Delete Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
