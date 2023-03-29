<form action="{{ route('admin.types.destroy', $type->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')

    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
        data-bs-target="#exampleModal{{ $type->id }}">
        <i class="fa-solid fa-trash"></i>
    </button>

    <div class="modal fade" id="exampleModal{{ $type->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel{{ $type->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                @if ($type->projects()->count() == 0)
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
                            <span class="fw-bold">Id:</span> {{ $type->id }}
                        </li>
                        <li>
                            <span class="fw-bold">Nome:</span> {{ $type->name }}
                        </li>
                        <li>
                            <span class="fw-bold">Slug:</span> {{ $type->slug }}
                        </li>
                        <li>
                            <span class="fw-bold"># Progetti:</span> {{ $type->projects()->count() }}
                        </li>
                    </ul>
                    <div class="py-4">
                        <input class="form-check-input text-bg-danger" type="checkbox" id="flexCheckDefault" required>
                        <label class="form-check-label " for="flexCheckDefault">
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
            @else
                <div class="alert alert-danger mb-0">
                    <h5>
                        <i class="fa-solid fa-xmark"></i> Attenzione
                    </h5>
                    <p>
                        Non puoi eliminare una tipologia che contiene uno o più progetti!
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>

                    </div>
                    
                </div>
                @endif
            </div>
        </div>
    </div>
</form>
