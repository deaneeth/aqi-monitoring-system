@extends('layouts.app')

@section('content')
<style>
    .sensor-container {
        max-width: 1100px;
        margin: 40px auto;
        background: #1e1e2f;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.4);
        color: white;
        font-family: 'Segoe UI', sans-serif;
    }

    .sensor-container h2 {
        font-weight: bold;
        margin-bottom: 25px;
    }

    .btn-add {
        background: #007bff;
        color: white;
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-add:hover {
        background: #0056b3;
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    table.sensor-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: #2a2a40;
        color: white;
        border-radius: 8px;
        overflow: hidden;
    }

    .sensor-table th, .sensor-table td {
        padding: 14px 12px;
        text-align: center;
    }

    .sensor-table th {
        background-color: #343a50;
        font-weight: 600;
    }

    .sensor-table tr:nth-child(even) {
        background-color: #30314a;
    }

    .status-active {
        color: #28a745;
        font-weight: bold;
    }

    .status-inactive {
        color: #dc3545;
        font-weight: bold;
    }

    .action-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #000;
    }

    .btn-deactivate {
        background-color: transparent;
        color: #dc3545;
        border: none;
    }

    .btn-activate {
        background-color: #28a745;
        color: white;
    }

    .btn-deactivate:hover, .btn-activate:hover, .btn-edit:hover {
        opacity: 0.85;
    }
</style>

<div class="sensor-container">
    <h2>🛰️ Sensor Management</h2>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <a href="{{ route('sensors.create') }}" class="btn-add">+ Add New Sensor</a>

    <table class="sensor-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sensors as $sensor)
                <tr>
                    <td>{{ $sensor->name }}</td>
                    <td>{{ $sensor->latitude }}</td>
                    <td>{{ $sensor->longitude }}</td>
                    <td>
                        <span class="{{ $sensor->status === 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($sensor->status) }}
                        </span>
                    </td>
                    <td>
    <a href="{{ route('sensors.edit', $sensor->id) }}" class="action-btn btn-edit">Edit</a>

    @if($sensor->status === 'active')
        <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to deactivate this sensor?');">
            @csrf
            @method('DELETE')
            <button class="action-btn btn-deactivate">Deactivate</button>
        </form>
    @else
        <form action="{{ route('sensors.activate', $sensor->id) }}" method="POST" style="display:inline;">
            @csrf
            <button class="action-btn btn-activate" onclick="return confirm('Activate this sensor?')">Activate</button>
        </form>
    @endif

    {{-- ✅ Delete Permanently --}}
    <form action="{{ route('sensors.forceDelete', $sensor->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('This will permanently delete the sensor. Continue?');">
        @csrf
        @method('DELETE')
        <button class="action-btn btn-deactivate" style="color: #ff5555;">Delete</button>
    </form>
</td>


                </tr>
            @empty
                <tr>
                    <td colspan="5">No sensors found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
