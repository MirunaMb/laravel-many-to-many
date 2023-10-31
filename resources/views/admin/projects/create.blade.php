@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1>Crea un nuovo Comic</h1>
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="type_id" class="tiping my-3">Inserisci la tipologia</label>
                        <select class="form-select w-50 mx-auto" id="type_id" name="type_id">
                            <option value=""></option>
                            @foreach ($types as $type)
                                {{-- Controlla se il valore dell'input type_id inviato con la richiesta POST (utilizzando la funzione old()) è uguale all'id della tipologia di progetto ($type->id). Se questa condizione è vera, allora aggiunge l'attributo HTML selected all'elemento <option>. Questo attributo rende l'opzione preselezionata nel campo di selezione. --}}
                                <option class="text-center" @if (old('type_id') == $type->id) selected @endif
                                    value="{{ $type->id }}">
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- foreach technologies -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Tehnologies</label>
                            <div class="form-check @error('technologies') is-valid @enderror p-0">
                                @foreach ($technologies as $technology)
                                    <input type="checkbox" id="technology-{{ $technology->id }}"
                                        value="{{ $technology->id }}" name="technologies[]" class="form-check-control"
                                        @if (in_array($technology->id, old('technology', $project_technologies ?? []))) checked @endif>
                                    {{-- $project_technologies quidi questa variabile rappresenta il legame tra i modelli Project e Technology --}}
                                    {{-- Il null operator chiede se c e questa relazione $project_technologies,altrimenti usa un array vuoto  --}}
                                    <label for="technology-{{ $technology->id }}">
                                        {{ $technology->name_technologies }}
                                    </label>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <input type="text" class="form-control @error('content') is-invalid @enderror" id="content"
                                name="content" value="{{ old('content') }}">
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <textarea class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" rows="4">{{ old('slug') }}</textarea>
                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- IMAGE -->
                        <div class="col-12 mb-4">
                            <label for="cover_image" class="form-label">Carica immagine</label>
                            <input type="file" class="form-control" id="cover_image" name="cover_image"
                                value="{{ old('cover_image') }}">
                            @error('cover_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="col-4">
                                <img src="" class="img-fluid"
                                    alt="" id="cover_image_preview">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        const inputFileElement = document.getElementById('cover_image');
        const coverImagePreview = document.getElementById('cover_image_preview');
        inputFileElement.addEventListener('change', function() { //prendo l'input,intercetto il change
            alert('Immagine Cambiata');
            const [file] = this.files //prendo il file dentro input
            //quando l'immagine viene cambiata crea un Array di files da dove andiamo a estrarrne un solo file 

            //console.log(URL.createObjectURL(file)); //genera un blob-un formato di dati che contiene una lunga stringa di dati(che sono proprio l'immagine fisica)
            coverImagePreview.src = URL.createObjectURL(
            file); //il source di coverImagePreview e uguale al URL che creo dal file 
        })
    </script>
@endsection
