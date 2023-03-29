<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;

// Helpers
use Illuminate\Support\Str;

// Models
use App\Models\Technology;

// Mails
use App\Mail\NewType;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $textSearch = request()->input('text');
        $quantitySearch = request()->input('quantity');

        if (isset($quantitySearch) <= 0)
            $quantitySearch = null;

        if (isset($textSearch) && !isset($quantitySearch))
            $technologies = Technology::where('name', 'like', '%' . $textSearch . '%')->get();
        elseif (!isset($textSearch) && isset($quantitySearch))
            $technologies = Technology::has('projects', '>=', $quantitySearch)->get();
        elseif (isset($textSearch) && isset($quantitySearch))
            $technologies = Technology::where('name', 'like', '%' . $textSearch . '%')->has('projects', '>=', $quantitySearch)->get();
        else
            $technologies = Technology::all();

            //dd(count($technologies) === 0);
        if (count($technologies) === 0)
            // return view('admin.technologies.index', compact('technologies'))->with('warning', 'Non ci sono stati risultati');
            
            return redirect()->route('admin.technologies.index', compact('technologies'))->with('warning', 'Non ci sono stati risultati');
        else
            return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.technologies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTechnologyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnologyRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        // Validazione slug
        $existSlug = Technology::where('slug', $data['slug'])->first();

        $counter = 1;
        $dataSlug = $data['slug'];

        // questa funzione controlla se lo slag esiste già nel database, e in caso esista con questo ciclo while li viene inserito un numero di continuazione 
        while ($existSlug) {
            if (strlen($data['slug']) >= 95) {
                substr($data['slug'], 0, strlen($data['slug']) - 3);
            }
            $data['slug'] = $dataSlug . '-' . $counter;
            $counter++;
            $existSlug = Technology::where('slug', $data['slug'])->first();
        }
        $newTechnology = Technology::create($data);
        //$user = Auth::user();
        //Mail::to($user)->send(new newTechnology($newTechnology));
        return redirect()->route('admin.technologies.show', $newTechnology)->with('success', 'Tecnologia aggiunta con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        $projects = $technology->projects;
        return view('admin.technologies.show', compact('technology', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {

        return view('admin.technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTechnologyRequest  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        $nameOld = $technology->name;

        $data = $request->validated();

        if ($nameOld == $data['name']) {
            return redirect()->route('admin.technologies.edit', $technology->id)->with('warning', 'Non hai modificato nessun dato');
        } else {

            $data['slug'] = Str::slug($data['name']);

            // Validazione slug
            $existSlug = Technology::where('slug', $data['slug'])->first();

            $counter = 1;
            $dataSlug = $data['slug'];

            // questa funzione controlla se lo slag esiste già nel database, e in caso esista con questo ciclo while li viene inserito un numero di continuazione 
            while ($existSlug) {
                if (strlen($data['slug']) >= 95) {
                    substr($data['slug'], 0, strlen($data['slug']) - 3);
                }
                $data['slug'] = $dataSlug . '-' . $counter;
                $counter++;
                $existSlug = Technology::where('slug', $data['slug'])->first();
            }
            $technology->update($data);
            return redirect()->route('admin.technologies.show', $technology)->with('success', 'La Tecnologia aggiornata con successo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route('admin.technologies.index')->with('success', 'La Tecnologia è stato eliminato con successo');
    }
}
