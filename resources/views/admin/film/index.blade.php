@extends('layouts.app')
@section('editor')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('content')
    {{-- form create --}}
    <form action="{{ route('films.perform') }}" method="POST" enctype="multipart/form-data" class="card mb-3">
        @csrf
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
                            <input type="text" name="judul" class="form-control" id="namaJudul" value="{{old('judul')}}">
                            @error('judul')
                                <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <div id="deskripsi">{!!old('deskripsi')!!}</div>
                            <textarea class="form-control" name="deskripsi" id="content-textarea" hidden style="display: none;">{!!old('deskripsi')!!}</textarea>
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
                                    <img src="" id="plusimg" class="img-fluid p-md-3" alt="">
                                    <input accept="image/*" type="file" name="cover" class="form-control mt-3"
                                        id="imageFile" onchange="previewImage()">
                                </label>
                                @error('cover')
                                    <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="genre_select" class="form-label">Genre</label>
                            <select class="form-select" name="genre_id" id="genre_select">
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
                    <button type="submit" class="btn btn-success w-100">Tambah Film</button>
                </div>
            </div>
        </div>
    </form>
    {{-- /form create --}}

    <div id="alert">
        @include('components.alert')
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Cover</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($film as $item)
                            <tr>
                                <td class="align-middle">{{ $i }}.</td>
                                <td class="align-middle">{{ $item->judul }}</td>
                                <td class="align-middle">{{ $item->genre->nama_genre }}</td>
                                <td class="align-middle">{!! Str::limit($item->deskripsi, 100) !!}</td>
                                <td class="align-middle">
                                    <img src="{{ asset('img/cover/' . $item->cover) }}"
                                        class="rounded-3 shadow-sm height-auto w-25" style="max-height: 100px" alt="">
                                </td>

                                <td class="align-middle">
                                    <div class="d-flex">
                                        <a href="{{route('films.edit',$item->id)}}" class="btn btn-success btn-sm ms-1"><i
                                                class="bi bi-pencil-square"></i>Edit</a>
                                        <form onsubmit="return confirm('sure to delete this data')" action="{{route('films.delete',$item->id)}}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger mb-0 ms-1">
                                                <i class="bi bi-trash"></i>delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
