@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Gestion des Horaires</h1>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bouton d'ajout avec icône -->
    <div class="text-end mb-3">
        <a href="{{ route('horraire.create') }}" class="btn btn-primary">
            <i class="text-center mb-4"></i> Ajouter un Horaire
        </a>
    </div>

    <!-- Table d'affichage des horaires -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Horaire</th>
                <th>Heure de Début</th>
                <th>Heure de Fin</th>
                <th>Prix</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horraires as $horraire)
                <tr>
                    <td>{{ $horraire->horraire }}</td>
                    <td>{{ $horraire->start_time }}</td>
                    <td>{{ $horraire->end_time }}</td>
                    <td>{{ $horraire->prix_horraire }} €</td>
                    <td class="text-center">
                        <!-- Bouton de modification avec icône -->
                        <a href="{{ route('horraire.edit', $horraire->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        <!-- Bouton de suppression avec icône -->
                        <form action="{{ route('horraire.destroy', $horraire->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Ajouter CDN FontAwesome pour les icônes -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
