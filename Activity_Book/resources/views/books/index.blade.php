@extends('layouts.app')

@section('title', 'All Books - BookHub')

@section('content')
<div class="page-header">
    <h1 class="page-title">Library Collection</h1>
</div>

@if(count($books) > 0)
    <div class="book-grid">
        @foreach ($books as $book)
            <div class="book-card">
                <div class="book-title">{{ $book->title }}</div>
                <div class="book-author">by {{ $book->author }}</div>
                <div>
                    <span class="book-date">Published: {{ $book->published_date }}</span>
                </div>
                
                <div class="book-actions">
                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-secondary" style="flex: 1; text-align: center; text-decoration: none;">✏️ Edit</a>
                    
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="flex: 1; display: flex;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%; border: none;">🗑️ Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state form-card">
        <div class="empty-state-icon">📚</div>
        <h2>No books found</h2>
        <p style="color: var(--text-secondary); margin: 1rem 0;">Your library is currently empty. Add your first book to get started.</p>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
    </div>
@endif
@endsection