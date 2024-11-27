<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; }
        .details { margin-top: 20px; }
        .details p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Reçu de Paiement</h1>

    <div class="details">
        <p><strong>Montant payé:</strong> {{ $paiement->montant }} €</p>
        <p><strong>Méthode de Paiement:</strong> {{ ucfirst($paiement->mode_paiement) }}</p>
        <p><strong>Date du Paiement:</strong> {{ $paiement->created_at->format('d/m/Y') }}</p>
        <p><strong>Enfant:</strong> {{ $paiement->enfant->nom }} {{ $paiement->enfant->prenom }}</p>
        <p><strong>Montant total dû:</strong> {{ $montant_total }} €</p>
        <p><strong>Montant restant:</strong> {{ $montant_restant > 0 ? $montant_restant : 'Complet' }} €</p>
    </div>

    <p style="text-align: center; margin-top: 50px;">Merci pour votre paiement.</p>
</body>
</html>
