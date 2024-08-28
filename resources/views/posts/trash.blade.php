@extends('layouts.app')
@section('title') Trash @endsection

@section('content')
  <h1>Posts In Trash</h1>
  
  @if(session('success'))
    <div class="alert alert-success">{{session("success")}} </div>
  @endif

  @if (count($posts) > 0)
  <form action="{{ route('posts.restoreAll') }}" method="post">
    @csrf
    <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure want restore all?')">Restore All</button>
  </form>

  <table class="table table-striped mt-3">
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
                <form action="{{ route('posts.restore', $post) }}" method="post">
                  @csrf
                  <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure want restore?')">Restore</button>
                </form>
                <form action="{{ route('posts.hardDestroy', $post) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure want delete?')">Delete</button>
                </form>
              </td>
          </tr>
      @endforeach
  </table>
  @else
    <div class="alert alert-danger mt-3">No posts in trash</div>
  @endif

  {{ $posts->links() }}
@endsection