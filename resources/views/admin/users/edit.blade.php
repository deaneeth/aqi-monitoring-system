@extends('layouts.app')

@section('content')
<div class="edit-admin-container">
    <h2>🛠️ Edit Admin</h2>

    <!-- Error Handling -->
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Admin Edit Form -->
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="edit-form">
        @csrf
        @method('PUT')

        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}" required>

        <label for="password">New Password (optional)</label>
        <input type="password" name="password" id="password" placeholder="••••••••">

        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••">

        <div class="form-buttons">
            <button type="submit" class="btn-save">💾 Update Admin</button>
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">❌ Cancel</a>
        </div>
    </form>
</div>

<!-- Internal CSS -->
<style>
    .edit-admin-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background-color: #1e1e2f;
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        font-family: 'Segoe UI', sans-serif;
    }

    .edit-admin-container h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #00c3ff;
        font-weight: 600;
    }

    .error-box {
        background-color: #ffdddd;
        border-left: 5px solid #dc3545;
        color: #721c24;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
    }

    .edit-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .edit-form label {
        font-weight: bold;
        font-size: 14px;
    }

    .edit-form input {
        padding: 10px;
        border: none;
        border-radius: 6px;
        background-color: #2c2f4a;
        color: white;
    }

    .edit-form input:focus {
        outline: 2px solid #00bfff;
    }

    .form-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
    }

    .btn-save {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .btn-save:hover,
    .btn-cancel:hover {
        opacity: 0.9;
    }
</style>
@endsection
