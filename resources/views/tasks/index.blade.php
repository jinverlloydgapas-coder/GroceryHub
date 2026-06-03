@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-1">
            <i class="fas fa-shopping-cart me-2" style="color: var(--primary);"></i>My Grocery List
        </h1>
        <p class="text-muted mb-0">Manage your grocery shopping items</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary rounded-3 fw-600">
        <i class="fas fa-plus me-2"></i>Add Item
    </a>
</div>

<div class="card border-0">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background: #f8fafc;">
                <tr>
                    <th class="fw-600 text-uppercase small">Item Name</th>
                    <th class="fw-600 text-uppercase small">Quantity</th>
                    <th class="fw-600 text-uppercase small">Status</th>
                    <th class="fw-600 text-uppercase small">Added</th>
                    <th class="fw-600 text-uppercase small text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr style="border-bottom: 1px solid var(--border-color); transition: all 0.2s ease; animation: fadeInUp 0.5s ease;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.transform='translateX(2px)'" onmouseout="this.style.backgroundColor='transparent'; this.style.transform='translateX(0)'">
                        <td class="fw-500">
                            <i class="fas fa-shopping-bag me-2" style="color: var(--primary);"></i>{{ $task->title }}
                        </td>
                        <td class="text-muted">
                            <span class="badge bg-light">{{ $task->quantity }} {{ $task->unit }}</span>
                        </td>
                        <td>
                            @if($task->status === 'bought')
                                <span class="badge bg-success" style="background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;">
                                    <i class="fas fa-check-circle me-1"></i>Bought
                                </span>
                            @else
                                <span class="badge" style="background: linear-gradient(135deg, #8b6f47 0%, #6b5336 100%); color: white;">
                                    <i class="fas fa-hourglass-half me-1"></i>Pending
                                </span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $task->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary rounded-2 me-2">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $task->id }}">
                                        <i class="fas fa-exclamation-triangle me-2" style="color: var(--danger);"></i>Delete Item
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-3">
                                    <p class="mb-0">Are you sure you want to delete <strong>{{ $task->title }}</strong>? This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox empty-state-icon"></i>
                                <p class="mb-2 h6">No grocery items yet</p>
                                <p class="mb-3 text-muted small">Add your first item to get started</p>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm rounded-3">
                                    <i class="fas fa-plus me-1"></i>Add First Item
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <nav aria-label="Page navigation">
        {{ $tasks->links('pagination::bootstrap-5') }}
    </nav>
</div>
@endsection
