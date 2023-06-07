 <link rel="stylesheet" href="/css/post.css">
 <div class="row justify-content-center">
        <div class="card shadow my-3" style="width: 35rem;">
            <div class="card-body">
                    <div class="row">
                            <div class="col-1">
                                <img src="{{ asset('images/'.auth()->user()->profile_pic) }}" alt="Avatar" class="post-avatar"> 
                            </div>
                            <div class="col-11">
                                <input type="button" style="background-color: rgb(238, 238, 238);"  data-bs-toggle="modal" data-bs-target="#createPost" class="form-control btn text-start rounded-pill" style="width: 500px" value="What's on your mind, {{ auth()->user()->firstname }}?... "> 
                            </div>
                    </div>
            </div>
        </div>
    </div>


    @foreach ($posts as $post)
    <div class="row justify-content-center">
        <x-post-card :post="$post" />
    </div>
    @endforeach
        <!-- Create Post Modal -->
    <form method="POST" action="/posts/create">
        @csrf
        <div class="modal fade" id="createPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="fs-5" id="exampleModalLabel">Create Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <h6 class="card-title"> 
                        <img src="{{ asset('images/'.auth()->user()->profile_pic) }}" alt="Avatar" class="post-avatar"> {{ auth()->user()->firstname . " " . auth()->user()->lastname }} </h6>
                    <textarea name="post-content" id="post_content" style="outline: none;" class="border-0 mt-3" cols="57" rows="2" placeholder="Write a post..."></textarea>
                    <div class="row">
                        <input type="file" name="post-img" id="post_img" class="form-control">
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary form-control">Post</button>
                </div>
            </div>
            </div>
        </div>
    </form>

    {{-- UPDATE POST MODAL --}}
    <form method="POST" action="/posts/create">
        @csrf
        <div class="modal fade" id="edit_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="fs-5" id="exampleModalLabel">Edit Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <h6 class="card-title"> 
                        <img src="{{ asset('images/'.auth()->user()->profile_pic) }}" alt="Avatar" class="post-avatar"> {{ auth()->user()->firstname . " " . auth()->user()->lastname }} </h6>
                    <textarea name="post-content" id="edit_post_content" style="outline: none;" class="border-0 mt-3" cols="57" rows="2" placeholder="Write a post..."></textarea>
                    <div class="row">
                        <span> <img src="{{asset('images/me.png')}}" alt="post image" id="edit_post_image" style="max-height: 300px; max-width: 470px"> </span>
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary form-control">Save</button>
                </div>
            </div>
            </div>
        </div>
    </form>

    
    {{-- DELETE POST MODAL --}}
    <div class="modal fade" id="delete_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
                <div class="modal-body text-center fs-3">
                    Delete post?
                    <input type="hidden" name="post_id" id="delete_id_modal">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close_modal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" id="delete_post_from_modal">Delete</button>
                  </div>
          </div>
        </div>
      </div>

    <script>
    function editPost(post_id, post_content, post_img) {
        console.log(post_content)
        $('#edit_post_content').val(post_content)
        $('#edit_post_image').attr('src', "{{ asset('images/') }}" + "/"+post_img)

    }
        $('#post-content').on('paste', function (event) {
            var inputItem = (event.clipboardData || event.originalEvent.clipboardData).items;
            var item = inputItem[0];
            if (item.type.indexOf('image') !== -1) {
                var file = item.getAsFile();
                console.log(file)
            }
        });
    

        $(document).ready(function (){
            $('#delete_post_from_modal').on('click', function () {
                var post_id = $('#delete_post_from_modal').val()
                var url = "{{ route('post.delete', ['post' => 'post_id']) }}"
                url = url.replace('post_id', post_id)
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        post_id: post_id,
                        _token: '{{ csrf_token() }}'},
                    success: function (response) {
                        $('#close_modal').click()
                        $('#post' + post_id).remove()
                    },
                    erorr:function (error) {
                        console.log(error);
                    }
                })
            })
        })
  </script>

    