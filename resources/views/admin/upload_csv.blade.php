@extends('layouts.app')

@section('content')
<style>
    .upload-container {
        max-width: 600px;
        margin: 60px auto;
        background: linear-gradient(145deg, #1e1e2f, #27293d);
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    .upload-container h2 {
        text-align: center;
        color: #00e0ff;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 8px;
        color: #ccc;
    }

    .form-control[type="file"] {
        background-color: #2c2f4a;
        color: white;
        border: 1px solid #444;
        padding: 12px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .form-control[type="file"]:hover {
        border-color: #00d9ff;
    }

    .upload-btn {
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        font-weight: bold;
        color: white;
        margin-top: 20px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 114, 255, 0.4);
    }

    .upload-btn:hover {
        background: linear-gradient(135deg, #0090ff, #004cbf);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 114, 255, 0.5);
    }

    .upload-success, .upload-error {
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .upload-success {
        background-color: #1e5631;
        color: #d4edda;
        border-left: 5px solid #28a745;
    }

    .upload-error {
        background-color: #5e1d1d;
        color: #f8d7da;
        border-left: 5px solid #dc3545;
    }

    .file-info {
        font-size: 13px;
        margin-top: 5px;
        color: #999;
    }
</style>

<div class="upload-container">
    <h2>📂 Upload AQI Data (CSV)</h2>

    @if(session('success'))
        <div class="upload-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="upload-error">
            ❌ {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('data.upload.handle') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file" class="form-label">Choose a CSV file to import AQI sensor data:</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" required onchange="updateFileName(this)">
            <div id="file-name" class="file-info">No file selected</div>
        </div>
        <button type="submit" class="upload-btn">
            <i class="fas fa-file-upload"></i> Upload & Import
        </button>
    </form>
</div>

<!-- Font Awesome for upload icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<script>
    function updateFileName(input) {
        const fileName = input.files.length ? input.files[0].name : 'No file selected';
        document.getElementById('file-name').textContent = fileName;
    }
</script>
@endsection
