
@extends('layouts.user_type.parent_auth')
@section('content')
    <div class="container">
        <h1>Suivi de mes enfants</h1>

        @if($enfants->isEmpty())
            <p>Vous n'avez pas encore enregistré d'enfants.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Niveau scolaire</th>
                        <th>Horaire</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enfants as $enfant)
                        <tr>
                            <td>{{ $enfant->nom }}</td>
                            <td>{{ $enfant->prenom }}</td>
                            <td>{{ $enfant->date_de_naissance }}</td>
                            <td> {{ $enfant->niveauScolaire->niveau_scolaire ?? 'N/A' }}</td>
                            <td>{{ $enfant->horraire->horraire ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection