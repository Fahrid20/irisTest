require('./bootstrap');



    document.addEventListener('DOMContentLoaded', function () {




        // Suppression d'un produit
    document.querySelectorAll('.delete-product').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');

            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')) {
                fetch(`/admin/produits/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la suppression');
                    }
                    return response.json();
                }).then(data => {
                    alert('✅ Produit supprimé avec succès');
                    location.reload();
                }).catch(error => {
                    console.error('❌ Erreur:', error);
                    alert('❌ Impossible de supprimer le produit');
                });
            }
        });
    });

        // Ajout d’un Admin
            document.getElementById('addAdminForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch('{{ route("admin.addAdmin") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de l’ajout');
                }
                return response.json();
            })
            .then(data => {
                alert('✅ Admin ajouté avec succès');
                location.reload(); // Recharge la page pour voir la mise à jour
            })
            .catch(error => {
                console.error('❌ Erreur:', error);
                alert('❌ Impossible d’ajouter l’admin');
            });
        });
    });
   



    document.addEventListener('DOMContentLoaded', function () {
    
        // ✅ Mise à jour des informations produit (Nom, Prix, Stock, Caractéristiques, Marque, Couleur)
    document.querySelectorAll('.update-product').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');
            let name = document.querySelector(`.product-name[data-id='${id}']`).value;
            let price = document.querySelector(`.product-price[data-id='${id}']`).value;
            let stock = document.querySelector(`.product-stock[data-id='${id}']`).value;

            let caracteristiques = [];
            document.querySelectorAll(`.caracteristique[data-id]`).forEach(input => {
                let caracId = input.getAttribute('data-id');
                let marque = document.querySelector(`.caracteristique-marque[data-id='${caracId}']`).value;
                let couleur = document.querySelector(`.caracteristique-couleur[data-id='${caracId}']`).value;

                caracteristiques.push({
                    id: caracId,
                    description: input.value,
                    marque: marque,
                    couleur: couleur
                });
            });

            fetch(`/admin/produits/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    nom: name, 
                    prix: price, 
                    stock: stock,
                    caracteristiques: caracteristiques 
                })
            }).then(response => response.json())
              .then(data => {
                  alert('✅ Produit mis à jour avec succès !');
                  location.reload();
              }).catch(error => {
                  console.error('❌ Erreur:', error);
                  alert('❌ Erreur lors de la mise à jour');
              });
        });
    });




    // 🗑️ Suppression d'un produit
    document.querySelectorAll('.delete-product').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');

            fetch(`/admin/produits/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
              .then(data => {
                  alert('Produit supprimé');
                  location.reload();
              }).catch(error => console.error(error));
        });
    });

});



    //changer statut bcommande
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('change', async function (event) {
        if (event.target.classList.contains('update-status')) {
            let id = event.target.getAttribute('data-id');
            let statut = event.target.value.trim();
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            console.log("✅ Changement détecté !");
            console.log("🆔 Commande ID :", id);
            console.log("📌 Statut sélectionné :", `"${statut}"`);

            if (!id || !statut) {
                console.error("❌ Erreur : ID ou statut invalide !");
                showError("❌ ID ou statut invalide !");
                return;
            }

            try {
                let response = await fetch(`/admin/commandes/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ statut: statut })
                });

                console.log("🔄 Statut HTTP :", response.status); // 🔥 Log du code HTTP

                if (!response.ok) {
                    let errorText = await response.text();
                    throw new Error(`Erreur HTTP ${response.status} : ${errorText}`);
                }

                let data = await response.json();
                console.log("🟢 Réponse serveur :", data);

                if (data.error) {
                    throw new Error(data.error);
                }

                alert('✅ Statut mis à jour avec succès !');
            } catch (error) {
                console.error('❌ Erreur AJAX détaillée :', error);

                // Afficher l'erreur dans l'élément HTML pour la copier
                showError(`❌ Erreur AJAX détaillée :\n${error.message}\n\nStack trace :\n${error.stack}`);
            }
        }
    });
});




