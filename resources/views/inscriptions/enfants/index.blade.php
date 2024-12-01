@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Gestion des Enfants</h1>
    <!-- <form method="GET" action="{{ route('enfants.index') }}" class="mb-4">
        <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou prénom" value="{{ request('search') }}">
            <div class="fas fa-search">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </div>
    </form> -->
    <form method="GET" action="{{ route('enfants.index') }}" class="mb-4">
        <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou prénom" value="{{ request('search') }}">
            <div class="fas fa-search">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </div>
    </form>
    <!-- Formulaire de Recherche par Année Scolaire -->
    <form method="GET" action="{{ route('enfants.index') }}" class="mb-4">
        <label for="anneesScolaires">Sélectionnez une Année Scolaire :</label>
        <select name="annee_scolaire" id="anneesScolaires" class="form-control" onchange="this.form.submit()">
            <option value="">-- Toutes les années scolaires --</option>
            @foreach($anneesScolaires as $annee)
                <option value="{{ $annee->id }}" {{ $selectedAnneeScolaire == $annee->id ? 'selected' : '' }}>
                    {{ $annee->anneescolaire }}
                </option>
            @endforeach
        </select>
    </form>




    
    <!-- Liste des Enfants -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Enfant</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Naissance</th>
                    <th>Niveau Scolaire</th>
                    <th>Horraire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody> 

            @foreach($enfants as $enfant)
    <tr>
        <td>{{ $enfant->id }}</td>
        <td>{{ $enfant->nom }}</td>
        <td>{{ $enfant->prenom }}</td>
        <td>{{ $enfant->date_de_naissance }}</td>
        <td> {{ $enfant->niveauScolaire->niveau_scolaire ?? 'N/A' }}</td>
        <td>{{ $enfant->horraire->horraire ?? 'N/A' }}</td>
        <td>
            <a href="{{ route('enfants.edit', $enfant->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form action="{{ route('enfants.destroy', $enfant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enfant?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </td>
    </tr>
@endforeach

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
   <!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $enfants->links() }}
</div>

</div>
@endsection
