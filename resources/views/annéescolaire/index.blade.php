@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Gestion des Années Scolaire</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('anneescolaire.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une Année Scolaire
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Année Scolaire</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anneesScolaires as $annee)
                    <tr>
                        <td>
                            {{ $annee->anneescolaire }} 
                            @if($annee->is_current)
                                <span class="badge bg-success ms-2">Actuelle</span>
                            @endif
                        </td>
                        <td>
                            <!-- Activer l'année scolaire si elle n'est pas actuelle -->
                            @if(!$annee->is_current)
                                <form action="{{ route('anneescolaire.setCurrentYear', $annee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Définir comme actuelle">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Bouton de modification -->
                            <a href="{{ route('anneescolaire.edit', $annee->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Modifier">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <!-- Formulaire de suppression -->
                            <form action="{{ route('anneescolaire.destroy', $annee->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette année scolaire ?');" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $anneesScolaires->links() }}
    </div>
</div>

<!-- FontAwesome Kit for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
