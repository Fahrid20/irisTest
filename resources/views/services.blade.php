@extends('layouts.app') 
 
@section('content') 
<div class="container my-5"> 


        <!-- afficher um message quand on envoie un mail -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    <!-- Titre principal --> 
    <h1 class="text-center mb-4">Service Client</h1> 
    <h3 class="text-center mb-4">Bonjour. Comment pouvons-nous vous aider ?</h3> 
 
    <!-- Sections principales --> 
    <div class="row"> 
        <!-- Section FAQ --> 
        <div class="col-md-6 mb-4"> 
            <section class="mb-5"> 
                <h2 class="mb-3">Questions Fréquentes</h2> 
                <div id="faqAccordion"> 
                    <div class="card mb-3"> 
                        <div class="card-header" id="faqOne"> 
                            <h5 class="mb-0"> 
                                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> 
                                    Comment suivre ma commande ? 
                                </button> 
                            </h5> 
                        </div> 
                        <div id="collapseOne" class="collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion"> 
                            <div class="card-body"> 
                                Vous pouvez suivre votre commande en accédant à votre compte et en sélectionnant "Mes commandes". 
                            </div> 
                        </div> 
                    </div> 
 
                    <div class="card mb-3"> 
                        <div class="card-header" id="faqTwo"> 
                            <h5 class="mb-0"> 
                                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> 
                                    Quelle est la politique de retour ? 
                                </button> 
                            </h5> 
                        </div> 
                        <div id="collapseTwo" class="collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion"> 
                            <div class="card-body"> 
                                Vous pouvez retourner un article dans les 30 jours suivant la réception, sous réserve qu'il soit dans son état d'origine. 
                            </div> 
                        </div> 
                    </div> 
 
                    <button type="submit" class="btn btn-primary">Plus de FAQ</button> 
 
                </div> 
            </section> 
        </div> 
 
        <!-- Section Formulaire de Contact --> 
        <div class="col-md-6 mb-4" id="aideServices"> 
            <section class="mb-5"> 
                <h2 class="mb-3">Contactez-nous</h2> 
                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf 
                    <div class="mb-3"> 
                        <label for="name" class="form-label">Nom</label> 
                        <input type="text" class="form-control contact-form-input" id="name" name="name" required> 
                    </div> 
                    <div class="mb-3"> 
                        <label for="email" class="form-label">Adresse e-mail</label> 
                        <input type="email" class="form-control contact-form-input" id="email" name="email" required> 
                    </div> 
                    <div class="mb-3"> 
                        <label for="message" class="form-label">Message</label> 
                        <textarea class="form-control contact-form-input" id="message" name="message" rows="4" required></textarea> 
                    </div> 
                    <button type="submit" class="btn btn-primary">Envoyer</button> 
                </form> 
            </section> 
        </div> 
 
        <!-- Section Liens Rapides --> 
        <div class="col-md-6 mb-4"> 
            <section> 
                <h2 class="mb-3">Liens Rapides</h2> 
                <ul class="list-group"> 
                    <li class="list-group-item"> 
                        <a href="#">Suivre une commande</a> 
                    </li>
<li class="list-group-item"> 
                        <a href="#">Politique de retour</a> 
                    </li> 
                    <li class="list-group-item"> 
                        <a href="#">Aide sur mon compte</a> 
                    </li> 
                </ul> 
            </section> 
        </div> 
    </div> 
</div> 
@endsection 
 
 
<style> 
 
/* Styles pour la page Service Client */ 
.service-client-container { 
    margin-top: 50px; 
} 
 
.card-header button { 
    color: #007bff; 
    text-decoration: none; 
} 
 
.card-header button:hover { 
    color: #0056b3; 
} 
 
.list-group-item a { 
    color: #333; 
    text-decoration: none; 
} 
 
.list-group-item a:hover { 
    color: #007bff; 
} 
 
/* Styles pour les sections */ 
section { 
    margin-bottom: 30px; 
} 
 
/* Sections contatez-nous */ 
input{ 
    margin-left : 2O%; 
    width: 80%; 
} 
 
/* Section Questions Fréquentes */ 
#faqAccordion .card-header { 
    background-color: #f8f9fa; 
} 
 
/* Pour les écrans plus petits (Mobile et Tablette) */ 
@media (max-width: 767px) { 
    .col-md-6 { 
        margin-bottom: 20px; 
    } 
} 
 
/* Pour les grands écrans (Desktop) */ 
@media (min-width: 768px) { 
    .col-md-6 { 
        margin-bottom: 30px; 
    } 
} 
 
 
</style>