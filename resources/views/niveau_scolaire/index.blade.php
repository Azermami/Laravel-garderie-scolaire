@extends('layouts.user_type.auth')

@section('content')

<!-- Ajout de FontAwesome CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<div class="container">
    <h1 class="text-center mb-4">Gestion des Niveaux Scolaires</h1>
    
    <div class="text-center mb-4">
        <!-- Ajouter un Niveau Scolaire avec icône -->
        <a href="{{ route('niveau-scolaire.create') }}" class="btn btn-primary mx-2" title="Ajouter un Niveau Scolaire">
            <i class="fas fa-plus-circle"></i> Ajouter
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Niveau Scolaire</th>
                    <th>Début Année</th>
                    <th>Fin Année</th>
                    <th>Prix</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($niveaux as $niveau)
                <tr>
                    <td>{{ $niveau->id }}</td>
                    <td>{{ $niveau->niveau_scolaire }}</td>
                    <td>{{ $niveau->debut_annee }}</td>
                    <td>{{ $niveau->fin_annee }}</td>
                    <td>{{ $niveau->prix_niveau }} €</td>
                                        <td class="text-center">
                        <!-- Bouton de modification avec icône -->
                        <a href="{{ route('niveau-scolaire.edit', $niveau->id) }}" class="btn btn-sm btn-warning mx-1" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Bouton de suppression avec icône -->
                        <form action="{{ route('niveau-scolaire.destroy', $niveau->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce niveau scolaire ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mx-1" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $niveaux->links() }}
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

@endsection
