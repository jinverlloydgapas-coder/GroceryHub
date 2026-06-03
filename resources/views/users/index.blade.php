@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-1">
            <i class="fas fa-users me-2" style="color: var(--primary);"></i>Users Management
        </h1>
        <p class="text-muted mb-0">Manage all application users with ease.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary rounded-3 fw-600">
        <i class="fas fa-user-plus me-2"></i>Add User
    </a>
</div>

<div class="card border-0">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background: #f8fafc;">
                <tr>
                    <th class="fw-600 text-uppercase small">Name</th>
                    <th class="fw-600 text-uppercase small">Email</th>
                    <th class="fw-600 text-uppercase small">Created</th>
                    <th class="fw-600 text-uppercase small text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr style="border-bottom: 1px solid var(--border-color); transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
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
                        <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary rounded-2 me-2">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox empty-state-icon"></i>
                                <p class="mb-2 h6">No users found</p>
                                <p class="mb-3 text-muted small">Get started by creating your first user account</p>
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm rounded-3">
                                    <i class="fas fa-user-plus me-1"></i>Create First User
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modals - Moved outside table -->
@forelse($users as $user)
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                        <i class="fas fa-exclamation-triangle me-2" style="color: var(--danger);"></i>Delete User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete-confirm-btn" data-form-id="deleteForm{{ $user->id }}">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hidden Delete Form -->
    <form id="deleteForm{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@empty
@endforelse

<div class="mt-4">
    <nav aria-label="Page navigation">
        {{ $users->links('pagination::bootstrap-5') }}
    </nav>
</div>

<script>
    document.querySelectorAll('.delete-confirm-btn').forEach(button => {
        button.addEventListener('click', function() {
            const formId = this.getAttribute('data-form-id');
            const form = document.getElementById(formId);
            if (form) {
                form.submit();
            }
        });
    });
</script>
@endsection
