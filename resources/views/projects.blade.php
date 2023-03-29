@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h1>
                    Tutti i Progetti
                </h1>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 gy-4 gx-4">
            @foreach ($projects as $project)
                <div class="col">
                    <div class="card h-100">
                        @if (isset($project->featured_image))
                        <img src="{{ asset('storage/'.$project->featured_image) }}" class="card-img-top" alt="...">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text text-truncate">{{ $project->description }}</p>
                                <a href="{{ $project->link_repo }}" class="card-link">Guarda su GitHub</a>
                                {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
