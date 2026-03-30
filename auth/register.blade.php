<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscription - StockPro</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
* {
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* BODY */
body {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f4f7fe, #eef2f7);
    margin: 0;
    overflow: hidden;
}

/* CARD */
.register-card {
    width: 100%;
    max-width: 520px; /* 👈 كبرنا العرض */
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    overflow: hidden;
    animation: fadeIn 0.6s ease;
}

/* HEADER */
.card-header {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 25px;
    text-align: center;
}

.logo {
    font-size: 2rem;
    font-weight: bold;
}

/* BODY */
.card-body {
    padding: 25px;
}

/* TITLE */
.form-title {
    text-align: center;
    font-weight: 600;
    margin-bottom: 20px;
}

/* INPUTS */
.form-floating {
    margin-bottom: 12px;
}

.form-control, .form-select {
    border-radius: 10px;
}

/* BUTTON */
.btn-register {
    width: 100%;
    border-radius: 20px;
    padding: 10px;
    background: #3b82f6;
    color: white;
    border: none;
    font-weight: 600;
}

.btn-register:hover {
    background: #1d4ed8;
}

/* LINK */
.link-section {
    text-align: center;
    margin-top: 10px;
}

/* ANIMATION */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

/* 📱 MOBILE */
@media (max-height: 700px) {
    body {
        overflow: auto; /* 👈 يرجع scroll غير فاش الشاشة صغيرة بزاف */
    }
}
</style>
</head>

<body>

<div class="register-card">

    <div class="card-header">
        <h2 class="logo">StockPro</h2>
    </div>

    <div class="card-body">
        <h4 class="form-title">Créer un compte</h4>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-floating">
                <input type="text" class="form-control" name="name" placeholder="Nom complet" required>
                <label>Nom complet</label>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
                <label>Email</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                <label>Mot de passe</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmer" required>
                <label>Confirmer</label>
            </div>

            <div class="form-floating">
                <select class="form-select" name="role" required>
                    <option value="">Choisir rôle</option>
                    <option value="admin">Admin</option>
                    <option value="gestionnaire">Gestionnaire</option>
                    <option value="agent">Agent</option>
                </select>
                <label>Rôle</label>
            </div>

            <button type="submit" class="btn btn-register">
                <i class="bi bi-check-lg"></i> S'inscrire
            </button>

            <div class="link-section">
                Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </form>
    </div>

</div>

</body>
</html>