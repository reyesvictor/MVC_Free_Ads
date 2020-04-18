<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Photo;
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
        $this->validateThis($request);

        // dd($request);
        $annonce = new Annonce([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'user_id' => Auth::id(),
        ]);

        $annonce->save();
        $this->storeImg($annonce->id);
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
    }

    public function storeImg($id)
    {
        if (request()->has('image')) {
            // dd(request()->all());
            $annonce = Annonce::where('id', $id)->first();
            if (is_array(request()->image)) {
                foreach (request()->image as $image) {
                    $photo = new Photo([
                        'path' => $image->store('photos', 'public')
                    ]);
                    $annonce->photos()->save($photo);
                }
            } else {
                $photo = new Photo([
                    'path' => request()->image->store('photos', 'public')
                ]);
                $annonce->photos()->save($photo);
            }
            // dd($annonce);
        }
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
        $annonces = Annonce::with(['photos'])->paginate(3);
        // dd($annonces);
        // $annonces = Annonce::paginate(2);
        // $images = Photo::all();

        // $annonces = DB::table('annonces')
        //     ->leftJoin('photos', 'annonce_id', '=', 'annonces.id')
        //     ->select('annonces.*', 'photos.*')
        //     ->paginate(2);
        // dd($annonces);
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
        $this->validateThis($request);

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
        $this->storeImg($annonce->id);

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
        $annonce->photos()->delete();
        $annonce->delete();
        return redirect()
            ->route('annonce.show')
            ->with('delete', 'Your annonce has been deleted.');
    }


    private function validateThis($request)
    {
        // return request()->validate([
        //     'titre' => 'required|min:5',
        //     'description' => 'required|min:10',
        //     'prix' => 'required'
        // ]);
        return tap($this->validate($request, [
            'titre' => 'required|min:5',
            'description' => 'required|min:10',
            'prix' => 'required'
        ]), function () {
            if (request()->hasFile('image')) {
                // dd(request()->image);
                request()->validate([
                    // 'image' => 'file|image|max:3000'
                    'image' => 'required',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);
            }
        });
    }

    public function search(Request $request)
    {
        $this->s = '';
        $this->arr = [['0', '1000000'], ['0', '100'], ['100', '300'], ['300', '1000000']];
        if ($request->s != '') {
            $this->s = $request->s;
            // $annonces = Annonce::where('titre', 'like', "%$s%")
            //     ->orWhere('description', 'like', "%$s%")
            //     ->paginate(3);
        }

        if ($request->prix != '') {
            $this->prix = $request->prix;
            // dd( $arr[$prix][0]);
        }
        
        $annonces = Annonce::where(function ($query) {
            $query->where('prix', '>', intval($this->arr[$this->prix][0]))
            ->where('prix', '<', intval($this->arr[$this->prix][1]));
        })->where(function ($query) {
            $query->where('titre', 'like', "%$this->s%")
            ->orWhere('description', 'like', "%$this->s%");
        })->get();

        // request()->validate(['s' => 'required']);

        return view('annonce.show', ['annonces' => $annonces]);
    }

    public function getUserList(){
        if(Auth::check()){

            $annonces = Annonce::where('user_id', Auth::id())->get();

            return view('annonce.mylist')->with('annonces', $annonces);
        }else {
            return redirect()
            ->route('annonce.show');
        }
    }
}
