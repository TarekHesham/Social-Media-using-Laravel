@extends('layouts.app')
@section('title')
Show Post
@endsection

@section('content')
<div class="card w-50 mx-auto">
    <div class="card-header">
        Post Info
    </div>

    <div class="card-body">
        @if ($post->image)
        <img src="{{asset("images/posts/{$post->image}")}}" class="mb-3 mx-auto w-100">
        @endif
        <blockquote class="blockquote mb-0">
            <h4><strong>Title:-</strong><br> {{$post->title}}</h4>
            <p>
                <strong>Description:-</strong><br>
                {{$post->description}}
            </p>
            <br>
            <footer class="blockquote-footer float-start">
                Posted By: <cite>{{$post->creator->name}}</cite>
                <br>
                Created At: {{ $post->created_at }}
                <br>
                Updated In {{ $post->updatedAt }}
            </footer>
        </blockquote>
    </div>
</div>

<section class="commments container my-5">
    <h3>Comments</h3>
    <div class="comments">
        @foreach ($post->comments as $comment)
        <div class="comment mb-3 p-3 rounded shadow bg-light">
            <div class="d-flex align-items-center">
                <img src="{{Str::startsWith($comment->creator->image, 'https') ? $comment->creator->image : asset("images/users/{$comment->creator->image}")}}" alt="Avatar" class="image" style="width: 25px; height: 25px; border-radius: 50%;">
                <h5 class="m-0 ms-1">{{$comment->creator->name}}</h5>
            </div>
            <p class="m-0 mt-1">{{$comment->content}}</p>
            <small class="text-muted">{{$comment->created_at->diffForHumans()}}</small>
        </div>
        @endforeach
    </div>

    <div class="createComment">
        <form action="{{route('comments.store', ['post_id' => $post->id])}}" method="POST">
            @csrf
            <div class="mt-5 mb-3">
                <textarea class="form-control" style="resize: none;" placeholder="Enter your comment" id="commentContent" name="content" rows="4"></textarea>
            </div>

            @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary float-end mb-5">Reply</button>
        </form>
    </div>
</section>
{{--
<script>
    const commentContent = document.getElementById('commentContent');
    commentContent.addEventListener('keyup', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.querySelector('.createComment form').submit();
        }
    });
</script> --}}
@endsection