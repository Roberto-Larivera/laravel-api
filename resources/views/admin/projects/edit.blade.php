@extends('layouts.admin')
@section('head-title', 'Create | ')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row row-cols-1 mb-5">
            <div class="col">
                <h1>
                    Modifica Progetto | {{ $project->id }}
                </h1>
            </div>
            <div class="col">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary">
                    Torna Indietro
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
                <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-eye"></i>
                </a>
                @include('admin.projects.partials.delete')
            </div>
        </div>
        @include('admin.partials.errors')
        @include('admin.partials.success')
        @include('admin.partials.warning')
        <div class="row">
            <div class="col">

                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label  @error('title') text-danger @enderror ">Title <span
                                class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" placeholder="Example Title" maxlength="98"
                            value="{{ old('title') ?? $project->title }}" required >
                        @error('title')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name_repo" class="form-label  @error('name_repo') text-danger @enderror">Name
                            Repo <span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control @error('name_repo') is-invalid @enderror" id="name_repo"
                            name="name_repo" placeholder="example-name-repo" maxlength="98"
                            value="{{ old('name_repo') ?? $project->name_repo }}" required>
                        @error('name_repo')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="link_repo" class="form-label  @error('link_repo') text-danger @enderror">Link
                            Repo <span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control @error('link_repo') is-invalid @enderror" id="link_repo"
                            name="link_repo" placeholder="https://github.com/Example-link/name-repo" maxlength="255"
                            value="{{ old('link_repo') ?? $project->link_repo }}" required>
                        @error('link_repo')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (count($types) > 0)

                        <div class="mb-3">
                            <label for="type_id"
                                class="form-label  @error('type_id') text-danger @enderror">Tipologia</label>
                            <select class="form-select @error('type_id') is-invalid @enderror" name="type_id">
                                <option value="">Nessuna Tipologia</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('type_id',$project->type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type_id')
                                <p class="text-danger fw-bold">{{ $message }}</p>
                            @enderror
                        </div>

                    @endif 

                    @if (count($technologies) > 0)

                        <div class="mb-3">
                            <label class="form-check-label d-block mb-2 @error('technologies') text-danger @enderror">
                                Tecnologie
                            </label>
                            @foreach ($technologies as $technology)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input  @error('technologies') is-invalid @enderror"
                                        type="checkbox" id="tech-{{ $technology->id }}" name="technologies[]"
                                        value="{{ $technology->id }}" 
                                        
                                        @if (old('technologies') && is_array(old('technologies')) && count(old('technologies')) > 0) 
                                        {{ in_array($technology->id,old('technologies',[])) ? 'checked': '' }}
                                        @elseif($project->technologies->contains($technology->id))
                                        checked
                                        @endif

                                        
                                        >

                                    <label class="form-check-label @error('technologies') text-danger @enderror"
                                        for="tech-{{ $technology->id }}">{{ $technology->name }}</label>
                                </div>
                            @endforeach
                            @error('technologies')
                                <p class="text-danger fw-bold">{{ $message }}</p>
                            @enderror
                        </div>

                    @endif

                    <div class="mb-3">
                        <label for="featured_image"
                            class="form-label  @error('featured_image') text-danger @enderror">Featured Image</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                            id="featured_image" name="featured_image" {{-- validazione frontend da aggiungere --}} {{-- si usa per i file --}}
                            accept="image/*">
                        @error('featured_image')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    @if (isset($project->featured_image))
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="delete_featured_image" id="delete_featured_image">
                            <label class="form-check-label" for="delete_featured_image">
                                Image Deletion
                            </label>
                        </div>

                        <div class="w-25 mb-3">
                            <img src="{{ asset('storage/' . $project->featured_image) }}" class="img-fluid rounded-start"
                                alt="...">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="description"
                            class="form-label  @error('description') text-danger @enderror">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            placeholder="Lorem ipsum dolor sit amet ..." rows="3" maxlength="4096"> {{ old('description') ?? $project->description }}</textarea>
                        @error('description')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <p>
                            Fields marked with <span class="text-danger fw-bold">*</span> are <span
                                class="text-danger fw-bold">mandatory</span>
                        </p>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success mb-3">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
