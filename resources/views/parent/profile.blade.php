@extends('layouts.user_type.parent_auth')

@section('content')
<div class="container">
    <h1>Mon Profil</h1>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Formulaire pour mettre à jour les informations du profil -->
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" class="form-control" name="nom" value="{{ old('nom', $user->nom) }}" required>
            @error('nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" class="form-control" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
            @error('prenom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone:</label>
            <input type="text" class="form-control" name="telephone" value="{{ old('telephone', $user->telephone) }}" required>
            @error('telephone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

    <!-- Formulaire pour changer le mot de passe -->
    <hr>
    <h3>Changer le mot de passe</h3>
    <form action="{{ route('profile.updatePassword') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="current_password">Mot de passe actuel:</label>
            <input type="password" class="form-control" name="current_password" required>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Nouveau mot de passe:</label>
            <input type="password" class="form-control" name="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe:</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-danger">Changer le mot de passe</button>
    </form>
</div>
@endsection
