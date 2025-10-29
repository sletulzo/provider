<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
    <h2>{{ $subject ?? 'Email fournisseur' }}</h2>
    {!! $content ?? '<p>Contenu vide</p>' !!}
</body>
</html>