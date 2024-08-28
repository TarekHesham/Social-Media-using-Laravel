@extends('layouts.app')
@section('title') Posts @endsection

@section('content')
  <h1>Show Posts</h1>
  <a href="{{route("posts.create")}}" class="btn btn-success mb-3">Create Post</a>
  @if(session('success'))
    <div class="alert alert-success">{{session("success")}} </div>
  @endif
  <table class="table table-striped">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Posted By</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
      @foreach($posts as $post)
          <tr>
              <td>{{$post->id}}</td>
              <td>{{$post->title}}</td>
              <td>{{$post->creator->name}}</td>
              <td>{{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d') }}</td>
              <td class="d-flex gap-2">
                <a href="{{route("posts.show", $post['id'])}}" class="btn btn-secondary">View</a>
                <a href="{{route("posts.edit", $post['id'])}}" class="btn btn-primary">Edit</a>
                <form action="{{ route('posts.destroy', $post['id']) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
              </td>
          </tr>
      @endforeach
  </table>

  {{ $posts->links() }}
@endsection