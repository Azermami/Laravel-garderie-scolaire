@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Gestion des Paiements</h1>

    <form method="GET" action="{{ route('paiements.index') }}" class="mb-4">
        <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou prénom" value="{{ request('search') }}">
            <div class="fas fa-search">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </div>
    </form>

    <a href="{{ route('paiements.create') }}" class="btn btn-primary mb-3">Ajouter un Paiement</a>

    @if($paiements->isEmpty())
        <p class="text-center">Aucun paiement enregistré pour l'instant.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Montant</th>
                    <th>Méthode de Paiement</th>
                    <th>Date</th>
                    <th>Enfant</th>
                    <th>Montant Restant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id }}</td>
                        <td>{{ $paiement->montant }}</td>
                        <td>{{ ucfirst($paiement->mode_paiement) }}</td>
                        <td>{{ $paiement->created_at->format('d/m/Y') }}</td>
                        <td>{{ $paiement->enfant->nom }} {{ $paiement->enfant->prenom }}</td>
                        <td>
                            @php
                                // Montant total dû pour l'enfant
                                $montant_total = ($paiement->enfant->niveauScolaire ? $paiement->enfant->niveauScolaire->prix_niveau : 0) +
                                                 ($paiement->enfant->horraire ? $paiement->enfant->horraire->prix_horraire : 0);

                                // Montant total déjà payé pour cet enfant
                                $montant_total_paye = $paiement->enfant->paiements()->sum('montant');

                                // Montant restant
                                $montant_restant = $montant_total - $montant_total_paye;
                            @endphp
                            {{ $montant_restant > 0 ? $montant_restant : 'Complet' }}
                        </td>
                        <td>
                            <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-info btn-sm">Détails</a>
                            <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
