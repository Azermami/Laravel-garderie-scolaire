<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Garderie Online </title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
</head>
<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">Garderie Online</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">WELCOME</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('login') }}">Me Connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <img class="masthead-avatar mb-5" src="{{ asset('assets/img/avataaars.svg') }}" alt="..." />
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">Garderie Online</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">Soutien scolaire -Activité - évenements</p>
        </div>
    </header>
    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Actualité</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                <!-- Portfolio Items-->
                @for($i = 1; $i <= 6; $i++)
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal{{ $i }}">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="{{ asset("assets/img/portfolio/item$i.png") }}" alt="..." />
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- About Section-->
    <section class="page-section bg-primary text-white mb-0" id="about">
        <div class="container">
            <!-- About Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- About Section Content-->
            <div class="row">
                <div class="col-lg-4 ms-auto"><p class="lead">C'est un accueil de loisirs fonctionnant dans l'école le matin, le midi et le soir. Il est une structure éducative habilitée pour accueillir de manière habituelle et collective des enfants par des activités de loisirs, à l'exclusion de la formation.</p></div>
                <div class="col-lg-4 me-auto"><p class="lead">Les garderies sont totalement indépendantes des écoles : elles sont gérées par la mairie ou par une association.</p></div>
            </div>
            
        </div>
    </section>
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
                    <div id="children-container">
                        <!-- Dynamically added child registration fields will go here -->
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-child-button">Ajouter un enfant</button>
                    <br />
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addChildButton = document.getElementById('add-child-button');
    const childrenContainer = document.getElementById('children-container');

    // Initialisation de l'index des enfants
    let childIndex = childrenContainer.children.length / 4;

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
                <select class="form-select" id="child_niveau_scolaire_${childIndex}" name="children[${childIndex}][niveau_scolaire_id]" required>
                    <option value="" disabled selected>Choisir un niveau scolaire</option>
                    @foreach($niveauxScolaires as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->niveau }}</option>
                    @endforeach
                </select>
                <label for="child_niveau_scolaire_${childIndex}">Niveau scolaire</label>
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




    <!-- Footer-->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Location</h4>
                    <p class="lead mb-0">
                        DJERBA HOMMET SOUK
                        <br />
                        9000
                    </p>
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Around the Web</h4>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a>
                </div>
                <!-- Footer About Text-->
                <div class="col-lg-4">
                    <h4 class="text-uppercase mb-4">Contact</h4>
                    <p class="lead mb-0">
                        Email:djerba@djerba.com
                        <a href="http://startbootstrap.com">216-0000000</a>.
                    </p>
                </div>
            </div>
        </div>
    </footer>
   
    <!-- Portfolio Modals-->
    @for($i = 1; $i <= 6; $i++)
        <div class="portfolio-modal modal fade" id="portfolioModal{{ $i }}" tabindex="-1" aria-labelledby="portfolioModal{{ $i }}Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Portfolio Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0" id="portfolioModal{{ $i }}Label">Portfolio Item {{ $i }}</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <!-- Portfolio Modal - Image-->
                                    <img class="img-fluid rounded mb-5" src="{{ asset("assets/img/portfolio/item$i.png") }}" alt="..." />
                                    <!-- Portfolio Modal - Text-->
                                    <p class="mb-4">Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-xmark fa-fw"></i>
                                        Close Window
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
