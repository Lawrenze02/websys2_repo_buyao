<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Activity Book Management')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app-container">
        <nav class="navbar">
            <div class="nav-brand">
                <span class="icon">📚</span>
                <span class="brand-text">BookHub</span>
            </div>
            <div class="nav-links">
                <a href="{{ route('books.index') }}" class="nav-link">All Books</a>
                <a href="{{ route('books.create') }}" class="nav-link btn-primary-sm">Add New Book</a>
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>
    </div>
</body>
</html>
