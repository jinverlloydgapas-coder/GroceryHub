@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-1">
            <i class="fas fa-tachometer-alt me-2" style="color: var(--primary);"></i>Admin Dashboard
        </h1>
        <p class="text-muted mb-0">Owner overview of grocery activity</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom pb-3">
                <h5 class="mb-0">
                    <i class="fas fa-crown me-2" style="color: var(--primary);"></i>Most Bought Items
                </h5>
            </div>
            <div class="card-body">
                @forelse($mostBought as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-500">{{ $item->title }}</span>
                        <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">{{ $item->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom pb-3">
                <h5 class="mb-0">
                    <i class="fas fa-arrow-down me-2" style="color: #8b6f47;"></i>Least Bought Items
                </h5>
            </div>
            <div class="card-body">
                @forelse($leastBought as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-500">{{ $item->title }}</span>
                        <span class="badge bg-warning text-dark">{{ $item->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom pb-3">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2" style="color: #6b5336;"></i>Most Pending Requests
                </h5>
            </div>
            <div class="card-body">
                @forelse($mostPending as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-500">{{ $item->title }}</span>
                        <span class="badge bg-secondary text-white">{{ $item->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom pb-3">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2" style="color: var(--primary);"></i>Quick Admin Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Manage Products
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-users me-2"></i>View Customers
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
