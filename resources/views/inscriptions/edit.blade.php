@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Modifier les Informations du Parent</h1>

    <form action="{{ route('inscriptions.update', $parent->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" value="{{ $parent->nom }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $parent->email }}" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="form-control" value="{{ $parent->telephone }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</div>
@endsection
