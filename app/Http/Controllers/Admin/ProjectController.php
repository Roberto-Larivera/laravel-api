<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

// Models
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;

// Helpers
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

// Mails
use App\Mail\NewProject;


class ProjectController extends Controller
{









    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $textSearch = request()->input('text');
        $typeSearch = request()->input('type_id');
        $technologySearch = request()->input('technology');
        $types = Type::all();
        $technologies = Technology::all();

        if (isset($textSearch) && !isset($typeSearch))
            $projects = Project::where('title', 'like', '%' . $textSearch . '%')->get();
        elseif (!isset($textSearch) && isset($typeSearch))
            $projects = Project::where('type_id', '=', $typeSearch)->get();
        elseif (isset($textSearch) && isset($typeSearch))
            $projects = Project::where([
                ['title', 'like', '%' . $textSearch . '%'],
                ['type_id', 'like', '%' . $typeSearch . '%']
            ])->get();
        else
            $projects = Project::all();

        if (isset($technologySearch))
            $projects = Project::whereHas('technologies', function ($query) use ($technologySearch) {
                $query->where('technologies.id', $technologySearch);
            })->get();

        if (count($projects) == 0)
            // non va bene redirect perchè ci troviamo in index

            // qui restituisci un view ma non viene letto il messaggio 'warning' in pagina
            // return view('admin.projects.index', compact('projects', 'types', 'technologies'))->with('warning', 'Non ci sono stati risultati');

            // qui restituisci una redirect alla rotta ma con il messaggio in pagina
            return redirect()->route('admin.projects.index', compact('projects', 'types', 'technologies'))->with('warning', 'Non ci sono stati risultati');
        else
            return view('admin.projects.index', compact('projects', 'types', 'technologies'));
        // metodo 1
        // metodo 2
        //return view('admin.projects.index',compact('projects'));
    }










    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }












    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        if (array_key_exists('featured_image', $data)) {
            $imgPath = Storage::put('projects', $data['featured_image']);
            $data['featured_image'] = $imgPath;
        }



        $data['slug'] = Str::slug($data['title']);
        $existSlug = Project::where('slug', $data['slug'])->first();

        $counter = 1;
        $dataSlug = $data['slug'];

        // Aggiungere la possibilità di rimuovere gli spazzi se ci sono e inserire dei trattini, name-repo

        // questa funzione controlla se lo slag esiste già nel database, e in caso esista con questo ciclo while li viene inserito un numero di continuazione 
        while ($existSlug) {
            if (strlen($data['slug']) >= 95) {
                substr($data['slug'], 0, strlen($data['slug']) - 3);
            }
            $data['slug'] = $dataSlug . '-' . $counter;
            $counter++;
            $existSlug = Project::where('slug', $data['slug'])->first();
        }

        $newProject = Project::create($data);

        if (array_key_exists('technologies', $data)) {
            foreach ($data['technologies'] as $tecnology) {
                $newProject->technologies()->attach($tecnology);
            }
        }


        // Email
        //Mail::to('prova-ricevere@esempio.it')->send(new NewProject($newProject));
        return redirect()->route('admin.projects.show', $newProject)->with('success', 'Progetto aggiunto con successo');
    }







    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }











    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $technologies = Technology::all();
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }











    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $titleOld =  $project->title;
        $type_idOld =  $project->type_id;
        $name_repoOld =  $project->name_repo;
        $link_repoOld =  $project->link_repo;
        $featured_imageOld =  $project->featured_image;
        $descriptionOld =  $project->description;
        $technologiesOld =  $project->technologies()->pluck('id')->toArray();

        $featuredDeleteImage = false;


        $data = $request->validated();
        //dd($technologiesOld == $data['technologies']);

        if (array_key_exists('delete_featured_image', $data) || array_key_exists('featured_image', $data))
            $featuredDeleteImage = true;

        //
        if (!array_key_exists('type_id', $data))
            $data['type_id'] = null;

        //
        if (!array_key_exists('technologies', $data))
            $data['technologies'] = null;

        //
        if (
            $titleOld ==  $data['title'] &&
            $type_idOld  ==  $data['type_id'] &&
            $name_repoOld ==  $data['name_repo'] &&
            $link_repoOld ==  $data['link_repo'] &&
            $descriptionOld ==  $data['description'] &&
            $featuredDeleteImage == false &&
            $technologiesOld == $data['technologies']
        ) {
            return redirect()->route('admin.projects.edit', $project->id)->with('warning', 'Non hai modificato nessun dato');
        } else {
            // controllo titolo se è uguale a quello già esistente
            if ($titleOld != $data['title']) {

                $data['slug'] = Str::slug($data['title']);
                $existSlug = Project::where('slug', $data['slug'])->first();

                $counter = 1;
                $dataSlug = $data['slug'];

                // Aggiungere la possibilità di rimuovere gli spazzi se ci sono e inserire dei trattini, name-repo

                // questa funzione controlla se lo slag esiste già nel database, e in caso esista con questo ciclo while li viene inserito un numero di continuazione 
                while ($existSlug) {
                    if (strlen($data['slug']) >= 95) {
                        substr($data['slug'], 0, strlen($data['slug']) - 3);
                    }
                    $data['slug'] = $dataSlug . '-' . $counter;
                    $counter++;
                    $existSlug = Project::where('slug', $data['slug'])->first();
                }
            }

            // controllo se esiste la key img -- 2 controllo 
            if (array_key_exists('delete_featured_image', $data)) {
                if ($featured_imageOld) {
                    // Controllo se ce un immagine vecchia è la cancello
                    Storage::delete($featured_imageOld);

                    $project->featured_image = null;
                    $project->save();
                }
            } else if (array_key_exists('featured_image', $data)) {
                $imgPath = Storage::put('projects', $data['featured_image']);
                $data['featured_image'] = $imgPath;
                if ($featured_imageOld) {
                    // Controllo se ce un immagine vecchia è la cancello
                    Storage::delete($featured_imageOld);
                }
            }

            if (array_key_exists('technologies', $data)) {

                $project->technologies()->sync($data['technologies']);
            }


            $project->update($data);
            return redirect()->route('admin.projects.show', $project)->with('success', 'Progetto aggiornato con successo');
        }
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //$project = Project::findOrFail($project);
        if ($project->featured_image) {
            // Controllo se ce un immagine vecchia è la cancello
            Storage::delete($project->featured_image);
        }
        $project->delete($project);
        return redirect()->route('admin.projects.index')->with('success', 'Il Progetto è stato eliminato con successo');
    }
}
