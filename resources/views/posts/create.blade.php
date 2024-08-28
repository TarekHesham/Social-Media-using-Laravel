@extends('layouts.app')
@section('title') Create Post @endsection

@section('content')
  <h1>Create Post</h1>

  <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" aria-describedby="emailHelp">
      @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description" value="{{old('description')}}" rows="3"></textarea>
      @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input type="file" class="form-control" id="image" name="image">
      @if (isset($post->image))
        <img src="{{asset("images/posts/{$post->image}")}}" width="50" height="50">
      @endif

      @error('image')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="creator_id" class="form-label">Post Creator</label>
      <select name="creator_id" id="creator_id">
        @foreach($creators as $creator)
          <option value="{{$creator->id}}" {{ old('creator_id') == $creator ? 'selected' : '' }}>{{$creator->name}}</option>
        @endforeach
      </select>
      @error('creator_id')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>

    
    <button type="submit" class="btn btn-primary float-end">Submit</button>
  </form>
@endsection