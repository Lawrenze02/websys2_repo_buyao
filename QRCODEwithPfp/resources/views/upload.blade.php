<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Upload Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --surface-color: rgba(30, 41, 59, 0.7);
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            --success-color: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at top right, #1e1b4b, #0f172a);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            width: 100%;
        }

        header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInDown 0.8s ease-out;
        }

        header h1 {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .upload-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
            animation: fadeInUp 0.8s ease-out;
        }

        .upload-card {
            background: var(--surface-color);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .upload-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.6);
        }

        .upload-card h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .file-input-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .file-input-wrapper input[type="file"] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: block;
            padding: 1rem;
            border: 2px dashed rgba(99, 102, 241, 0.5);
            border-radius: 12px;
            text-align: center;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            background: rgba(99, 102, 241, 0.05);
        }

        .file-input-wrapper:hover .file-input-label {
            border-color: var(--primary-color);
            color: var(--text-primary);
            background: rgba(99, 102, 241, 0.1);
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 8px;
            width: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-danger:hover {
            background: var(--danger-hover);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success-color);
            color: var(--success-color);
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        .gallery-header {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            font-weight: 600;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.5rem;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            animation: fadeInUp 1s ease-out;
        }

        .gallery-item {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .gallery-item:hover {
            transform: scale(1.03);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            display: block;
        }

        .gallery-item .actions {
            position: absolute;
            top: 15px;
            right: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .actions {
            opacity: 1;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>Photo Gallery</h1>
            <p>Upload and manage your beautiful moments</p>
        </header>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="upload-section">
            <!-- Single Upload Card -->
            <div class="upload-card">
                <h2>Single Image</h2>
                <form action="{{ route('photos.store.single') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="single-file" required onchange="updateFileName(this, 'single-label')">
                        <label for="single-file" class="file-input-label" id="single-label">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <br>Click or drag to select a file
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Single</button>
                </form>
            </div>

            <!-- Multiple Upload Card -->
            <div class="upload-card">
                <h2>Multiple Images</h2>
                <form action="{{ route('photos.store.multiple') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="file-input-wrapper">
                        <input type="file" name="images[]" id="multiple-file" multiple required onchange="updateFileName(this, 'multiple-label', true)">
                        <label for="multiple-file" class="file-input-label" id="multiple-label">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <br>Click or drag to select files
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Multiple</button>
                </form>
            </div>
        </div>

        @if(isset($photos) && count($photos) > 0)
        <h2 class="gallery-header">Your Uploads</h2>
        <div class="gallery">
            @foreach ($photos as $photo)
            <div class="gallery-item">
                <img src="{{ asset('images/' . $photo->image) }}" alt="Uploaded Photo">
                <div class="actions">
                    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" title="Delete">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <script>
        function updateFileName(input, labelId, isMultiple = false) {
            const label = document.getElementById(labelId);
            if (input.files && input.files.length > 0) {
                if (isMultiple) {
                    label.innerHTML = `<span style="color: var(--primary-color); font-weight: 600;">${input.files.length} files selected</span>`;
                } else {
                    label.innerHTML = `<span style="color: var(--primary-color); font-weight: 600;">${input.files[0].name}</span>`;
                }
            } else {
                label.innerHTML = `
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <br>Click or drag to select ${isMultiple ? 'files' : 'a file'}
                `;
            }
        }
    </script>
</body>
</html>