@extends('layouts.app')

@section('content')
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="fw-bold my-auto">Manajemen Genre</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('genres.perform') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="namaJudul" class="form-label">Nama Genre</label>
                        <input type="text" name="nama_genre" class="form-control" id="namaJudul">
                        @error('nama_genre')
                            <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Tambah Genre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive small">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp

                        @foreach ($genre as $item)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $item->nama_genre }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('genres.edit',$item->id)}}" class="btn btn-success btn-sm ms-1"><i
                                                class="bi bi-pencil-square"></i>Edit</a>
                                        <form onsubmit="return confirm('sure to delete this data')"
                                            action="{{ route('genres.delete', $item->id) }}" method="post">
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
