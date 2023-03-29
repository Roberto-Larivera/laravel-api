
<form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')

    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $project->id }}">
        <i class="fa-solid fa-trash"></i>
    </button>

    <div class="modal fade" id="exampleModal{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger fs-2">Conferma Eliminazione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <p class="fs-5">Sei sicuro di voler eliminare?</p>
                    <p class="fs-5 text-danger">Questa azione è irreversibile.</p>
                    <p>Dettagli:</p>
                    <ul class="list-unstyled g-3">
                         
                        <li>
                            <span class="fw-bold" >Id:</span> {{ $project->id }}
                        </li>
                        <li>
                            <span class="fw-bold" >Titolo:</span> {{ $project->title }}
                        </li>
                        <li>
                            <span class="fw-bold" >Slug:</span> {{ $project->slug }}
                        </li>
                        <li>
                            <span class="fw-bold" >Name Repo:</span> {{ $project->name_repo }}
                        </li>
                        <li class="text-truncate">
                            <span class="fw-bold" >Link Repo:</span> {{ $project->link_repo }}
                        </li>
                        <li class="text-truncate">
                            <span class="fw-bold" >Img Repo:</span> {{ $project->img_repo }}
                        </li>
                        <li class="text-truncate">
                            <span class="fw-bold" >Description:</span> {{ $project->description }}
                        </li>
                    </ul>
                    <div class="py-4">
                        <input class="form-check-input text-bg-danger" type="checkbox" id="flexCheckDefault" required>
                        <label class="form-check-label " for="flexCheckDefault" >
                            Spunta per confermare*
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger">
                        Conferma Eliminazione
                    </button>
                </div>
            </div>
        </div>
    </div>
</form> 

