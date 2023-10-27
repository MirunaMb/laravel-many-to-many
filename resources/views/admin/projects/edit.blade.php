@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-success">
            Torna alla lista
        </a>

        <h1>Modifica Project</h1>

        <form action="{{ route('admin.projects.update', $projects) }}" method="POST">
            @csrf {{-- Aggiunge il token CSRF --}}
            @method('PUT') {{-- Utilizza il metodo PUT per l'aggiornamento --}}

            <div class="row">
                <div class="col-3">
                    <label for="title">Titolo</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $projects->title) }}"
                        class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <label class="tiping my-3" for="type">Tipologia</label>
                    <select class="form-select w-25" id="type" name="type_id">
                        <option value=""></option>
                        @foreach ($types as $type)
                            <option @selected($type->id == old('type_id', $projects->type?->id)) value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>

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

                <div class="col-3">
                    <label for="content">Content</label>
                    <input type="content" id="content" name="content" value="{{ old('content', $projects->title) }}"
                        class="form-control @error('title') is-invalid @enderror">
                    </select>
                    @error('type')
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

                <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection
