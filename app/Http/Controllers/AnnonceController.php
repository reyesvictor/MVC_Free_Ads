<?php

namespace App\Http\Controllers;

use App\Like;
use App\Annonce;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('annonce.index');
    }

    public function new()
    {
        return view('annonce.new');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate(request(), [
            'titre' => 'required|min:5',
            'description' => 'required|min:10',
            'prix' => 'required'
        ]);

        $annonce = new Annonce([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'user_id' => Auth::id(),
        ]);
        $annonce->save();
        return redirect()
            ->route('annonce.new')
            ->with('success', 'Your annonce has been created.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function show(Annonce $annonce)
    {
        // $annonces = Annonce::all();
        $annonces = Annonce::paginate(2);
        return view('annonce.show', ['annonces' => $annonces]);
    }

    public function getAnnonce($id)
    {
        $annonce = Annonce::find($id);
        return view('annonce.show', ['annonce' => $annonce]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function edit(Annonce $annonce, Request $request)
    {
        $annonce = Annonce::find($request->annonce_id);
        return view('annonce.edit', ['annonce' => $annonce]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Annonce $annonce)
    {
        $this->validate(request(), [
            'titre' => 'required|min:5',
            'description' => 'required|min:10',
            'prix' => 'required'
        ]);

        // $annonce = new Annonce([
        //     'titre' => $request->titre,
        //     'description' => $request->description,
        //     'prix' => $request->prix,
        //     'user_id' => Auth::id(),
        // ]);

        // dd($request->annonce_id);

        $annonce = Annonce::find($request->annonce_id);
        $annonce->titre = $request->titre;
        $annonce->description = $request->description;
        $annonce->prix = $request->prix;
        $annonce->save();

        return redirect()
            ->route('annonce.show')
            ->with('update', 'Your annonce has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annonce $annonce, Request $request)
    {
        $annonce = Annonce::find($request->annonce_id);
        $annonce->delete();
        return redirect()
            ->route('annonce.show')
            ->with('delete', 'Your annonce has been deleted.');
    }
}
