@extends('layouts.app')

@section('title', 'Edit Book - BookHub')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Book</h1>
    <a href="{{ route('books.index') }}" class="btn btn-secondary" style="text-decoration: none;">← Back to Library</a>
</div>

<div class="form-card">
    <form action="{{ route('books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" id="title" name="title" value="{{ $book->title }}" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label for="author" class="form-label">Author Name</label>
            <input type="text" id="author" name="author" value="{{ $book->author }}" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label for="published_date" class="form-label">Published Date</label>
            <input type="date" id="published_date" name="published_date" value="{{ $book->published_date }}" class="form-input" required>
        </div>
        
        <div style="margin-top: var(--spacing-xl);">
            <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1rem;">Save Changes</button>
        </div>
    </form>
</div>
@endsection