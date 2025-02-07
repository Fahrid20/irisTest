<footer>
    <div class="footer-container">
        <div class="footer-section about">
            <h3>About</h3>
            <p>These partnerships strengthen Vivatrix's position as a premier destination for online shopping.</p>
        </div>

        <div class="footer-section partnership">
            <h3>Partnership</h3>
            <p>Offer a diverse selection of high-quality products, ranging from sports gear to trendy clothing and unique sheepskin accessories.</p>
        </div>

        <div class="footer-section contact">
            <h3>Contact Us</h3>
            <p><i class='bx bxs-phone-call'></i> Phone</p>
            <p><i class='bx bxs-envelope'></i> <a href="mailto:Email@gmail.com" class="mail">Email@gmail.com</a></p>
        </div>

        <div class="footer-section social">
            <h3>Social Medias</h3>
            <a href="#" class="social-link"><i class='bx bxl-twitter'></i> Twitter</a>
            <a href="#" class="social-link"><i class='bx bxl-facebook-circle'></i> Facebook</a>
            <a href="#" class="social-link"><i class='bx bxl-tiktok'></i> TikTok</a>
            <a href="#" class="social-link"><i class='bx bxl-instagram-alt'></i> Instagram</a>
        </div>
    </div>
</footer>

<style>
/* 🔹 Style du Footer */
footer {
    background-color: #1e293b;
    color: #94a3b8;
    text-align: center;
    padding: 40px 20px;
    font-family: 'Roboto', sans-serif;
}

/* 🔹 Conteneur du footer */
.footer-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive Grid */
    gap: 20px;
    max-width: 1200px;
    margin: auto;
}

/* 🔹 Sections du footer */
.footer-section {
    text-align: left;
    padding: 15px;
}

.footer-section h3 {
    color: #38bdf8;
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.footer-section p,
.footer-section a {
    font-size: 1rem;
    line-height: 1.6;
    color: #94a3b8;
    text-decoration: none;
    display: block;
    transition: color 0.3s;
}

.footer-section a:hover {
    color: #38bdf8;
}

/* 🔹 Icônes */
.footer-section i {
    margin-right: 8px;
    font-size: 1.3rem;
    color: #38bdf8;
}

/* 🔹 Responsivité */
@media (max-width: 768px) {
    .footer-container {
        grid-template-columns: 1fr; /* Une seule colonne sur petits écrans */
        text-align: center;
    }

    .footer-section {
        padding: 10px;
    }

    .footer-section h3 {
        font-size: 1.1rem;
    }

    .footer-section p,
    .footer-section a {
        font-size: 0.9rem;
    }
}
</style>
