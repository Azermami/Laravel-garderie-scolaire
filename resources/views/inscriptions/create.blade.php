@extends('layouts.user_type.auth')

@section('content')
<!-- Contact Section-->
<section class="page-section" id="registration">
    <div class="container">
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Inscription Enfant</h2>
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="registrationForm" method="POST" action="{{ route('register.child') }}">
                    @csrf
                    
                    <!-- Champs pour le parent -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="parent_name" name="parent_name" type="text" placeholder="Enter your name..." required />
                        <label for="parent_name">Nom du parent</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="parent_firstname" name="parent_firstname" type="text" placeholder="Entrez votre prénom..." required />
                        <label for="parent_firstname">Prénom du parent</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" required />
                        <label for="email">Adresse email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone" name="phone" type="tel" placeholder="(123) 456-7890" required />
                        <label for="phone">Numéro de téléphone</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="password" name="password" type="password" placeholder="Mot de passe" required />
                        <label for="password">Mot de passe</label>
                    </div>

                    <!-- Champs pour les enfants -->
                    <div id="children-container">
                        <!-- Les champs pour les enfants seront ajoutés dynamiquement ici -->
                    </div>
                    @if(isset($currentAnneeScolaire))
    <input type="hidden" name="id_anneescolaire" value="{{ $currentAnneeScolaire->id }}">
@endif




                    <button type="button" class="btn btn-secondary" id="add-child-button">Ajouter un enfant</button>
                    <br />
                    <button class="btn btn-primary btn-xl mt-3" id="submitButton" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Script JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addChildButton = document.getElementById('add-child-button');
    const childrenContainer = document.getElementById('children-container');

    // Initialisation de l'index des enfants
    let childIndex = 0;

    addChildButton.addEventListener('click', function() {
        const childHtml = `
            <div class="form-floating mb-3">
                <input class="form-control" id="child_name_${childIndex}" name="children[${childIndex}][name]" type="text" placeholder="Nom de l'enfant..." required />
                <label for="child_name_${childIndex}">Nom de l'enfant ${childIndex + 1}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="child_prenom_${childIndex}" name="children[${childIndex}][prenom]" type="text" placeholder="Prénom de l'enfant..." required />
                <label for="child_prenom_${childIndex}">Prénom de l'enfant ${childIndex + 1}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="child_birthdate_${childIndex}" name="children[${childIndex}][date_de_naissance]" type="date" required />
                <label for="child_birthdate_${childIndex}">Date de naissance de l'enfant ${childIndex + 1}</label>
            </div>
            
            <div class="form-floating mb-3">
                <select class="form-select" id="child_niveau_scolaire_${childIndex}" name="children[${childIndex}][niveau_scolaire_id]" onchange="fetchAnnees(this.value, ${childIndex})" required>
                    <option value="" disabled selected>Choisir un niveau scolaire</option>
                    @foreach($niveauxScolaires as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->niveau_scolaire }}</option>
                    @endforeach
                </select>
                <label for="child_niveau_scolaire_${childIndex}">Niveau scolaire</label>
            </div>

            <!-- Conteneur pour afficher les années scolaires disponibles -->
            <div class="form-floating mb-3" id="annees-container-${childIndex}">
                <!-- Les options seront ajoutées ici -->
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="child_horraire_${childIndex}" name="children[${childIndex}][horraire_id]" required>
                    <option value="" disabled selected>Choisir un horaire</option>
                    @foreach($horraires as $horraire)
                        <option value="{{ $horraire->id }}">{{ $horraire->horraire }}</option>
                    @endforeach
                </select>
                <label for="child_horraire_${childIndex}">Horaire</label>
            </div>
        `;
        childrenContainer.insertAdjacentHTML('beforeend', childHtml);
        childIndex++;
    });
});
</script>

<script>
function fetchAnnees(niveauScolaireId, childIndex) {
    if (!niveauScolaireId) return;

    fetch(`/api/niveaux/${niveauScolaireId}/annees`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById(`annees-container-${childIndex}`);

            // Crée une liste déroulante pour les années
            if (data.debut_annee && data.fin_annee) {
                let options = `<select class="form-select" name="children[${childIndex}][annee]" required>`;
                for (let annee = data.debut_annee; annee <= data.fin_annee; annee++) {
                    options += `<option value="${annee}">${annee}ème année</option>`;
                }
                options += `</select>`;
                
                container.innerHTML = options;
            } else {
                container.innerHTML = `<p>Aucune année disponible</p>`;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}
</script>

@endsection
