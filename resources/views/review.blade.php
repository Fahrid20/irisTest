@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Donnez votre avis sur</h1>

    <form action="{{ route('review.store', ['commande_id' => $commande->id]) }}" method="POST">
        @csrf

        <!-- Système de notation -->
        <div class="form-group mb-4">
            <label for="rating">Notez ce produit :</label>
            <div id="star-rating" class="d-flex justify-content-center">
                <input type="radio" name="rating" id="rating-5" value="5">
                <label for="rating-5" class="star-label" data-value="5">&#9733;</label>

                <input type="radio" name="rating" id="rating-4" value="4">
                <label for="rating-4" class="star-label" data-value="4">&#9733;</label>

                <input type="radio" name="rating" id="rating-3" value="3">
                <label for="rating-3" class="star-label" data-value="3">&#9733;</label>

                <input type="radio" name="rating" id="rating-2" value="2">
                <label for="rating-2" class="star-label" data-value="2">&#9733;</label>

                <input type="radio" name="rating" id="rating-1" value="1">
                <label for="rating-1" class="star-label" data-value="1">&#9733;</label>
            </div>
            @error('rating')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Zone de commentaire -->
        <div class="form-group mb-4">
            <label for="comment">Laissez un commentaire :</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Écrivez votre avis..."></textarea>
            @error('comment')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">Soumettre l'avis</button>
    </form>
</div>
@endsection

<style>
    #star-rating {
        display: flex;
        justify-content: center;
        flex-direction: row-reverse; /* Les étoiles les plus hautes sont à gauche */
    }

    .star-label {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s ease-in-out;
        padding: 5px;
    }

    input[type="radio"] {
        display: none; /* On cache les boutons radio */
    }

    /* Effet de survol : les étoiles précédentes deviennent dorées */
    .star-label:hover,
    .star-label:hover ~ .star-label {
        color: gold;
    }

    /* Effet de sélection : les étoiles sélectionnées restent dorées */
    input[type="radio"]:checked ~ .star-label {
        color: gold;
    }

</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll(".star-label");
        const radios = document.querySelectorAll("input[name='rating']");

        stars.forEach(star => {
            star.addEventListener("click", function() {
                let ratingValue = this.getAttribute("data-value");
                radios.forEach(radio => {
                    if (radio.value === ratingValue) {
                        radio.checked = true;
                    }
                });

                // Mettre à jour la couleur des étoiles
                updateStars(ratingValue);
            });

            star.addEventListener("mouseover", function() {
                updateStars(this.getAttribute("data-value"));
            });

            star.addEventListener("mouseout", function() {
                const selectedRating = document.querySelector("input[name='rating']:checked");
                updateStars(selectedRating ? selectedRating.value : 0);
            });
        });

        function updateStars(rating) {
            stars.forEach(star => {
                star.style.color = star.getAttribute("data-value") <= rating ? "gold" : "#ccc";
            });
        }
    });

</script>