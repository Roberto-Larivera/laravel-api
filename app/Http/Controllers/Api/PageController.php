<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Project;

// Helpers
// o si impora cosi o direttamente /Exception quando si usa
use Exception;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // questo prende tutti i progetti senza i dati di ogni tabella collegata
        // $projects = Project::all();
        $itemsPerPage = 12;
        if(request()->input('items_per_page')
            &&
            (
                request()->input('items_per_page') == 12 ||
                request()->input('items_per_page') == 24 ||
                request()->input('items_per_page') == 36 ||
                request()->input('items_per_page') == 48
            )
        )
        $itemsPerPage = request()->input('items_per_page');

        $projects = Project::with(['type','technologies'])->paginate( $itemsPerPage);
        
        // 1 metodo per inserire url base (localhost... + storage/+img)
        //foreach ($projects as  $project)
                        //dd($project->getFullPathFeaturedImageAttribute()); //questo è il secondo metodo creato dentro il model, e non ha bisogno di essere richiamato perchè viene appeso nel model, dd esempio stampa
            // if($project->featured_image)
            // $project->featured_image = asset('storage/'.$project->featured_image);
       
        $response = [
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'projects' => $projects,
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        
        // 1 metodo per verificare se la query ha dato una risposta corretta o a datto errore
        /*
        $project= Project::where('slug', $slug)->with(['type','technologies'])->first();
        
        if($project)
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'OK',
                'project' => $project
            ];
        else
            $response = [
                'success' => false,
                'code' => 404,
                'message' => 'NOT FOUND'
            ];
        */

        // 2 metodo, grazie a firstOrFail() facciamo uscire un errore (exception) e con try se mentre segue il codice va in errore si ferma e fa partire il catch
        try{
            $project= Project::where('slug', $slug)->with(['type','technologies'])->firstOrFail();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'OK',
                'project' => $project
            ];
        }catch (Exception $e){
            $response = [
                'success' => false,
                'code' => $e->getCode(),
                'message' =>  $e->getMessage()
            ];
        }


        return response()->json($response);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
