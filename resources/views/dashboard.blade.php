@extends('layouts.app')

@section('content')
<div class="row gy-4">
    <!-- Header -->
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-2">
            <div>
                <h1 class="h3 fw-semibold mb-1">
                    <i class="fas fa-chart-line me-2" style="color: var(--primary);"></i>Dashboard
                </h1>
                <p class="text-muted mb-0">Hello, <strong>{{ $currentUser->name }}</strong>. Here's your overview.</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 overflow-hidden h-100" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="d-block fw-600 small mb-2" style="opacity: 0.9;">Total Users</span>
                        <span class="display-5 fw-bold">{{ $userCount }}</span>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.2);">
                        <i class="fas fa-users" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 overflow-hidden h-100" style="background: linear-gradient(135deg, #8b6f47 0%, #6b5336 100%); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(139, 111, 71, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="d-block fw-600 small mb-2" style="opacity: 0.9;">My Items</span>
                        <span class="display-5 fw-bold">@php echo \App\Models\Task::where('user_id', auth()->id())->count(); @endphp</span>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.2);">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 overflow-hidden h-100" style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(52, 211, 153, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="d-block fw-600 small mb-2" style="opacity: 0.9;">Total you bought</span>
                        <span class="display-5 fw-bold">{{ \App\Models\Task::where('user_id', auth()->id())->where('status', 'bought')->count() }}</span>
                    </div>
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.2);">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="col-lg-6">
        <div class="card border-0 h-100">
            <div class="card-body">
                <h3 class="h6 mb-3 fw-600">
                    <i class="fas fa-shopping-cart me-2" style="color: var(--primary);"></i>Your Recent Grocery Items
                </h3>
                @php $recentTasks = \App\Models\Task::where('user_id', auth()->id())->latest()->take(5)->get(); @endphp
                @if($recentTasks->isNotEmpty())
                    <div class="list-group list-group-flush">
                        @foreach($recentTasks as $task)
                            <div class="list-group-item px-0 py-3 border-bottom task-item" data-task-id="{{ $task->id }}">
                                <div class="fw-500 mb-1 d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center gap-2" style="flex: 1;">
                                        <input type="checkbox" class="task-checkbox" style="width: 18px; height: 18px; cursor: pointer;" {{ $task->status === 'bought' ? 'checked' : '' }}>
                                        <div class="task-title" style="opacity: {{ $task->status === 'bought' ? '0.6' : '1' }};">
                                            <i class="fas fa-shopping-bag me-2" style="color: var(--primary);"></i>{{ $task->title }}
                                        </div>
                                    </div>
                                    @if($task->status === 'bought')
                                        <span class="badge bg-success" style="background: linear-gradient(135deg, #059669 0%, #047857 100%) !important; font-size: 0.7rem;">
                                            <i class="fas fa-check-circle me-1"></i>Bought
                                        </span>
                                    @else
                                        <span class="badge" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: white; font-size: 0.7rem;">
                                            <i class="fas fa-hourglass-half me-1"></i>Pending
                                        </span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $task->quantity }} {{ $task->unit }} • {{ \Illuminate\Support\Str::limit($task->notes ?? 'No notes', 40) }}</small>
                                <div class="text-muted" style="font-size: 0.75rem; margin-top: 5px;">
                                    <i class="fas fa-calendar me-1"></i>{{ $task->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox empty-state-icon"></i>
                        <p class="mb-0">No grocery items yet</p>
                        <p class="text-muted small mt-2 mb-3">Add your first item to get started</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary rounded-3">
                            <i class="fas fa-plus me-1"></i>Add Item
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Color scheme
    const primaryColor = '#10b981';
    const successColor = '#059669';
    const warningColor = '#8b6f47';
    const dangerColor = '#34d399';

    // Activity Overview Chart
    const ctxSummary = document.getElementById('summaryChart');
    if (ctxSummary) {
        new Chart(ctxSummary, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Users',
                    data: [{{ $userCount }}, {{ max(1, $userCount - 2) }}, {{ max(1, $userCount - 1) }}, {{ $userCount }}],
                    borderColor: primaryColor,
                    backgroundColor: 'rgba(51, 65, 85, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: primaryColor,
                    pointBorderWidth: 0,
                    yAxisID: 'y'
                },
                {
                    label: 'Records',
                    data: [{{ $taskCount }}, {{ max(2, $taskCount - 3) }}, {{ max(1, $taskCount - 2) }}, {{ $taskCount }}],
                    borderColor: warningColor,
                    backgroundColor: 'rgba(217, 119, 6, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: warningColor,
                    pointBorderWidth: 0,
                    yAxisID: 'y1'
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { 
                        display: true,
                        labels: { usePointStyle: true, padding: 15, font: { size: 12, weight: '500' } }
                    }
                },
                scales: {
                    y: { 
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: { drawOnChartArea: false },
                    },
                    x: { grid: { display: false } }
                },
            },
        });
    }

    // Task checkbox toggle
    document.querySelectorAll('.task-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', async function() {
            const taskItem = this.closest('.task-item');
            const taskId = taskItem.dataset.taskId;
            const badge = taskItem.querySelector('.badge');
            const titleDiv = taskItem.querySelector('.task-title');

            try {
                const response = await fetch(`/tasks/${taskId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update badge
                    if (data.status === 'bought') {
                        badge.innerHTML = '<i class="fas fa-check-circle me-1"></i>Bought';
                        badge.style.background = 'linear-gradient(135deg, #059669 0%, #047857 100%)';
                        badge.style.color = 'white';
                        titleDiv.style.textDecoration = 'line-through';
                        titleDiv.style.opacity = '0.6';
                    } else {
                        badge.innerHTML = '<i class="fas fa-hourglass-half me-1"></i>Pending';
                        badge.style.background = 'linear-gradient(135deg, #d97706 0%, #b45309 100%)';
                        badge.style.color = 'white';
                        titleDiv.style.textDecoration = 'none';
                        titleDiv.style.opacity = '1';
                    }

                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(data.message, 'Success', { timeOut: 2000 });
                    }
                } else {
                    this.checked = !this.checked;
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Failed to update item', 'Error');
                    }
                }
            } catch (error) {
                this.checked = !this.checked;
                console.error('Error:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('An error occurred', 'Error');
                }
            }
        });
    });
</script>
@endpush
