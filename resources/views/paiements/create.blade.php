@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Ajouter un Paiement</h1>
    
    <form action="{{ route('paiements.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="montant" class="form-label">Montant Total</label>
            <input type="number" name="montant" class="form-control" id="montant" placeholder="Montant du paiement" readonly required>
        </div>

        <div class="mb-3">
            <label for="mode_paiement" class="form-label">Méthode de Paiement</label>
            <select name="mode_paiement" id="mode_paiement" class="form-control" required>
                <option value="espece">Espèce</option>
                <option value="virement">Virement Bancaire</option>
                <option value="cheque">Chèque</option>
                <option value="tranche">Tranche</option>
            </select>
        </div>

        <div class="mb-3" id="montantTranche" style="display:none;">
            <label for="montant_paye" class="form-label">Montant de la Tranche</label>
            <input type="number" name="montant_paye" class="form-control" id="montant_paye" placeholder="Montant de la tranche">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Statut du paiement</label>
            <select name="status" id="status" class="form-control" required>
                <option value="en attente">En attente</option>
                <option value="complet">Complet</option>
                <option value="annulé">Annulé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="enfant_id" class="form-label">Enfant</label>
            <select name="enfant_id" id="enfant_id" class="form-control" required>
                @foreach($enfants as $enfant)
                    <option value="{{ $enfant->id }}">{{ $enfant->nom }} {{ $enfant->prenom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Ajouter Paiement</button>
    </form>
</div>

<script>
    document.getElementById('enfant_id').addEventListener('change', function() {
        var enfantId = this.value;

        if (enfantId) {
            fetch('/get-montant?enfant_id=' + enfantId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('montant').value = data.montant;
                })
                .catch(error => console.error('Erreur:', error));
        }
    });

    document.getElementById('mode_paiement').addEventListener('change', function() {
    var selectedValue = this.value;
    var montantTrancheField = document.getElementById('montantTranche');
    
    if (selectedValue === 'tranche') {
        montantTrancheField.style.display = 'block';
        document.getElementById('montant_paye').required = true; // Rendre le champ obligatoire
    } else {
        montantTrancheField.style.display = 'none';
        document.getElementById('montant_paye').required = false; // Désactiver l'obligation
    }
});

</script>
@endsection
