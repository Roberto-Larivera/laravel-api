@extends('layouts.admin')
@section('head-title', 'Types | ')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col">
                <h1>
                    Tutte le Tipologie
                </h1>
                <a href="{{ route('admin.types.create') }}" class="btn btn-outline-primary">
                    Aggiungi Tipologia
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <form action="{{ route('admin.types.index') }}" method="get">
                    <div class="row">
                        <div class="col-auto d-flex ">

                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <button type="submit" class="btn">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </span>
                                <input type="search" class="form-control" name="text" value="{{ request('text') }}"
                                    placeholder="Cerca: Tipologia...">
                            </div>
                        </div>
        
                            <div class="col-auto d-flex ">
    
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <button type="submit" class="btn">
                                            1\n <i class="fa-solid fa-hashtag"></i>
                                        </button>
                                    </span>
                                    <input type="number" min="0" class="form-control" name="quantity" value="{{ request('quantity') }}"
                                        placeholder="Quantità: Progetti">
                                </div>
    
                            </div>
                        
                    </div>

                </form>
            </div>
        </div>
        @include('admin.partials.errors')
        @include('admin.partials.success')
        @include('admin.partials.warning')
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-info">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col"># Progetti</th>
                            <th scope="col">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $index => $type)
                            <tr>
                                <th scope="row" class="text-info">{{ $index + 1 }}</th>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->projects()->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.types.show', $type->id) }}"
                                        class="btn btn-outline-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.types.edit', $type->id) }}"
                                        class="btn btn-outline-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @include('admin.types.partials.delete')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
