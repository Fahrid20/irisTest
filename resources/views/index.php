<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion & Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .link {
            text-align: center;
            margin-top: 10px;
        }
        .link a {
            color: #007BFF;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Page de Connexion -->
    <div class="container" id="login-container">
        <h1>Connexion</h1>
        <form action="/login" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Se connecter</button>

            <div class="link">
                <a href="#" onclick="showForgotPassword()">Mot de passe oublié ?</a>
            </div>
            <div class="link">
                <a href="#" onclick="showSignup()">Créer un compte</a>
            </div>
        </form>
    </div>

    <!-- Page d'Inscription -->
    <div class="container" id="signup-container" style="display: none;">
        <h1>Inscription</h1>
        <form action="/signup" method="POST">
            <label for="fullname">Nom complet</label>
            <input type="text" id="fullname" name="fullname" placeholder="Entrez votre nom complet" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Créez un mot de passe" required>

            <label for="confirm-password">Confirmez le mot de passe</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmez votre mot de passe" required>

            <button type="submit">S'inscrire</button>

            <div class="link">
                <a href="#" onclick="showLogin()">J'ai déjà un compte</a>
            </div>
        </form>
    </div>

    <!-- Script pour basculer entre les pages -->
    <script>
        const loginContainer = document.getElementById('login-container');
        const signupContainer = document.getElementById('signup-container');

        function showSignup() {
            loginContainer.style.display = 'none';
            signupContainer.style.display = 'block';
        }

        function showLogin() {
            signupContainer.style.display = 'none';
            loginContainer.style.display = 'block';
        }

        function showForgotPassword() {
            alert('Lien de récupération du mot de passe envoyé à votre email.');
        }
    </script>
</body>
</html>
