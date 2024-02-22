@extends('layouts.app')
@section('editor')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('content')
    <form action="{{ route('films.update',$film->id) }}" method="POST" enctype="multipart/form-data" class="card mb-3">
        @csrf
        @method('PUT')
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold my-auto">Manajemen Film</h5>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="namaJudul" class="form-label">Judul Film</label>
                            <input type="text" name="judul" class="form-control" id="namaJudul"
                                value="{{ $film->judul }}">
                            @error('judul')
                                <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <div id="deskripsi">{!! $film->deskripsi !!}</div>
                            <textarea class="form-control" name="deskripsi" id="content-textarea" hidden style="display: none;">{!! $film->deskripsi !!}</textarea>
                            @error('deskripsi')
                                <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="card shadow-none border text-center p-lg-4">
                                <label class="form-label border-dashed cursor-pointer text-center" id="label"
                                    style="border-radius:10px;" for="imageFile">Masukkan cover film
                                    <img class="img-preview img-fluid mb-2 mx-auto w-50">
                                    <img src="{{ asset('img/cover/' . $film->cover) }}" id="plusimg" class="img-fluid p-md-3" alt="">
                                    <input accept="image/*" type="file" name="cover" value="{{ $film->cover }}"
                                        class="form-control mt-3" id="imageFile" onchange="previewImage()">
                                </label>
                                @error('cover')
                                    <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="genre_select" class="form-label">Genre</label>
                            <select class="form-select" name="genre_id" id="genre_select">
                                <option value="{{ $film->genre_id }}">{{ $film->genre->nama_genre }}</option>
                                @foreach ($genre as $itemG)
                                    <option value="{{ $itemG->id }}"
                                        {{ old('genre_id') == $itemG->id ? 'selected' : '' }}>
                                        {{ $itemG->nama_genre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre_id')
                                <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end ">
                    <a href="{{ route('films') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Update Film</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footScript')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        function previewImage() {
            const imageFile = document.querySelector('#imageFile');
            const imgPreview = document.querySelector('.img-preview');
            const label = document.querySelector('#label');
            const img = document.querySelector('#plusimg');

            img.style.display = 'none';
            label.style.border = 0;
            imgPreview.style.display = 'block';

            const blob = URL.createObjectURL(imageFile.files[0]);
            imgPreview.src = blob;
        }
        var toolbarOptions = [
            [{
                'font': []
            }],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],

            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }],

            [{
                'color': []
            }, {
                'background': []
            }],
            [{
                'align': []
            }],

            ['clean']
        ];
        var quill = new Quill('#deskripsi', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        quill.on('text-change', function(delta, source) {
            updateHtmlOutput()
        })

        // When the convert button is clicked, update output
        $('#btn-convert').on('click', () => {
            updateHtmlOutput()
        })

        // Return the HTML content of the editor
        function getQuillHtml() {
            return quill.root.innerHTML;
        }

        // Highlight code output
        function updateHighlight() {
            hljs.highlightBlock(document.querySelector('#content-textarea'))
        }


        function updateHtmlOutput() {
            let html = getQuillHtml();
            console.log(html);
            document.getElementById('content-textarea').innerText = html;
            updateHighlight();
        }


        updateHtmlOutput()
    </script>
@endsection
