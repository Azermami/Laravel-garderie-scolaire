@extends('layouts.user_type.parent_auth')
@section('content')
    <div class="container">
        <h1>Suivi de mes paiements</h1>

        @if($paiements->isEmpty())
            <p>Aucun paiement enregistré pour le moment.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Montant</th>
                        <th>Date de paiement</th>
                        <th>Status</th>
                        <th>Enfant</th>
                        <th>Mode de paiement</th>
                        <th>Montant restant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $paiement)
                        <tr>
                            <td>{{ $paiement->montant }} €</td>
                            <td>{{ $paiement->date_paiement }}</td>
                            <td>{{ ucfirst($paiement->status) }}</td>
                            <td>{{ $paiement->enfant->nom ?? 'N/A' }}</td>
                            <td>{{ ucfirst($paiement->mode_paiement) }}</td>
                            
                            <!-- Affichage du montant restant si paiement en tranche -->
                            @php
                                $montant_total = ($paiement->enfant->niveauScolaire ? $paiement->enfant->niveauScolaire->prix_niveau : 0) + 
                                                 ($paiement->enfant->horraire ? $paiement->enfant->horraire->prix_horraire : 0);
                                $montant_paye = $paiement->enfant->paiements()->sum('montant');
                                $montant_restant = $montant_total - $montant_paye;
                            @endphp
                            <td>
                                @if($paiement->mode_paiement === 'tranche')
                                    {{ $montant_restant }} €
                                @else
                                    Aucun montant restant
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
