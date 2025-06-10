@extends('layouts.app')

@section('content')
<div class="admin-create-container">
    <h2>👤 Add New Admin</h2>

    <!-- Error Validation -->
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="admin-form">
        @csrf

        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" placeholder="John Doe" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" placeholder="admin@example.com" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="********" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="********" required>

        <div class="form-actions">
            <button type="submit" class="btn-create">✅ Create Admin</button>
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">❌ Cancel</a>
        </div>
    </form>
</div>

<!-- Internal CSS -->
<style>
    .admin-create-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: #1e1e2f;
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        font-family: 'Segoe UI', sans-serif;
    }

    .admin-create-container h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: 600;
        color: #00d9ff;
    }

    .error-box {
        background-color: #ffdddd;
        border-left: 5px solid #dc3545;
        color: #721c24;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
    }

    .admin-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .admin-form label {
        font-weight: bold;
        font-size: 14px;
    }

    .admin-form input {
        padding: 10px;
        border: none;
        border-radius: 6px;
        background-color: #2c2f4a;
        color: white;
    }

    .admin-form input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    .admin-form input:focus {
        outline: 2px solid #00bfff;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-create {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-create:hover,
    .btn-cancel:hover {
        opacity: 0.9;
    }
</style>
@endsection
