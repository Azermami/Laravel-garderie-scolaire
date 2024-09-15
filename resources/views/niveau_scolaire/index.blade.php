@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Liste des Niveaux Scolaires</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('niveau-scolaire.create') }}" class="btn btn-primary mb-3">Ajouter un Niveau Scolaire</a>

    <table class="table">
        <thead>
            <tr>
                <th>Niveau Scolaire</th>
                <th>Début Année</th>
                <th>Fin Année</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($niveaux as $niveau)
            <tr>
                <td>{{ $niveau->niveau_scolaire }}</td>
                <td>{{ $niveau->debut_annee }}</td>
                <td>{{ $niveau->fin_annee }}</td>
                <td>
                    <!-- Icône de modification -->
                    <a href="{{ route('niveau-scolaire.edit', $niveau->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-pencil-alt"></i>
                    </a>

                    <!-- Icône de suppression -->
                    <form action="{{ route('niveau-scolaire.destroy', $niveau->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce niveau scolaire ?');">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
