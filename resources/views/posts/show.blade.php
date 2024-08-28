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
            <img src="{{asset("images/posts/{$post->image}")}}" width="250" height="250" class="mb-3">
        @endif
        <blockquote class="blockquote mb-0">
        <h4><strong>Title:-</strong><br> {{$post->title}}</h4>
        <p>
            <strong>Description:-</strong><br>
            {{$post->description}}
        </p>
        <br>
        <footer class="blockquote-footer float-start">
            Posted By: <cite title="posted_by">{{$post->creator->name}}</cite>
            <br>
            Created At: {{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d') }}
            <br>

            Updated From {{ $post->updated_at->diffForHumans() }}
        </footer>
        </blockquote>
    </div>
</div>

<section class="commments container my-5">
    <h3>Comments</h3>
    <div class="comments">
        @foreach ($post->comments as $comment)
            <div class="comment mb-3 p-3 rounded shadow bg-light">
                <h5>{{$comment->creator->name}}</h5>
                <p class="m-0">{{$comment->content}}</p>
                <small class="text-muted">{{$comment->created_at->diffForHumans()}}</small>
                {{-- <div class="actions gap-2">
                    <a href="{{route('comments.edit', $comment->id)}}" class="btn btn-secondary float-end">Edit</a>
                    <form action="{{route('comments.destroy', $comment->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger float-end">Delete</button>
                    </form>
                </div> --}}
            </div>
        @endforeach
    </div>

    <div class="createComment">
        <form action="{{route('comments.store')}}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <input type="hidden" name="creator_id" value="{{$post->creator_id}}">
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

<script>
    const commentContent = document.getElementById('commentContent');
    commentContent.addEventListener('keyup', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.querySelector('.createComment form').submit();
        }
    });
</script>
@endsection