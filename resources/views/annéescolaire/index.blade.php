@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Gestion des Années Scolaire</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('anneescolaire.create') }}" class="btn btn-primary mb-3">Ajouter une Année Scolaire</a>

    <table class="table">
        <thead>
            <tr>
                <th>Année Scolaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anneesScolaires as $annee)
                <tr>
                    <td>{{ $annee->anneescolaire }}</td>
                    <td>
                        @if($annee->is_current)
                            <span class="badge badge-success">Actuelle</span>
                        @else
                            <form action="{{ route('anneescolaire.setCurrentYear', $annee->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">Activer</button>
                            </form>
                        @endif
                        
                        <!-- Icone de modification -->
                        <a href="{{ route('anneescolaire.edit', $annee->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        <!-- Icone de suppression -->
                        <form action="{{ route('anneescolaire.destroy', $annee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette année scolaire ?');">
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
