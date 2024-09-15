@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Ajouter un Niveau Scolaire</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('niveau-scolaire.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="niveau_scolaire" class="form-label">Niveau</label>
            <input type="text" class="form-control" id="niveau_scolaire" name="niveau_scolaire" value="{{ old('niveau_scolaire') }}" required>
        </div>

        <div class="mb-3">
            <label for="debut_annee" class="form-label">Début Année</label>
            <input type="number" class="form-control" id="debut_annee" name="debut_annee" value="{{ old('debut_annee') }}" required>
        </div>

        <div class="mb-3">
            <label for="fin_annee" class="form-label">Fin Année</label>
            <input type="number" class="form-control" id="fin_annee" name="fin_annee" value="{{ old('fin_annee') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="{{ route('niveau-scolaire.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
