<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index()
    {
        $genre = Genre::get();
        $film = Film::get();
        $user  = User::get();
        return view('admin.film.index', compact('genre', 'user', 'film'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'user_id'       => '',
            'genre_id'   => 'required',
            'judul'         => 'required',
            'gambar'        => 'required|image|mimes:jpg,png,jpeg',
            'isi'           => 'required'
        ]);


        $gambarName = time() . '.' . $request->gambar->extension();

        $request->gambar->move(public_path('img/gambar'), $gambarName);

        $film = new Film;

        $film->user_id     = auth()->user()->id;
        $film->genre_id    = $request->genre_id;
        $film->judul       = $request->judul;
        $film->gambar      = $gambarName;
        $film->isi         = $request->isi;

        $film->save();

        return redirect('/films')->with('success', 'added data successfully');
    }
    public function show($id)
    {
        $film   = Film::findOrFail($id);
        return view('admin.film.show', compact('film'));
    }
    public function edit($id)
    {
        $genre = Genre::get();
        $user     = User::get();
        $film   = Film::findOrFail($id);
        return view('admin.film.edit', compact('film', 'genre', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'       => '',
            'genre_id'   => 'required',
            'judul'         => 'required',
            'gambar'        => 'image|mimes:jpg,png,jpeg',
            'isi'           => 'required'
        ]);


        if ($request->has('gambar')) {
            $film = Film::find($id);

            $path = "img/gambar/";
            File::delete($path . $film->gambar);

            $gambarName = time() . '.' . $request->gambar->extension();

            $request->gambar->move(public_path('img/gambar'), $gambarName);

            $film->user_id     = auth()->user()->id;
            $film->genre_id = $request->genre_id;
            $film->judul       = $request->judul;
            $film->gambar      = $gambarName;
            $film->isi         = $request->isi;

            $film->save();

            return redirect('/films');
        } else {
            $film = Film::find($id);

            $film->user_id     = auth()->user()->id;
            $film->genre_id = $request->genre_id;
            $film->judul       = $request->judul;
            $film->isi         = $request->isi;

            $film->save();

            return redirect('/films');
        }
    }


    public function destroy($id)
    {
        $film = Film::find($id);

        $path = "img/gambar/";
        File::delete($path . $film->gambar);
        $film->delete();

        return redirect('/films')->with('success', 'success, data deleted');
    }
}
