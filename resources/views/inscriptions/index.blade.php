@extends('layouts.user_type.auth')

@section('content')


<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<div class="container">
    <h1 class="text-center mb-4">Gestion des Parents</h1>
    
    <div class="text-center mb-4">
        <!-- Ajouter Parent avec icône -->
        <a href="{{ route('inscriptions.create') }}" class="btn btn-primary mx-2" title="Ajouter Parent">
            <i class="fas fa-user-plus"></i>
        </a>

        <!-- Non Validés avec icône -->
        <a href="{{ route('inscriptions.index', ['etat' => 0]) }}" class="btn btn-warning mx-2" title="Non Validés">
            <i class="fas fa-hourglass-half"></i>
        </a>

        <!-- Validés avec icône -->
        <a href="{{ route('inscriptions.index', ['etat' => 1]) }}" class="btn btn-success mx-2" title="Validés">
            <i class="fas fa-check-circle"></i>
        </a>
    </div>

    <!-- Formulaire de Recherche -->
    <form method="GET" action="{{ route('inscriptions.index') }}" class="mb-4">
        <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou prénom" value="{{ request('search') }}">
            <div class="fas fa-search">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </div>
    </form>

    <!-- Liste déroulante pour les années scolaires -->
    <div class="mb-4">
        <form method="GET" action="{{ route('inscriptions.index') }}">
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
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Parent</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($personnels as $personnel)
                <tr>
                    <td>{{ $personnel->id }}</td>
                    <td>{{ $personnel->nom }}</td>
                    <td>{{ $personnel->prenom }}</td>
                    <td>{{ $personnel->email }}</td>
                    <td>
                        <!-- Détails des Enfants avec icône -->
                        <button class="btn btn-info" data-toggle="modal" data-target="#enfantsModal{{ $personnel->id }}" title="Détails des Enfants">
                            <i class="fas fa-child"></i>
                        </button>

                        <!-- Modal pour afficher les détails des enfants -->
                        <div class="modal fade" id="enfantsModal{{ $personnel->id }}" tabindex="-1" aria-labelledby="enfantsModalLabel{{ $personnel->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enfantsModalLabel{{ $personnel->id }}">Détails des Enfants</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($personnel->enfants->isEmpty())
                    <p>Aucun enfant enregistré pour ce parent.</p>
                @else
                    <ul class="list-group">
                        @foreach($personnel->enfants as $enfant)
                            <li class="list-group-item">
                                <strong>Nom:</strong> {{ $enfant->nom }}<br>
                                <strong>Prénom:</strong> {{ $enfant->prenom }}<br>
                                <strong>Date de Naissance:</strong> {{ $enfant->date_de_naissance }}<br>
                                <strong>Niveau Scolaire:</strong> {{ $enfant->niveauScolaire->niveau_scolaire ?? 'N/A' }}<br>
                                <strong>Horraire:</strong> {{ $enfant->horraire->horraire ?? 'N/A' }}<br>
                                <strong>id_parent:</strong> {{ $enfant->id_parent ?? 'N/A' }}<br>
                                <strong>Niveau_class:</strong> {{ $enfant->class ?? 'N/A' }}<br>

                                <!-- Bouton Modifier -->
                                <a href="{{ route('enfants.edit', $enfant->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>

                                <!-- Bouton Supprimer -->
                                <form action="{{ route('enfants.destroy', $enfant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enfant?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <form action="{{ route('inscriptions.validate', $personnel->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Valider
                    </button>
                </form>
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

    <div class="d-flex justify-content-center">
        {{ $personnels->appends(['etat' => $etat, 'search' => request('search'), 'annee_scolaire' => $selectedAnneeScolaire])->links() }}
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
