@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Article</h5>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-sm btn-primary mt-3 mb-3" data-bs-toggle="modal"
                            data-bs-target="#ModalArticle">Tambah</button>
                        <div class="table-responsive mt-3">
                            <table class="table" id="article">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No.
                                        </th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Author Name</th>
                                        <th>Created At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($article as $articles)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>{{ $articles->title }}</td>
                                            <td> <button class="btn btn-xs btn-info"
                                                onclick="lihat_content('{{ $articles->id }}')">Lihat
                                                Content</button></td>
                                            <td>{{ $articles->author_name }}</td>
                                            <td>{{ $articles->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary" id="edit-article"><i
                                                        class="fas fa-pen"
                                                        onclick="edit_article('{{ $articles->id }}')"></i></button>
                                                <button class="btn btn-sm btn-danger"><i class='fas fa-trash'
                                                        onclick="hapus_article('{{ $articles->id }}')"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="ModalArticle">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-article">
                        <label for="title" class="col-form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Masukkan Title" required>
                        <label for="content" class="col-form-label">Content</label>
                        <textarea class="form-control" id="content" style="resize: vertical;  height: 100px;" name="content" required></textarea>
                        <label for="author_name" class="col-form-label">Title</label>
                        <input type="text" name="author_name" id="author_name" class="form-control"
                            placeholder="Masukkan Author Name" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-article"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="simpan-article">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="ModalArticleUpdate">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Artice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-article-update">
                        <input type="hidden" name="id_edit" id="id_edit" class="form-control">
                        <label for="title_edit" class="col-form-label">Title</label>
                        <input type="text" name="title_edit" id="title_edit" class="form-control" required>
                        <label for="content_edit" class="col-form-label">Content</label>
                        <textarea class="form-control" id="content_edit" style="resize: vertical;  height: 100px;" name="content_edit" required></textarea>
                        <label for="author_name_edit" class="col-form-label">Author Name</label>
                        <input type="text" name="author_name_edit" id="author_name_edit" class="form-control" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-article-edit"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="update-article">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="ModalHapusArticle">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus article ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btn-hapus-article">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modalLihatContent">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lihat Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" id="contents_edit" style="resize: vertical;  height: 500px;" name="contents_edit" readonly></textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $("#article").dataTable();
        $('#simpan-article').click(function() {
            if ($("#form-tambah-article")[0].checkValidity()) {
                var formdata = new FormData(document.getElementById("form-tambah-article"));
                $.ajax({
                    type: "POST",
                    url: "/add-article/save",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        $('#form-tambah-article')[0].reset();
                        $('#close-article').click();
                        window.location.reload();
                    },
                });

            } else {
                $("#form-tambah-article")[0].reportValidity();
            }
        });

        function edit_article(id) {
            //console.log(id);
            $.ajax({
                type: "GET",
                url: "/edit-article",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    // show modal
                    $('#ModalArticleUpdate').modal('show');
                    // fill form in modal
                    $('#id_edit').val(response.data.id);
                    $('#title_edit').val(response.data.title);
                    $('#content_edit').val(response.data.content);
                    $('#author_name_edit').val(response.data.author_name);
                },
            });
        }

        $('#update-article').click(function() {
            if ($("#form-article-update")[0].checkValidity()) {
                var formdata = new FormData(document.getElementById("form-article-update"));
                $.ajax({
                    type: "POST",
                    url: "/update-article",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        $('#close-article-edit').click();
                        window.location.reload();
                    },
                });
            } else {
                $("#form-article-update")[0].reportValidity();
            }
        });

        function hapus_article(id) {
            $.ajax({
                type: "GET",
                url: "/hapus-article",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(id);
                    // show modal
                    $('#ModalHapusArticle').modal('show');
                    $('#btn-hapus-article').attr('onclick', `del_data_article(` + response.id + `)`);
                },
            });
        }


        function del_data_article(id) {
            $.ajax({
                type: "POST",
                url: "/destroy-article",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    $('#ModalHapusArticle').modal('hide');
                    window.location.reload();
                },
            });
        }

        function lihat_content(id) {
            $.ajax({
                type: "GET",
                url: "/lihat_content",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    // show modal
                    $('#modalLihatContent').modal('show');
                    $('#contents_edit').val(response.data.content);
                },
            });
        }
    </script>
@endsection
