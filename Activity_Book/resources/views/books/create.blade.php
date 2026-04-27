@extends('layouts.app')

@section('title', 'Add New Book - BookHub')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Book</h1>
    <a href="{{ route('books.index') }}" class="btn btn-secondary" style="text-decoration: none;">← Back to Library</a>
</div>

<div class="form-card">
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" id="title" name="title" class="form-input" placeholder="Enter book title" required>
        </div>
        
        <div class="form-group">
            <label for="author" class="form-label">Author Name</label>
            <input type="text" id="author" name="author" class="form-input" placeholder="Enter author name" required>
        </div>
        
        <div class="form-group">
            <label for="published_date" class="form-label">Published Date</label>
            <input type="date" id="published_date" name="published_date" class="form-input" required>
        </div>
        
        <div style="margin-top: var(--spacing-xl);">
            <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1rem;">Save Book</button>
        </div>
    </form>
</div>
@endsection