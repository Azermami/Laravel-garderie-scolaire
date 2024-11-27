@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Modifier l'Enfant</h1>

    <!-- Affichage des erreurs -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de modification de l'enfant -->
    <form action="{{ route('enfants.update', $enfant->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom <i class="fas fa-user"></i></label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $enfant->nom) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="prenom" class="form-label">Prénom <i class="fas fa-user"></i></label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $enfant->prenom) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date_de_naissance" class="form-label">Date de Naissance <i class="fas fa-calendar-alt"></i></label>
                <input type="date" class="form-control" id="date_de_naissance" name="date_de_naissance" value="{{ old('date_de_naissance', $enfant->date_de_naissance) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="niveau_scolaire" class="form-label">Niveau Scolaire <i class="fas fa-graduation-cap"></i></label>
                <select class="form-select" id="niveau_scolaire" name="niveau_scolaire_id" required>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ (old('niveau_scolaire_id', $enfant->niveau_scolaire_id) == $niveau->id) ? 'selected' : '' }}>
                            {{ $niveau->niveau }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Champ affichant l'année scolaire en cours -->
            <div class="col-md-6 mb-3">
    <label for="anneescolaire" class="form-label">Année Scolaire <i class="fas fa-calendar-alt"></i></label>
    <input type="text" class="form-control" id="anneescolaire" name="anneescolaire" 
           value="{{ $anneeScolaireEnCours ? $anneeScolaireEnCours->anneescolaire : 'Année scolaire non définie' }}" readonly>
    
    <!-- Champ caché pour envoyer l'ID de l'année scolaire en cours -->
    <input type="hidden" name="id_anneescolaire" value="{{ $anneeScolaireEnCours->id }}">
    
</div>

            <div class="col-md-6 mb-3">
                <label for="horraire" class="form-label">Horraire <i class="fas fa-clock"></i></label>
                <select class="form-select" id="horraire" name="horraire_id" required>
                    @foreach($horaires as $horraire)
                        <option value="{{ $horraire->id }}" {{ (old('horraire_id', $enfant->horraire_id) == $horraire->id) ? 'selected' : '' }}>
                            {{ $horraire->horraire }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Modifier
            </button>
            <a href="{{ route('enfants.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </form>
</div>

@endsection
