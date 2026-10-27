<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Votre CSS existant */
        :root { --primary-color: #90EE90; --secondary-color: #2E8B57; }
        body { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        .container-wrapper { width: 900px; height: 450px; position: relative; display: flex; border-radius: 15px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2); overflow: hidden; transition: all 0.8s ease; }
        .welcome-panel { flex: 1; height: 100%; background: rgba(0,0,0,0.6); display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 30px; color: white; text-align: center; transition: flex 0.8s ease; }
        .login-panel { flex: 0; width: 0; height: 100%; background-color: white; color: #333; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 0; overflow: hidden; transition: flex 0.8s ease, width 0.8s ease, padding 0.8s ease; }
        .slide-left .welcome-panel { flex: 0.5; }
        .slide-left .login-panel { flex: 0.5; width: 50%; padding: 30px; }
        .btn-welcome { background: transparent; border: 2px solid white; color: white; border-radius: 50px; padding: 12px 40px; font-weight: 600; transition: all 0.3s; }
        .btn-welcome:hover { background: white; color: #2c3e50; transform: translateY(-3px); }
        .form-control { border-radius: 8px; padding: 12px 15px; border: 1px solid #ddd; transition: all 0.3s; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25); }
        .btn-login { background: linear-gradient(to right, var(--primary-color), var(--secondary-color)); border: none; border-radius: 8px; padding: 12px; font-weight: 600; color: white; width: 100%; }
        .btn-login:hover { transform: translateY(-2px); }
        .password-input-group { position: relative; }
        .password-toggle { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container-wrapper" id="container">
        <div class="welcome-panel">
            <div class="welcome-content">
                <h2>Bienvenue !</h2>
                <p>Accédez à votre espace de gestion comptable</p>
                <button class="btn btn-welcome" id="loginButton">
                    Se connecter <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </div>
        </div>
        
        <div class="login-panel">
            <button class="btn-back" id="backButton">
                <i class="bi bi-arrow-left"></i> Retour
            </button>
            
            <div class="login-header">
                <h4><i class="bi bi-lock-fill me-2"></i> Connexion</h4>
            </div>
            
            <div class="login-body w-100">
                @if($errors->any())
                    <div class="alert alert-danger text-center mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- FORMULAIRE CORRIGÉ -->
                <form method="POST" action="{{ url('/login') }}" id="loginForm">
                    <!-- TOKEN CSRF MANUEL -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom d'utilisateur</label>
                        <input type="text" name="nom" id="nom" class="form-control" 
                               placeholder="Entrez votre nom" value="{{ old('nom') }}" required autofocus>
                    </div>

                    <div class="mb-3 password-input-group">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" name="mot_de_passe" id="mot_de_passe" 
                               class="form-control" placeholder="Entrez votre mot de passe" required>
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginButton').addEventListener('click', function() {
            document.getElementById('container').classList.add('slide-left');
        });
        
        document.getElementById('backButton').addEventListener('click', function() {
            document.getElementById('container').classList.remove('slide-left');
        });
        
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('mot_de_passe');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>