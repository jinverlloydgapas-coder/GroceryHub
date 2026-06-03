@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="mb-4">
            <h1 class="h3 fw-semibold mb-1">
                <i class="fas fa-plus-circle me-2" style="color: var(--primary);"></i>Add Grocery Item
            </h1>
            <p class="text-muted">Add a new item to your grocery list</p>
        </div>

        <div class="card border-0">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label fw-500">
                            <i class="fas fa-shopping-bag me-2" style="color: var(--primary);"></i>Item Name
                        </label>
                        <input type="text" id="title" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g., Tomatoes, Milk, Bread">
                        @error('title')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-500">
                                    <i class="fas fa-calculator me-2" style="color: var(--primary);"></i>Quantity
                                </label>
                                <input type="number" id="quantity" name="quantity" class="form-control form-control-lg @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" min="1" required placeholder="Enter quantity">
                                @error('quantity')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unit" class="form-label fw-500">
                                    <i class="fas fa-ruler me-2" style="color: var(--primary);"></i>Unit
                                </label>
                                <select id="unit" name="unit" class="form-select form-control-lg @error('unit') is-invalid @enderror" required>
                                    <option value="pieces" {{ old('unit') === 'pieces' ? 'selected' : '' }}>Pieces</option>
                                    <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                    <option value="g" {{ old('unit') === 'g' ? 'selected' : '' }}>Grams (g)</option>
                                    <option value="liters" {{ old('unit') === 'liters' ? 'selected' : '' }}>Liters (L)</option>
                                    <option value="ml" {{ old('unit') === 'ml' ? 'selected' : '' }}>Milliliters (ml)</option>
                                    <option value="boxes" {{ old('unit') === 'boxes' ? 'selected' : '' }}>Boxes</option>
                                    <option value="packs" {{ old('unit') === 'packs' ? 'selected' : '' }}>Packs</option>
                                    <option value="bottles" {{ old('unit') === 'bottles' ? 'selected' : '' }}>Bottles</option>
                                </select>
                                @error('unit')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-500">
                            <i class="fas fa-clipboard me-2" style="color: var(--primary);"></i>Notes (Optional)
                        </label>
                        <textarea id="notes" name="notes" rows="4" class="form-control form-control-lg @error('notes') is-invalid @enderror" placeholder="Add any notes or preferences...">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-500">
                            <i class="fas fa-flag me-2" style="color: var(--primary);"></i>Status
                        </label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="status" id="status_pending" value="pending" {{ old('status', 'pending') === 'pending' ? 'checked' : '' }} required>
                            <label class="btn btn-outline-warning" for="status_pending" style="color: #d97706; border-color: #d97706;">
                                <i class="fas fa-hourglass-half me-2"></i>Pending
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_bought" value="bought" {{ old('status') === 'bought' ? 'checked' : '' }} required>
                            <label class="btn btn-outline-success" for="status_bought" style="color: #059669; border-color: #059669;">
                                <i class="fas fa-check-circle me-2"></i>Bought
                            </label>
                        </div>
                        @error('status')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="d-grid gap-2 d-sm-flex">
                        <button type="submit" class="btn btn-primary btn-lg fw-600 rounded-3">
                            <i class="fas fa-save me-2"></i>Add Item
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-lg rounded-3">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
