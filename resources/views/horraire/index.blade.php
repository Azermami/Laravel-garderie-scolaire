@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Gestion des Horaires</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('horraire.create') }}" class="btn btn-primary mb-3">Ajouter un Horaire</a>

    <table class="table">
        <thead>
            <tr>
                <th>Horaire</th>
                <th>Heure de Début</th>
                <th>Heure de Fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horraires as $horraire)
                <tr>
                    <td>{{ $horraire->horraire }}</td>
                    <td>{{ $horraire->start_time }}</td>
                    <td>{{ $horraire->end_time }}</td>
                    <td>
                        <!-- Icône de modification -->
                        <a href="{{ route('horraire.edit', $horraire->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        <!-- Icône de suppression -->
                        <form action="{{ route('horraire.destroy', $horraire->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');">
        <i class="fas fa-trash"></i>
    </button>
</form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
