@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Modifier l'Horaire</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('horraire.update', $horraire->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Champ Horaire -->
        <div class="mb-3">
            <label for="horraire" class="form-label">Horaire</label>
            <input type="text" class="form-control" id="horraire" name="horraire" value="{{ old('horraire', $horraire->horraire) }}" required>
        </div>

        <!-- Champ Heure de Début -->
        <div class="mb-3">
            <label for="start_time" class="form-label">Heure de Début</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($horraire->start_time)->format('H:i')) }}" required>
        </div>

        <!-- Champ Heure de Fin -->
        <div class="mb-3">
            <label for="end_time" class="form-label">Heure de Fin</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($horraire->end_time)->format('H:i')) }}" required>
        </div>

        <div class="mb-3">
            <label for="prix_horraire" class="form-label">Prix Horaire</label>
            <input type="number" step="0.01" class="form-control" id="prix_horraire" name="prix_horraire" value="{{ old('prix_horraire', $horraire->prix_horraire) }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="{{ route('horraire.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
