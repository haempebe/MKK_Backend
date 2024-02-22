<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genre = Genre::get();
        return view('admin.genre.index',compact('genre'));
    }
    public function store()
    {
        $attributes = request()->validate([
            'nama_genre' => 'required|max:50|unique:genres,nama_genre',
        ], [
            'nama_genre.required' => 'isi nama genre',
            'nama_genre.unique' => 'nama genre sudah ada.'
        ]);
        Genre::create($attributes);
        return redirect()->to('/genres')->with('success', 'genre ditambahkan');
    }
    public function edit($id)
    {
        $genre  = Genre::findOrFail($id);
        return view('admin.genre.edit', compact('genre'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_genre'   => 'required',
        ]);

        $genre = Genre::find($id);

        $genre->nama_genre = $request->nama_genre;

        $genre->save();

        return redirect('/genres');
    }
    public function destroy($id)
    {
        Genre::where('id', $id)->delete();
        return redirect()->to('/genres')->with('success', 'The data has been successfully deleted');
    }
}
