@extends('layouts.guest')

@section('content')
<div class="container-fluid py-5">
    <!-- Hero Section -->
    <div class="hero-section mb-5" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 16px; padding: 4rem 2rem; margin-bottom: 3rem;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">
                    <i class="fas fa-leaf me-3"></i>Fresh Groceries Delivered
                </h1>
                <p style="font-size: 1.2rem; margin-bottom: 1.5rem; opacity: 0.95;">
                    Browse our wide selection of fresh produce, vegetables, and grocery items. Create an account to start shopping!
                </p>
                <p style="opacity: 0.85;">Sign in or create an account to add items to your cart and make your purchase.</p>
            </div>
            <div class="col-lg-5 text-center">
                <i class="fas fa-shopping-bag" style="font-size: 6rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>

    <!-- Browse Section -->
    <div class="mb-5" id="grocery">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">
                    <i class="fas fa-shopping-cart me-2" style="color: #10b981;"></i>Fresh Grocery Items
                </h2>
                <p style="color: #6b7280; margin: 0;">Browse our selection without creating an account. Sign in to add items to your list.</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <form action="{{ route('home') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control rounded-3" placeholder="Search groceries..." value="{{ request('search') }}" style="max-width: 400px;">
                <button type="submit" class="btn btn-primary rounded-3">
                    <i class="fas fa-search me-2"></i>Search
                </button>
                @if(request('search'))
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-3">Clear</a>
                @endif
            </form>
        </div>

        @php
            $query = \App\Models\Task::whereNull('user_id');
            if(request('search')) {
                $search = request('search');
                $query->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('notes', 'LIKE', "%{$search}%");
            }
            $items = $query->get();
        @endphp

        @if($items->isNotEmpty())
            <div class="row g-4">
                @foreach($items as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
                            onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(16, 185, 129, 0.15)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.05)'">
                            
                            <!-- Product Image/Icon -->
                            <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 2rem; text-align: center; min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                @if(strpos(strtolower($item->title), 'apple') !== false || strpos(strtolower($item->title), 'orange') !== false || strpos(strtolower($item->title), 'banana') !== false)
                                    <i class="fas fa-apple-alt" style="font-size: 3rem; color: #10b981; opacity: 0.7;"></i>
                                @elseif(strpos(strtolower($item->title), 'carrot') !== false || strpos(strtolower($item->title), 'broccoli') !== false || strpos(strtolower($item->title), 'spinach') !== false)
                                    <i class="fas fa-leaf" style="font-size: 3rem; color: #10b981; opacity: 0.7;"></i>
                                @else
                                    <i class="fas fa-shopping-basket" style="font-size: 3rem; color: #10b981; opacity: 0.7;"></i>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div style="padding: 1.5rem;">
                                <h5 style="font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; font-size: 1rem;">
                                    {{ $item->title }}
                                </h5>
                                
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                    {{ $item->quantity }} {{ $item->unit }}
                                    @if($item->notes)
                                        • {{ Illuminate\Support\Str::limit($item->notes, 30) }}
                                    @endif
                                </p>

                                <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                                    <span class="badge" style="background: #d1fae5; color: #059669; font-size: 0.75rem; padding: 0.4rem 0.75rem;">
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    </span>
                                </div>

                                @guest
                                    <a href="{{ route('login') }}" class="btn btn-sm w-100" style="background: #10b981; color: white; border: none; font-weight: 600; padding: 0.6rem; border-radius: 6px; transition: all 0.3s ease; text-decoration: none;">
                                        <i class="fas fa-shopping-cart me-1"></i>Sign In to Buy
                                    </a>
                                @else
                                    <button type="button" class="btn btn-sm w-100" style="background: #10b981; color: white; border: none; font-weight: 600; padding: 0.6rem; border-radius: 6px; transition: all 0.3s ease; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#quantityModal{{ $item->id }}">
                                        <i class="fas fa-plus me-1"></i>Add to List
                                    </button>

                                    <!-- Quantity Modal -->
                                    <div class="modal fade" id="quantityModal{{ $item->id }}" tabindex="-1" aria-labelledby="quantityModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title" id="quantityModalLabel{{ $item->id }}">
                                                        <i class="fas fa-shopping-cart me-2" style="color: #10b981;"></i>How many would you like?
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('tasks.addFromCatalog', $item) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body py-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-600 mb-2">Item: <strong>{{ $item->title }}</strong></label>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="quantity{{ $item->id }}" class="form-label fw-600">Quantity</label>
                                                            <div class="input-group">
                                                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty('qty{{ $item->id }}')">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" id="qty{{ $item->id }}" name="quantity" class="form-control text-center" value="{{ $item->quantity }}" min="1" style="font-weight: 600; font-size: 1.1rem;">
                                                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQty('qty{{ $item->id }}')">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="mb-0">
                                                            <p class="text-muted small">
                                                                <i class="fas fa-info-circle me-1"></i>Default quantity: {{ $item->quantity }} {{ $item->unit }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-check me-1"></i>Add to List
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div style="background: white; border-radius: 12px; padding: 4rem 2rem; text-align: center; border: 1px solid #e5e7eb;">
                <i class="fas fa-box-open" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                <h3 style="color: #1f2937; font-weight: 700; margin-bottom: 0.5rem;">No Items Available</h3>
                <p style="color: #6b7280; margin: 0;">Check back soon for fresh groceries!</p>
            </div>
        @endif
    </div>

    <!-- CTA Section -->
    @guest
        <div style="background: white; border: 2px solid #10b981; border-radius: 12px; padding: 3rem 2rem; text-align: center; margin: 3rem 0;">
            <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">Ready to Shop Fresh Groceries?</h3>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">Create an account today and get access to our full catalog. Sign up now to start shopping!</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('signup') }}" class="btn" style="background: #10b981; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; font-weight: 600; text-decoration: none;">
                    <i class="fas fa-user-plus me-1"></i>Create Account
                </a>
                <a href="{{ route('login') }}" class="btn" style="background: white; color: #10b981; padding: 0.75rem 1.5rem; border: 2px solid #10b981; border-radius: 6px; font-weight: 600; text-decoration: none;">
                    <i class="fas fa-sign-in-alt me-1"></i>Sign In
                </a>
            </div>
        </div>
    @endguest

    <!-- About Us Section -->
    <div style="background: white; border-radius: 12px; padding: 3rem 2rem; margin: 3rem 0; border: 1px solid #e5e7eb;" id="about">
        <h2 style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">
            <i class="fas fa-info-circle me-2" style="color: #10b981;"></i>About GroceryHub
        </h2>
        <div class="row g-4">
            <div class="col-md-6">
                <h4 style="font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Who We Are</h4>
                <p style="color: #6b7280; line-height: 1.6;">
                    GroceryHub is your go-to online marketplace for fresh groceries. We connect you with the finest selection of vegetables, fruits, and everyday essentials. Our mission is to make healthy eating accessible and convenient for everyone.
                </p>
            </div>
            <div class="col-md-6">
                <h4 style="font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Why Choose Us</h4>
                <ul style="color: #6b7280; line-height: 1.8; margin: 0; padding-left: 1.5rem;">
                    <li>🌱 Fresh and organic products</li>
                    <li>🚚 Quick and reliable delivery</li>
                    <li>💚 Competitive pricing</li>
                    <li>🔒 Secure and easy checkout</li>
                    <li>📱 User-friendly mobile app</li>
                </ul>
            </div>
        </div>
    </div>

<style>
    .product-card {
        height: 100%;
    }

    .product-card:hover {
        box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15) !important;
    }
</style>

<script>
    function increaseQty(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
        }
    }

    function decreaseQty(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    }

    // Initialize quantity input event listeners when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Allow direct number input in quantity fields
        document.querySelectorAll('input[id^="qty"]').forEach(input => {
            input.addEventListener('change', function() {
                const value = parseInt(this.value);
                if (isNaN(value) || value < 1) {
                    this.value = 1;
                }
            });
        });
    });
</script>
@endsection
