<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte restaurant PeleFood</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome-section h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .welcome-section p {
            color: #6b7280;
            font-size: 16px;
        }
        .credentials-box {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credentials-box h3 {
            color: #374151;
            margin-top: 0;
            font-size: 18px;
        }
        .credential-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #d1d5db;
        }
        .credential-item:last-child {
            border-bottom: none;
        }
        .credential-label {
            font-weight: 600;
            color: #374151;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            background: #1f2937;
            color: #10b981;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
        }
        .restaurant-info {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .restaurant-info h3 {
            color: #92400e;
            margin-top: 0;
        }
        .restaurant-info p {
            margin: 5px 0;
            color: #92400e;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .security-notice {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .security-notice h4 {
            color: #dc2626;
            margin-top: 0;
            font-size: 16px;
        }
        .security-notice p {
            color: #991b1b;
            margin: 5px 0;
            font-size: 14px;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #8b5cf6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍽️ PeleFood</h1>
            <p>Plateforme de commande de nourriture en ligne</p>
        </div>

        <div class="content">
            <div class="welcome-section">
                <h2>Bienvenue {{ $user->name }} !</h2>
                <p>Votre compte restaurant a été créé avec succès sur PeleFood.</p>
            </div>

            <div class="restaurant-info">
                <h3>🏪 Informations de votre restaurant</h3>
                <p><strong>Nom :</strong> {{ $restaurant->name }}</p>
                <p><strong>Email :</strong> {{ $restaurant->email }}</p>
                <p><strong>Téléphone :</strong> {{ $restaurant->phone }}</p>
                <p><strong>Adresse :</strong> {{ $restaurant->address }}, {{ $restaurant->city }}</p>
                @if($restaurant->description)
                    <p><strong>Description :</strong> {{ $restaurant->description }}</p>
                @endif
            </div>

            <div class="credentials-box">
                <h3>🔐 Vos identifiants de connexion</h3>
                <div class="credential-item">
                    <span class="credential-label">Email :</span>
                    <span class="credential-value">{{ $user->email }}</span>
                </div>
                <div class="credential-item">
                    <span class="credential-label">Mot de passe temporaire :</span>
                    <span class="credential-value">{{ $temporaryPassword }}</span>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="cta-button">
                    🚀 Se connecter maintenant
                </a>
            </div>

            <div class="security-notice">
                <h4>⚠️ Important - Sécurité</h4>
                <p>• Ce mot de passe est temporaire et doit être changé lors de votre première connexion</p>
                <p>• Ne partagez jamais vos identifiants avec d'autres personnes</p>
                <p>• Si vous n'avez pas demandé ce compte, contactez immédiatement le support</p>
            </div>

            <div style="margin-top: 30px; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <h3 style="color: #374151; margin-top: 0;">🎯 Prochaines étapes</h3>
                <ol style="color: #6b7280; line-height: 1.8;">
                    <li>Connectez-vous avec vos identifiants ci-dessus</li>
                    <li>Changez votre mot de passe temporaire</li>
                    <li>Configurez votre menu et vos produits</li>
                    <li>Paramétrez vos horaires d'ouverture</li>
                    <li>Configurez vos options de livraison</li>
                    <li>Commencez à recevoir des commandes !</li>
                </ol>
            </div>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement par PeleFood</p>
            <p>Si vous avez des questions, contactez-nous à <a href="mailto:support@pelefood.com">support@pelefood.com</a></p>
            <p>&copy; {{ date('Y') }} PeleFood. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
