@extends('layouts.admin')
@section('head-title', 'Edit | ')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row row-cols-1 mb-5">
            <div class="col">
                <h1>
                    Modifica Tecnologia | {{ $technology->id }}
                </h1>
            </div>
            <div class="col">
                <a href="{{ route('admin.technologies.index') }}" class="btn btn-outline-primary">
                    Torna Indietro
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
                <a href="{{ route('admin.technologies.show', $technology->id) }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-eye"></i>
                </a>
                @include('admin.technologies.partials.delete')
            </div>
        </div>
        @include('admin.partials.errors')
        @include('admin.partials.success')
        @include('admin.partials.warning')
        <div class="row">
            <div class="col">

                <form action="{{ route('admin.technologies.update',$technology) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label  @error('name') text-danger @enderror ">Nome <span
                                class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Esempio Tipologia" maxlength="98" value="{{ old('name',$technology->name) }}" required>
                        @error('name')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <p>
                            I campi contrassegnati con <span class="text-danger fw-bold">*</span> sono <span
                                class="text-danger fw-bold text-decoration-underline">obbligatori</span>
                        </p>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success mb-3">Conferma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
