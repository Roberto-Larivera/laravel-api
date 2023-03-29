<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;

// Helpers
use Illuminate\Support\Str;

// Models
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// Mails
use App\Mail\NewType;

class TypeController extends Controller
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
            $types = Type::where('name', 'like', '%' . $textSearch . '%')->get();
        elseif (!isset($textSearch) && isset($quantitySearch))
            $types = Type::has('projects', '>=', $quantitySearch)->get();
        elseif (isset($textSearch) && isset($quantitySearch))
            $types = Type::where('name', 'like', '%' . $textSearch . '%')->has('projects', '>=', $quantitySearch)->get();
        else
            $types = Type::all();

        if (count($types) == 0)
            // return view('admin.types.index', compact('types'))->with('warning', 'Non ci sono stati risultati');
            
            return redirect()->route('admin.types.index', compact('types'))->with('warning', 'Non ci sono stati risultati');
        else
            return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        // Validazione slug
        $existSlug = Type::where('slug', $data['slug'])->first();

        $counter = 1;
        $dataSlug = $data['slug'];

        // questa funzione controlla se lo slag esiste già nel database, e in caso esista con questo ciclo while li viene inserito un numero di continuazione 
        while ($existSlug) {
            if (strlen($data['slug']) >= 95) {
                substr($data['slug'], 0, strlen($data['slug']) - 3);
            }
            $data['slug'] = $dataSlug . '-' . $counter;
            $counter++;
            $existSlug = Type::where('slug', $data['slug'])->first();
        }
        $newType = Type::create($data);
        $user = Auth::user();
        Mail::to($user)->send(new newType($newType));
        return redirect()->route('admin.types.show', $newType)->with('success', 'Tipologia aggiunta con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        $projects = $type->projects;
        return view('admin.types.show', compact('type', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypeRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $nameOld = $type->name;

        $data = $request->validated();

        if ($nameOld == $data['name']) {
            return redirect()->route('admin.types.edit', $type->id)->with('warning', 'Non hai modificato nessun dato');
        } else {

            $data['slug'] = Str::slug($data['name']);

            // Validazione slug
            $existSlug = Type::where('slug', $data['slug'])->first();

            $counter = 1;
            $dataSlug = $data['slug'];

            // questa funzione controlla se lo slag esiste già nel database, e in caso esista con questo ciclo while li viene inserito un numero di continuazione 
            while ($existSlug) {
                if (strlen($data['slug']) >= 95) {
                    substr($data['slug'], 0, strlen($data['slug']) - 3);
                }
                $data['slug'] = $dataSlug . '-' . $counter;
                $counter++;
                $existSlug = Type::where('slug', $data['slug'])->first();
            }
            $type->update($data);
            return redirect()->route('admin.types.show', $type)->with('success', 'Tipologia aggiornata con successo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete($type);
        return redirect()->route('admin.types.index')->with('success', 'La tipologia è stata eliminata con successo');
    }
}
