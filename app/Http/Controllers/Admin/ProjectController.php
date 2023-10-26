<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $projects = Project::paginate(10);
       $types = Type::all();
       $technologies = Technology::all();
       return view("admin.projects.index", compact('types',"projects","technologies"));
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
        return view('admin.projects.create', compact('types','technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'title' => 'required|string|max:75',
                'content'=>'required|string|max:75',
                'slug' => 'required|string|max:75',
                'created' => 'required|string|max:75',
                'updated' => 'required|string|max:75',
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.string' => 'Il titolo deve essere una stringa',
                'title.max' => 'Il titolo deve contenere meno di 75 caratteri',
                'content.required' => 'Il content è obbligatorio',
                'content.string' => 'Il content deve essere una stringa',
                'content.max' => 'Il content deve contenere meno di 75 caratteri',

                'slug.required' => 'Lo slug è obbligatorio',
                'slug.string' => 'Lo slug deve essere una stringa',
                'slug.max' => 'Lo slug deve contenere meno di 75 caratteri',
                'created.required' => 'Il campo "creato" è obbligatorio',
                'created.string' => 'Il campo "creato" deve essere una stringa',
                'created.max' => 'Il campo "creato" deve contenere meno di 75 caratteri',
                'updated.required' => 'Il campo "aggiornato" è obbligatorio',
                'updated.string' => 'Il campo "aggiornato" deve essere una stringa',
                'updated.max' => 'Il campo "aggiornato" deve contenere meno di 75 caratteri',
            ],
        );
        // Verifica se la validazione ha avuto successo
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crea e salva un nuovo progetto nel database
        $project = Project::create($data);
        if (Arr::exists($data,"technologies")){
            $project->technologies()->sync($data["technologies"]);

        }


        // Reindirizza alla pagina di visualizzazione del comic appena creato
        return redirect()->route('admin.projects.show', $project->id);
    }

 

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projects = Project::findOrfail($id); 
        return view('admin.projects.show', compact('projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
      $types = Type::all();
      $projects = Project::findOrfail($project->id);

      $technologies = Technology::orderBy('name_technologies')->get();
    //   recupera tutte le tecnologie dal database e le ordina in ordine alfabetico basandosi sul campo 'label'. Il risultato è un elenco di tutte le tecnologie disponibili.
      $project_technologies = $project->technologies->pluck('id')->toArray();
    // vengono recuperate le tecnologie associate a un progetto specifico 
    // L'array risultante contiene gli ID delle tecnologie associate a quel progetto, convertiti in un array.
    // Visto che Project e Technology sono oggetti, è più comodo passare array di dati a una vista piuttosto che oggetti complessi o collezioni
      return view('admin.projects.edit', compact('projects','types','technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'title' => 'required|string|max:75',
                'content'=>'required|string|max:75',
                'slug' => 'required|string|max:75',
                'created' => 'required|string|max:75',
                'updated' => 'required|string|max:75',
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.string' => 'Il titolo deve essere una stringa',
                'title.max' => 'Il titolo deve contenere meno di 75 caratteri',
                'content.required' => 'Il content è obbligatorio',
                'content.string' => 'Il content deve essere una stringa',
                'content.max' => 'Il content deve contenere meno di 75 caratteri',

                'slug.required' => 'Lo slug è obbligatorio',
                'slug.string' => 'Lo slug deve essere una stringa',
                'slug.max' => 'Lo slug deve contenere meno di 75 caratteri',
                'created.required' => 'Il campo "creato" è obbligatorio',
                'created.string' => 'Il campo "creato" deve essere una stringa',
                'created.max' => 'Il campo "creato" deve contenere meno di 75 caratteri',
                'updated.required' => 'Il campo "aggiornato" è obbligatorio',
                'updated.string' => 'Il campo "aggiornato" deve essere una stringa',
                'updated.max' => 'Il campo "aggiornato" deve contenere meno di 75 caratteri',
            ],
        );
        if ($validator->fails()) {
            return redirect()
                ->route('admin.projects.edit', $project->id) // Se la validazione fallisce, reindirizza all'azione di modifica
                ->withErrors($validator)
                ->withInput();
        }

        $project = Project::findOrFail($project->id);
        $project->update($data);

        $project->update($data);

        if(Arr::exists($data, "technologies"))
          $project->technologies()->sync($data["technologies"]);
        else
          $project->technologies()->detach();

        return redirect()->route('admin.projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $projects = Project::findOrFail($project->id);
        $projects->delete();
        return redirect()->route('admin.projects.index');

        $project->technologies()->detach();
        $project->delete();
    }
}
