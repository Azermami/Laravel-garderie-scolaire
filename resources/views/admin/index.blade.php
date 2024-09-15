@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Gestion des Personnels</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.personnel.create') }}" class="btn btn-primary mb-3">Ajouter un Personnel</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personnels as $personnel)
                <tr>
                    <td>{{ $personnel->id }}</td>
                    <td>{{ $personnel->name }}</td>
                    <td>{{ $personnel->email }}</td>
                    <td>
                        <a href="{{ route('admin.personnel.edit', $personnel->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('admin.personnel.destroy', $personnel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
