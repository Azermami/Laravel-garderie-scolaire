@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Liste des Personnels</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.personnel.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-user-plus"></i> Ajouter un Personnel
    </a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personnels as $personnel)
                <tr>
                    <td>{{ $personnel->nom }}</td>
                    <td>{{ $personnel->prenom }}</td>
                    <td>{{ $personnel->email }}</td>
                    <td>
                        <!-- Modifier avec icône -->
                        <a href="{{ route('admin.personnel.edit', $personnel->id) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Modifier">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        <!-- Modal pour confirmation de suppression -->
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $personnel->id }}" data-toggle="tooltip" data-placement="top" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>

                        <!-- Modal de confirmation -->
                        <div class="modal fade" id="deleteModal{{ $personnel->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $personnel->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $personnel->id }}">Confirmer la Suppression</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer ce personnel ?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.personnel.destroy', $personnel->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $personnels->links() }}
    </div>
</div>

<!-- Scripts pour Bootstrap et FontAwesome -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

@endsection
