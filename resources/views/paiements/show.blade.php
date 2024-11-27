@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Détails du Paiement</h1>

    <div class="card">
        <div class="card-body">
            
            <p><strong>Montant payé:</strong> {{ $paiement->montant }} €</p>
            <p><strong>Méthode de Paiement:</strong> {{ ucfirst($paiement->methode_paiement) }}</p>
            <p><strong>Date du Paiement:</strong> {{ $paiement->created_at->format('d/m/Y') }}</p>
            <p><strong>Enfant:</strong> {{ $paiement->enfant->nom }} {{ $paiement->enfant->prenom }}</p>
            <p><strong>Montant total dû:</strong> {{ $montant_total }} €</p>
            <p><strong>Montant restant:</strong> {{ $montant_restant > 0 ? $montant_restant : 'Complet' }} €</p>
            <a href="{{ route('paiements.recu', $paiement->id) }}" class="btn btn-success">
                <i class="fas fa-receipt"></i> Télécharger le reçu
            </a>
            <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
@endsection
