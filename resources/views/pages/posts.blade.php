@extends('layouts.app', ['activePage' => 'posts', 'titlePage' => __('posts')])
{{-- @extends('layouts.master') --}}
<style>
  .new-post {
  padding: 16px 0;
  border-bottom: 1px solid #ccc;
  }
  
  .new-post header,
  .posts header {
  margin-bottom: 20px;
  }
  
  .posts .post {
  padding-left: 10px;
  border-left: 3px solid #a21b24;
  margin-bottom: 30px;
  }
  
  .posts .post .info {
  color: #aaa;
  font-style: italic;
  }
  
  .error,
  .success {
  text-align: center;
  }
  
  .error {
  border: 1px solid red;
  background-color: #f9b5af;
  color: red;
  }
  
  .error ul {
  list-style: none;
  margin: 0;
  padding: 0;
  }
  
  .success {
  border: 1px solid green;
  background-color: #d1f9da;
  color: green;
  }
  </style>
@section('content')
@include('includes.message-block')
<section class="row new-post">
  <div class="col-md-6 col-md-offset-3">
    <header>
      <h3>What do you have to say?</h3>
    </header>
    <form action="{{ route('post.create') }}" method="post">
      <div class="form-group">
        <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your Post"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Create Post</button>
      <input type="hidden" value="{{ Session::token() }}" name="_token">
    </form>
  </div>
</section>
<section class="row posts">
  <div class="col-md-6 col-md-offset-3">
    <header>
      <h3>What other people say...</h3>
    </header>
    @foreach($posts as $post)
    <article class="post" data-postid="{{ $post->id }}">
      <p>{{ $post->body }}</p>
      <div class="info">
        Posted by {{ $post->user->first_name }} on {{ $post->created_at }}
      </div>
      <div class="interaction">
        <a href="#"
          class="like">Like</a>
        |
        <a href="#"
          class="like">dislike</a>
        @if(Auth::user() == $post->user)
        |
        <a href="#" class="edit">Edit</a> |
        <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
        @endif
      </div>
    </article>
    @endforeach
  </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Post</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="post-body">Edit the Post</label>
            <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  var token = '{{ Session::token() }}';
        var urlEdit = '{{ route('edit') }}';
        var urlLike = '{{ route('like') }}';
</script>



@endsection