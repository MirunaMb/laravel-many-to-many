@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-success">
            Crea nuovo progetto
        </a>
    </div>

    <h1 class="my-5">I miei progetti</h1>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Technologies</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col"></th>
                        <th scope="col">Published</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <th scope="row">{{ $project->id }}</th>
                            <td>{{ $project->title }}</td>
                            <td>{!! $project->getTypeBadges() !!}</td>
                            <td>{!! $project->getTechnologiesBadges() !!}</td>
                            <td class="w-75">{{ $project->slug }}</td>
                            <td class="w-75">{{ $project->created_at }}</td>
                            <td class="w-75">{{ $project->updated_at }}</td>
                            <td class="w-75">
                                <div class="d-flex flex-row border-bottom-0 gap-2 ">
                                    <a href="{{ route('admin.projects.show', $project->id) }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a class="btn btn-primary" href="{{ route('admin.projects.edit', $project->id) }}">
                                        <i class="fa-solid fa-gear fa-bounce"></i>
                                    </a>
                                    {{-- ICON TRASH --}}
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal-{{ $project->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    {{-- MODAL PER IL TRASH --}}
                                    <div class="modal fade text-black" id="delete-modal-{{ $project->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fs-5" id="exampleModalLabel">Elimina elemento
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Sei sicuro di voler eliminare definitivamente questo comic
                                                    "{{ $project->titolo }}"?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annulla</button>
                                                    <form action="{{ route('admin.projects.destroy', $project) }}"
                                                        method="POST" class="mx-1">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.projects.publish', $project) }}" method="POST"
                                    id="form-published-{{ $project->id }}">
                                    @method('PATCH')
                                    @csrf
                                    <label class="switch">
                                        <input type="checkbox" name="published"
                                            @if ($project->published) checked @endif>
                                        <span class="slider round checkbox-published" data-id={{ $project->id }}></span>
                                    </label>


                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $projects->links('pagination::bootstrap-5') }}
    </div>
@endsection


@section('scripts')
    <script>
        const checkboxesPublished = document.getElementsByClassName('checkbox-published');
        console.log(checkboxesPublished);

        for (checkbox of checkboxesPublished) {
            checkbox.addEventListener('click', function() {
                const idPost = this.getAttribute('data-id');
                const form = document.getElementById('form-published-' + idPost);
                form.submit();
            });
        }
    </script>
@endsection
