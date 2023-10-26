@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Dati del progetto:
            <p class="show"> {{ $projects->id }}</p>

        </h2>
        <p class="card-text"><span class="show">Titolo: </span>
        <p class="des-show">{{ $projects->title }}</p>
        </p>
        <p class="card-text des-show"><span class="show">Slug: </span> {{ $projects->slug }} €</p>
        <p class="card-text des-show"><span class="show">Creazione: </span> {{ $projects->created_at }}</p>
        <p class="card-text des-show"><span class="show">Updated : </span> {{ $projects->updated_at }}</p>

        <a class="btn btn-primary ml-auto" href="{{ route('admin.projects.index') }}">Torna indietro</a>
    @endsection
