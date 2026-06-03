@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="mb-4">
            <h1 class="h3 fw-semibold mb-1">
                <i class="fas fa-user-circle me-2" style="color: var(--primary);"></i>My Profile
            </h1>
            <p class="text-muted">Manage your account and profile information</p>
        </div>

        <!-- Profile Card -->
        <div class="card border-0 mb-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                        @if($user->profile_photo)
                            <img src="{{ asset($user->profile_photo) }}" alt="Profile" class="rounded-circle" width="120" height="120" style="object-fit:cover; border: 4px solid var(--primary);">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width:120px;height:120px;font-size:2.5rem;border: 4px solid var(--primary);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2" style="border: 3px solid white;">
                            <i class="fas fa-check" style="color: white; font-size: 0.8rem;"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h2 class="h5 fw-bold mb-1">{{ $user->name }}</h2>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                        <p class="text-muted small mt-2">
                            <i class="fas fa-calendar-alt me-1"></i>Member since {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="card border-0">
            <div class="card-body p-4">
                <h3 class="h6 mb-3 fw-600 text-uppercase">
                    <i class="fas fa-edit me-2" style="color: var(--primary);"></i>Edit Profile Information
                </h3>
                <hr class="mb-4">

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-500" for="name">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" id="name" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required placeholder="Your full name">
                        @error('name')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500" for="email">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email Address
                        </label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required placeholder="your@email.com">
                        @error('email')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500" for="gender">
                            <i class="fas fa-venus-mars me-2" style="color: var(--primary);"></i>Gender
                        </label>
                        <select id="gender" name="gender" class="form-select form-select-lg @error('gender') is-invalid @enderror">
                            <option value="">-- Select Gender --</option>
                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-500" for="address">
                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary);"></i>Address
                        </label>
                        <textarea id="address" name="address" class="form-control form-control-lg @error('address') is-invalid @enderror" rows="3" placeholder="Your street address">{{ old('address', $user->address) }}</textarea>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>Max 500 characters
                        </small>
                        @error('address')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-500" for="profile_photo">
                            <i class="fas fa-image me-2" style="color: var(--primary);"></i>Profile Photo
                        </label>
                        <div class="input-group">
                            <input type="file" id="profile_photo" name="profile_photo" class="form-control form-control-lg @error('profile_photo') is-invalid @enderror" accept="image/*">
                            <span class="input-group-text" id="file-name-display" style="display:none;">File selected</span>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>Max 2MB. Supported formats: JPG, PNG, GIF, WebP
                        </small>
                        <div id="preview-container" style="display:none; margin-top: 15px; text-align: center;">
                            <img id="preview-image" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 2px solid var(--primary);">
                        </div>
                        @error('profile_photo')<div class="invalid-feedback d-block mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>
                    <script>
                        document.getElementById('profile_photo').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            const fileNameDisplay = document.getElementById('file-name-display');
                            const previewContainer = document.getElementById('preview-container');
                            const previewImage = document.getElementById('preview-image');
                            
                            if (file) {
                                fileNameDisplay.textContent = file.name;
                                fileNameDisplay.style.display = 'inline-block';
                                
                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    previewImage.src = event.target.result;
                                    previewContainer.style.display = 'block';
                                };
                                reader.readAsDataURL(file);
                            } else {
                                fileNameDisplay.style.display = 'none';
                                previewContainer.style.display = 'none';
                            }
                        });
                    </script>

                    <div class="d-grid gap-2 d-sm-flex">
                        <button type="submit" class="btn btn-primary btn-lg fw-600 rounded-3">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg rounded-3">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Info Card -->
        <div class="card border-0 mt-4 bg-light">
            <div class="card-body p-4">
                <h3 class="h6 mb-3 fw-600 text-uppercase">
                    <i class="fas fa-shield-alt me-2" style="color: var(--primary);"></i>Account Information
                </h3>
                <hr class="mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Email Address</small>
                        <strong>{{ $user->email }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Gender</small>
                        <strong>{{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Member Since</small>
                        <strong>{{ $user->created_at->format('F d, Y') }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Account Status</small>
                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Active</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Account Type</small>
                        @if($user->role === 'admin')
                            <span class="badge bg-warning text-dark"><i class="fas fa-crown me-1"></i>Admin</span>
                        @else
                            <span class="badge bg-info"><i class="fas fa-user me-1"></i>Customer</span>
                        @endif
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block mb-1">Address</small>
                        <strong>{{ $user->address ?? 'Not specified' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Last Updated</small>
                        <strong>{{ $user->updated_at->format('F d, Y - H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apply for Admin Card -->
        <div class="card border-0 mt-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="h6 mb-2 fw-600 text-uppercase">
                            <i class="fas fa-crown me-2" style="color: #fbbf24;"></i>Upgrade to Admin
                        </h3>
                        <p class="text-muted mb-0">Apply to upgrade your account to admin and manage products, users, and orders</p>
                    </div>
                    <button type="button" class="btn btn-warning rounded-3 ms-3" data-bs-toggle="modal" data-bs-target="#applyAdminModal">
                        <i class="fas fa-paper-plane me-1"></i>Apply Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Apply for Admin Modal -->
<div class="modal fade" id="applyAdminModal" tabindex="-1" aria-labelledby="applyAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="applyAdminModalLabel">
                    <i class="fas fa-crown me-2" style="color: #fbbf24;"></i>Apply for Admin Access
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-3">
                    Thank you for your interest in becoming an admin! Please review the requirements below:
                </p>
                <div class="alert alert-info" role="alert">
                    <strong>Admin Responsibilities:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Manage product inventory and pricing</li>
                        <li>Monitor and support customer accounts</li>
                        <li>Oversee orders and transactions</li>
                        <li>Maintain platform security and compliance</li>
                    </ul>
                </div>
                <p class="text-muted small">
                    <i class="fas fa-check me-1" style="color: #10b981;"></i>Your application will be reviewed by the platform administrator.
                </p>
                <p class="text-muted small">
                    <i class="fas fa-clock me-1" style="color: #f59e0b;"></i>You will receive a notification within 24-48 hours.
                </p>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <form method="POST" action="{{ route('admin.apply') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning rounded-3">
                        <i class="fas fa-paper-plane me-1"></i>Submit Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-user-plus me-2" style="color: var(--primary);"></i>Add New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addUserForm" method="POST" action="{{ route('user.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-500" for="new_name">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" id="new_name" name="name" class="form-control form-control-lg" required placeholder="John Doe">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="new_email">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email
                        </label>
                        <input type="email" id="new_email" name="email" class="form-control form-control-lg" required placeholder="user@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="new_password">
                            <i class="fas fa-lock me-2" style="color: var(--primary);"></i>Password
                        </label>
                        <input type="password" id="new_password" name="password" class="form-control form-control-lg" required placeholder="Min 8 chars">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="new_role">
                            <i class="fas fa-id-card me-2" style="color: var(--primary);"></i>Role
                        </label>
                        <select id="new_role" name="role" class="form-select form-select-lg" required>
                            <option value="">-- Select Role --</option>
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary rounded-3">
                        <i class="fas fa-plus me-1"></i>Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modals (Dynamic for each user) -->
@foreach($users as $item)
<div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="editUserModalLabel{{ $item->id }}">
                    <i class="fas fa-edit me-2" style="color: var(--primary);"></i>Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.update', $item->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_name{{ $item->id }}">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" id="edit_name{{ $item->id }}" name="name" class="form-control form-control-lg" value="{{ $item->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_email{{ $item->id }}">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email
                        </label>
                        <input type="email" id="edit_email{{ $item->id }}" name="email" class="form-control form-control-lg" value="{{ $item->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_role{{ $item->id }}">
                            <i class="fas fa-id-card me-2" style="color: var(--primary);"></i>Role
                        </label>
                        <select id="edit_role{{ $item->id }}" name="role" class="form-select form-select-lg" required>
                            <option value="customer" {{ $item->role === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin" {{ $item->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
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

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="deleteUserModalLabel{{ $item->id }}">
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Delete User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-3">
                    Are you sure you want to delete <strong>{{ $item->name }}</strong>?
                </p>
                <p class="text-muted small">
                    This action will permanently remove the user account and all associated data.
                </p>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <form method="POST" action="{{ route('user.destroy', $item->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3">
                        <i class="fas fa-trash-alt me-1"></i>Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Add Customer Modal (Admin Only) -->
@if($user->role === 'admin')
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="addCustomerModalLabel">
                    <i class="fas fa-user-plus me-2" style="color: var(--primary);"></i>Create Customer Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('customer.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-500" for="customer_name">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" id="customer_name" name="name" class="form-control form-control-lg" required placeholder="John Doe">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="customer_email">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email
                        </label>
                        <input type="email" id="customer_email" name="email" class="form-control form-control-lg" required placeholder="customer@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="customer_password">
                            <i class="fas fa-lock me-2" style="color: var(--primary);"></i>Password
                        </label>
                        <input type="password" id="customer_password" name="password" class="form-control form-control-lg" required placeholder="Min 8 chars">
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary rounded-3">
                        <i class="fas fa-plus me-1"></i>Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Customer Modals (Dynamic for each customer) -->
@foreach($customers as $customer)
<div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="editCustomerModalLabel{{ $customer->id }}">
                    <i class="fas fa-edit me-2" style="color: var(--primary);"></i>Edit Customer Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('customer.update', $customer->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_customer_name{{ $customer->id }}">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" id="edit_customer_name{{ $customer->id }}" name="name" class="form-control form-control-lg" value="{{ $customer->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_customer_email{{ $customer->id }}">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email
                        </label>
                        <input type="email" id="edit_customer_email{{ $customer->id }}" name="email" class="form-control form-control-lg" value="{{ $customer->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_customer_gender{{ $customer->id }}">
                            <i class="fas fa-venus-mars me-2" style="color: var(--primary);"></i>Gender
                        </label>
                        <select id="edit_customer_gender{{ $customer->id }}" name="gender" class="form-select form-select-lg">
                            <option value="">-- Select Gender --</option>
                            <option value="male" {{ $customer->gender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $customer->gender === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $customer->gender === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" for="edit_customer_address{{ $customer->id }}">
                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary);"></i>Address
                        </label>
                        <textarea id="edit_customer_address{{ $customer->id }}" name="address" class="form-control form-control-lg" rows="3">{{ $customer->address }}</textarea>
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
<div class="modal fade" id="deleteCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="deleteCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="deleteCustomerModalLabel{{ $customer->id }}">
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Delete Customer Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-3">
                    Are you sure you want to delete <strong>{{ $customer->name }}'s</strong> customer account?
                </p>
                <p class="text-muted small">
                    This action will permanently remove the customer account and all associated data including orders, cart, and profile information.
                </p>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <form method="POST" action="{{ route('customer.destroy', $customer->id) }}" style="display: inline;">
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
@endif

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-3">
                    <strong>Warning:</strong> This action cannot be undone. Deleting your account will:
                </p>
                <ul class="text-muted">
                    <li>Permanently delete your account</li>
                    <li>Remove all your personal information</li>
                    <li>Cancel any active orders or transactions</li>
                    <li>Delete your profile and history</li>
                </ul>
                <div class="alert alert-warning mt-4" role="alert">
                    <i class="fas fa-lightbulb me-2"></i>
                    Type <strong>"DELETE"</strong> below to confirm the deletion of your account.
                </div>
                <input type="text" class="form-control form-control-lg" id="confirmDeleteInput" placeholder="Type DELETE to confirm" />
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <form id="deleteAccountForm" method="POST" action="{{ route('profile.destroy') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger rounded-3" id="confirmDeleteBtn" disabled>
                        <i class="fas fa-trash-alt me-1"></i>Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Delete account confirmation
    const confirmDeleteInput = document.getElementById('confirmDeleteInput');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    confirmDeleteInput.addEventListener('input', function() {
        confirmDeleteBtn.disabled = this.value !== 'DELETE';
    });

    confirmDeleteBtn.addEventListener('click', function() {
        if (confirmDeleteInput.value === 'DELETE') {
            document.getElementById('deleteAccountForm').submit();
        }
    });
</script>

@endsection
