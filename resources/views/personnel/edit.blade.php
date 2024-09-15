@extends('layouts.user_type.auth')

@section('content')
    <h1>Modifier Personnel</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.personnel.update', $personnel->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $personnel->nom) }}" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" value="{{ old('prenom', $personnel->prenom) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $personnel->email) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Modifier</button>
    </form>
@endsection