document.addEventListener('DOMContentLoaded', function () {
    // Gérer l'affichage des blocs
    document.getElementById('addProductBtn').addEventListener('click', function () {
        document.getElementById('productManagement').style.display = 'none';
        document.getElementById('productAddForm').style.display = 'block';
    });

    document.getElementById('cancelAddProduct').addEventListener('click', function () {
        document.getElementById('productAddForm').style.display = 'none';
        document.getElementById('productManagement').style.display = 'block';
    });

    // Gérer l'ajout de produit via JSON et image
    document.getElementById('addProductForm').addEventListener('submit', function (e) {
        e.preventDefault();  // Empêcher l'envoi du formulaire de manière classique

        // Récupérer les données du formulaire
        let name = document.getElementById('productName').value;
        let price = document.getElementById('productPrice').value;
        let stock = document.getElementById('productStock').value;
        let imageFile = document.getElementById('productImage').files[0];  // Image du produit
        let category = document.getElementById('productCategory').value;
        console.log(category)
        // Gérer les caractéristiques
        let caracteristics = [];
        document.querySelectorAll('.caracteristic-item').forEach(item => {
            let description = item.querySelector('input[name="caracteristics[][description]"]').value;
            let couleur = item.querySelector('input[name="caracteristics[][couleur]"]').value;
            let marque = item.querySelector('input[name="caracteristics[][marque]"]').value;
            let waterproof = item.querySelector('select[name="caracteristics[][waterproof]"]').value;

            caracteristics.push({
                description: description,
                couleur: couleur,
                marque: marque,
                waterproof: waterproof
            });
        });

        // Créer un objet FormData pour envoyer l'image vers le serveur
        let formData = new FormData();
        formData.append('image', imageFile);

        // Créer l'objet de données JSON pour les autres informations
        let productData = {
            nom: name,
            prix: price,
            stock: stock,
            categorie_id: category,
            caracteristics: caracteristics
        };

        // Ajouter les données JSON dans FormData
        formData.append('data', JSON.stringify(productData));

        // Envoi de l'image et des autres données
        fetch('/admin/produits', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData  // On envoie FormData, car il contient l'image et les autres données
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Produit ajouté avec succès !');
                location.reload();  // Recharger la page pour afficher le nouveau produit
            } else {
                // Vérifier si l'erreur est un objet
                if (data.error && typeof data.error === 'object') {
                    let errorMessage = '';
                    for (const [key, value] of Object.entries(data.error)) {
                        errorMessage += `${key}: ${value.join(', ')}\n`;
                    }
                    alert('❌ Erreur lors de l\'ajout du produit : \n' + errorMessage);
                } else {
                    alert('❌ Erreur lors de l\'ajout du produit : ' + data.error);
                }
            }
        })
        .catch(error => {
            console.error('❌ Erreur:', error);
            alert('❌ Impossible d’ajouter le produit. Veuillez vérifier la console pour plus d\'informations.');
        });
    });
});





document.addEventListener("DOMContentLoaded", function () {
    const detailsModal = document.getElementById("commande-details");
    const detailsContent = document.getElementById("commande-content");
    const closeDetails = document.querySelector(".close-details");

    // ✅ Événement pour afficher les détails de la commande
    document.querySelectorAll(".btn-details").forEach(button => {
        button.addEventListener("click", function () {
            detailsModal.classList.add("d-block"); // ✅ Masquer correctement
            const commandeId = this.getAttribute("data-id");

            // 🔹 Requête AJAX pour récupérer les détails
            fetch(`/commande/details/${commandeId}`)
                .then(response => response.json())
                .then(data => {
                    // Vérifie si la réponse est correcte
                    if (!data || !data.details) {
                        detailsContent.innerHTML = "<p class='text-danger'>Erreur : Détails non disponibles.</p>";
                        return;
                    }

                    // 🔹 Générer le contenu des détails
                    let html = `<p><strong>Nom :</strong> ${data.nom}</p>`;
                    html += `<p><strong>Email :</strong> ${data.email}</p>`;
                    html += `<p><strong>Adresse :</strong> ${data.adresse}, ${data.ville}, ${data.code_postal}</p>`;
                    html += `<p><strong>Mode de paiement :</strong> ${data.mode_paiement}</p>`;
                    html += `<h5>Produits commandés :</h5>`;
                    html += `<ul class="list-group">`;
                    data.details.forEach(detail => {
                        html += `<li class="list-group-item d-flex justify-content-between">
                                    <span>${detail.produit.nom} x${detail.quantite}</span>
                                    <strong>${detail.prix_unitaire * detail.quantite} €</strong>
                                 </li>`;
                    });
                    html += `</ul>`;

                    // 🔹 Ajouter le contenu et afficher le bloc
                    detailsContent.innerHTML = html;
                    detailsModal.classList.remove("d-none"); // ✅ Afficher correctement
                })
                .catch(error => {
                    console.error("Erreur lors de la récupération des détails :", error);
                    detailsContent.innerHTML = "<p class='text-danger'>Une erreur est survenue.</p>";
                });
        });
    });

    // ✅ Événement pour fermer les détails
    closeDetails.addEventListener("click", function () {
        detailsModal.classList.add("d-none"); // ✅ Masquer correctement
    });
});

