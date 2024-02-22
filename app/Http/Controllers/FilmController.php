<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Http\Request;
use File;

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
            'cover'        => 'required|image|mimes:jpg,png,jpeg',
            'deskripsi'           => 'required'
        ]);


        $coverName = time() . '.' . $request->cover->extension();

        $request->cover->move(public_path('img/cover'), $coverName);

        $film = new Film;

        $film->user_id     = auth()->user()->id;
        $film->genre_id    = $request->genre_id;
        $film->judul       = $request->judul;
        $film->cover      = $coverName;
        $film->deskripsi         = $request->deskripsi;

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
            'cover'        => 'image|mimes:jpg,png,jpeg',
            'deskripsi'           => 'required'
        ]);


        if ($request->has('cover')) {
            $film = Film::find($id);

            $path = "img/cover/";
            File::delete($path . $film->cover);

            $coverName = time() . '.' . $request->cover->extension();

            $request->cover->move(public_path('img/cover'), $coverName);

            $film->user_id     = auth()->user()->id;
            $film->genre_id = $request->genre_id;
            $film->judul       = $request->judul;
            $film->cover      = $coverName;
            $film->deskripsi         = $request->deskripsi;

            $film->save();

            return redirect('/films');
        } else {
            $film = Film::find($id);

            $film->user_id     = auth()->user()->id;
            $film->genre_id = $request->genre_id;
            $film->judul       = $request->judul;
            $film->deskripsi         = $request->deskripsi;

            $film->save();

            return redirect('/films');
        }
    }


    public function destroy($id)
    {
        $film = Film::find($id);

        $path = "img/cover/";
        File::delete($path . $film->cover);
        $film->delete();

        return redirect('/films')->with('success', 'success, data deleted');
    }
}
