@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Modifier le Niveau Scolaire</h1>

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

    <!-- Formulaire de modification du niveau scolaire -->
    <form action="{{ route('niveau-scolaire.update', $niveau->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="niveau_scolaire" class="form-label">Niveau <i class="fas fa-graduation-cap"></i></label>
                <input type="text" class="form-control" id="niveau_scolaire" name="niveau_scolaire" value="{{ old('niveau_scolaire', $niveau->niveau_scolaire) }}" required>
            </div>

            <div class="col-md-3 mb-3">
                <label for="debut_annee" class="form-label">Début Année <i class="fas fa-calendar-alt"></i></label>
                <input type="number" class="form-control" id="debut_annee" name="debut_annee" value="{{ old('debut_annee', $niveau->debut_annee) }}" required>
            </div>

            <div class="col-md-3 mb-3">
                <label for="fin_annee" class="form-label">Fin Année <i class="fas fa-calendar-check"></i></label>
                <input type="number" class="form-control" id="fin_annee" name="fin_annee" value="{{ old('fin_annee', $niveau->fin_annee) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="prix_niveau" class="form-label">Prix Niveau <i class="fas fa-euro-sign"></i></label>
                <input type="number" step="0.01" class="form-control" id="prix_niveau" name="prix_niveau" value="{{ old('prix_niveau', $niveau->prix_niveau) }}" required>
            </div>
        </div>

        <div class="text-center">
            <!-- Bouton de modification avec icône -->
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Modifier
            </button>
            <!-- Bouton de retour avec icône -->
            <a href="{{ route('niveau-scolaire.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </form>
</div>

<!-- Ajouter CDN FontAwesome pour les icônes -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

@endsection
