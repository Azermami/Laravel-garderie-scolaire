@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Ajouter une Année Scolaire</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('anneescolaire.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="anneescolaire" class="form-label">Année Scolaire</label>
            <input type="text" class="form-control" id="anneescolaire" name="anneescolaire" value="{{ old('anneescolaire') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="{{ route('anneescolaire.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
