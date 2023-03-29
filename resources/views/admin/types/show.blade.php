@extends('layouts.admin')
@section('head-title', ' Type | ')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row row-cols-1 mb-5">
            <div class="col">
                <h1>
                    {{ $type->id }} - {{ $type->name }}
                </h1>
            </div>
            <div class="col">
                <a href="{{ route('admin.types.index') }}" class="btn btn-outline-primary">
                    Torna Indietro
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
                <a href="{{ route('admin.types.edit', $type->id) }}" class="btn btn-outline-warning">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                {{-- @include('admin.projects.partials.delete') --}}
            </div>
        </div>
        @include('admin.partials.errors')
        @include('admin.partials.success')
        @include('admin.partials.warning')

        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="row g-0">

                        <div class="col-md-8">
                            <div class="card-body h-100">
                                <h5 class="card-title">Nome: {{ $type->name }}</h5>
                                <p class="card-text">Slug: {{ $type->slug }}</p>
                                <p class="card-text"># Progetti: {{ $type->projects()->count() }}</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @if (count($projects) > 0)

                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            Progetti
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($projects as $project)
                                <li class="list-group-item">
                                    <a href="{{ route('admin.projects.show',$project ->id) }}">
                                        {{ $project->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
