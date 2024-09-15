@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Liste des Personnels</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.personnel.create') }}" class="btn btn-primary mb-3">Ajouter un Personnel</a>

    <table class="table">
        <thead>
            <tr>
                
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personnels as $personnel)
            <tr>
                
                <td>{{ $personnel->nom }}</td>
                <td>{{ $personnel->prenom }}</td>
                <td>{{ $personnel->email }}</td>
                <td>
                    <!-- Lien de modification avec icône -->
                    <a href="{{ route('admin.personnel.edit', $personnel->id) }}" class="btn btn-warning">
                        <i class="fas fa-pencil-alt"></i> <!-- Icône de modification -->
                    </a>
                    
                    <!-- Formulaire de suppression avec icône -->
                    <form action="{{ route('admin.personnel.destroy', $personnel->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce personnel ?');">
                            <i class="fas fa-trash"></i> <!-- Icône de suppression -->
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $personnels->links() }}
    </div>
</div>
@endsection
