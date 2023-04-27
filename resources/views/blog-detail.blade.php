@extends('layouts.app-guest')
@section('content')
    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Blog Details</h4>
                            <h2>PT. Max Solution Indonesia</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="all-blog-posts">
                        @foreach ($detail_artikels as $detail_artikel)
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="blog-post">
                                        <div class="down-content">
                                            <h4>{{ $detail_artikel->title }}</h4>
                                            <ul class="post-info">
                                                <li><a href="#">{{ $detail_artikel->author_name }}</a></li>
                                                <li><a href="#">{{ $detail_artikel->created_at->format('Y-m-d') }}</a>
                                                </li>
                                            </ul>
                                            <p>{{ $detail_artikel->content }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="sidebar-item comments">
                                        <div class="sidebar-heading">
                                            <?php $jumlah = ('App\Models\Comment')
                                                ::join('articles', 'comments.article_id', '=', 'articles.id')
                                                ->where('articles.id', $id)
                                                ->count(); ?>
                                            <h2>{{ $jumlah }} comments</h2>
                                        </div>
                                        <div class="content">
                                            @foreach ($comment as $com)
                                                <ul>
                                                    <li>
                                                        <h6><b>{{ $com->name }}<span> |
                                                                    {{ $com->created_at->format('Y-m-d') }}</span></b></h6>
                                                        <p>
                                                            @guest
                                                                @if (Route::has('login'))
                                                                    {{ $com->comment }}
                                                                @endif
                                                            @else
                                                                {{ $com->comment }}
                                                                @if ($com->user_id == Auth::user()->id)
                                                                    <button class="btn btn-sm me-2"
                                                                        style="background-color: transparent; color: red;"
                                                                        onclick="hapus_com({{ $com->id }})"> Hapus
                                                                    </button><button class="btn btn-sm me-2"
                                                                        style="background-color: transparent; color: blue;"
                                                                        onclick="edit_com({{ $com->id }})"> Edit
                                                                    </button>
                                                                @endif
                                                            @endguest
                                                        </p>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="sidebar-item submit-comment">
                                        <div class="sidebar-heading">
                                            <h2>Your comment</h2>
                                        </div>
                                        <div class="content">
                                            <form id="comment" action="{{ url('comment') }}/{{ $id }}"
                                                method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <fieldset>
                                                            <input name="name" type="text" id="name"
                                                                placeholder="Masukkan Namamu" required>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <fieldset>
                                                            <textarea name="comment" rows="6" id="comment" placeholder="Masukkan Komentarmu" required></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <fieldset>
                                                            <button type="submit" id="form-submit"
                                                                class="main-button">Submit</button>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" tabindex="-1" id="ModalCommentUpdate">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-comment-update">
                        <input type="hidden" name="id_edit" id="id_edit" class="form-control">
                        <label for="name_edit" class="col-form-label">Name</label>
                        <input type="text" name="name_edit" id="name_edit" class="form-control" required>
                        <label for="comment_edit" class="col-form-label">Comment</label>
                        <textarea class="form-control" id="comment_edit" style="resize: vertical;  height: 100px;" name="comment_edit" required></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-comment-edit"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="update-comment">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="ModalHapusComment">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Komen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus komen ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btn-hapus-comment">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function edit_com(id) {
            //console.log(id);
            $.ajax({
                type: "GET",
                url: "/edit-comment",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    // show modal
                    $('#ModalCommentUpdate').modal('show');
                    // fill form in modal
                    $('#id_edit').val(response.data.id);
                    $('#name_edit').val(response.data.name);
                    $('#comment_edit').val(response.data.comment);
                },
            });
        }

        $('#update-comment').click(function() {
            if ($("#form-comment-update")[0].checkValidity()) {
                var formdata = new FormData(document.getElementById("form-comment-update"));
                $.ajax({
                    type: "POST",
                    url: "/update-comment",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        $('#close-comment-edit').click();
                        window.location.reload();
                    },
                });
            } else {
                $("#form-comment-update")[0].reportValidity();
            }
        });

        function hapus_com(id) {
            $.ajax({
                type: "GET",
                url: "/hapus-comment",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(id);
                    // show modal
                    $('#ModalHapusComment').modal('show');
                    $('#btn-hapus-comment').attr('onclick', `del_data_com(` + response.id + `)`);
                },
            });
        }


        function del_data_com(id) {
            $.ajax({
                type: "POST",
                url: "/destroy-comment",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    $('#ModalHapusComment').modal('hide');
                    window.location.reload();
                },
            });
        }
    </script>
@endsection
