@extends('layouts.app')

@section('content')
<div class="admin-user-container">
    <h2>👥 Admin Users</h2>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert-box success">{{ session('success') }}</div>
    @endif

    <!-- Add Button -->
    <a href="{{ route('admin.users.create') }}" class="btn-add-admin">➕ Add Admin</a>

    <!-- User Table -->
    <div class="user-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>👤 Name</th>
                    <th>📧 Email</th>
                    <th>⚙️ Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">✏️ Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this admin?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No admins found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Internal CSS -->
<style>
    .admin-user-container {
        max-width: 1000px;
        margin: 30px auto;
        background: #1e1e2f;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
        color: white;
        font-family: 'Segoe UI', sans-serif;
    }

    .admin-user-container h2 {
        margin-bottom: 20px;
        text-align: center;
        color: #00d9ff;
        font-weight: 600;
    }

    .alert-box.success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px 20px;
        border-radius: 6px;
        margin-bottom: 15px;
        border-left: 6px solid #28a745;
    }

    .btn-add-admin {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        transition: 0.3s;
    }

    .btn-add-admin:hover {
        opacity: 0.9;
    }

    .user-table-wrapper {
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: #2d2f4a;
        border-radius: 8px;
        overflow: hidden;
    }

    .admin-table th,
    .admin-table td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #444;
    }

    .admin-table th {
        background-color: #111827;
        color: #00d9ff;
    }

    .admin-table tr:hover {
        background-color: #3c3f5c;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #111;
        padding: 6px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        padding: 6px 14px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-edit:hover,
    .btn-delete:hover {
        opacity: 0.85;
    }
</style>
@endsection
