<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
    <table width="600" align="center" cellpadding="10" cellspacing="0" style="background: white; border-radius: 8px;">
        <tr>
            <td align="center"><h2 style="color:#2563eb;">👋 Bonjour {{ $data['name'] }}</h2></td>
        </tr>
        <tr>
            <td>
            <p>Ceci est un test d’envoi d’email depuis <b>Laravel</b>.</p>
            <p><b>Sujet :</b> {{ $data['subject'] }}</p>
            </td>
        </tr>
        <tr>
            <td align="center"><small style="color:#aaa;">© {{ date('Y') }} Mon Site Laravel</small></td>
        </tr>
    </table>
</body>
</html>