@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="fw-bold my-auto">Manajemen Genre</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('genres.update',$genre->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="namaJudul" class="form-label">Nama Genre</label>
                        <input type="text" name="nama_genre" class="form-control" id="namaJudul" value="{{$genre->nama_genre}}">
                        @error('nama_genre')
                            <p class='text-danger mb-0 text-xs pt-1'> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Update Genre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
