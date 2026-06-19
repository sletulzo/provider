@php
    $appName     = config('app.name');
    $provider    = $order->provider;
    $customer    = $order->user;
    $tenant      = $order->tenant ?? $provider?->tenant;
    $lines       = $order->lines;
    $refCount    = $lines->count();
    $totalQty    = $lines->sum('quantity');
    $reference   = 'CMD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
    $orderDate   = optional($order->created_at)->translatedFormat('d/m/Y à H:i');

    $fmt = fn ($n) => rtrim(rtrim(number_format((float) $n, 2, ',', ' '), '0'), ',');
@endphp
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $subject }}</title>
    <style>
        body { margin: 0; padding: 0; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table { border-collapse: collapse !important; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
        a { text-decoration: none; }
        @media only screen and (max-width: 620px) {
            .container { width: 100% !important; }
            .px { padding-left: 22px !important; padding-right: 22px !important; }
            .meta-cell { display: block !important; width: 100% !important; padding: 0 0 10px 0 !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#eef0f6;">
    <div style="display:none; max-height:0; overflow:hidden; opacity:0;">
        {{ $refCount }} article{{ $refCount > 1 ? 's' : '' }} à valider — merci d'indiquer les produits disponibles.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef0f6;">
        <tr>
            <td align="center" style="padding:28px 14px;">

                <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background-color:#ffffff; border-radius:18px; overflow:hidden; border:1px solid #e7e9f2;">

                    {{-- Bandeau marque --}}
                    <tr>
                        <td class="px" style="background-color:#3645b1; padding:26px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-family:Arial,Helvetica,sans-serif; color:#c7ccf5; font-size:11px; letter-spacing:1.4px; text-transform:uppercase; font-weight:700;">
                                        Nouvelle commande
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:Arial,Helvetica,sans-serif; color:#ffffff; font-size:24px; font-weight:700; padding-top:6px;">
                                        {{ $tenant?->name ?? $appName }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Titre --}}
                    <tr>
                        <td class="px" style="padding:30px 36px 6px 36px;">
                            <p style="margin:0; font-family:Arial,Helvetica,sans-serif; font-size:20px; line-height:1.3; color:#1f2430; font-weight:700;">
                                Vous avez reçu une commande
                            </p>
                            <p style="margin:8px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.6; color:#6b7280;">
                                @if($provider?->name) À l'attention de <strong style="color:#1f2430;">{{ $provider->name }}</strong>. @endif
                                Merci de cliquer sur le bouton ci-dessous pour indiquer les produits disponibles.
                            </p>
                        </td>
                    </tr>

                    {{-- Cartes méta --}}
                    <tr>
                        <td class="px" style="padding:22px 36px 6px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="meta-cell" width="33%" valign="top" style="padding-right:8px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5fb; border:1px solid #e7e9f2; border-radius:12px;">
                                            <tr><td style="padding:12px 14px;">
                                                <div style="font-family:Arial,Helvetica,sans-serif; font-size:10px; letter-spacing:.8px; text-transform:uppercase; color:#6b7280; font-weight:700;">Référence</div>
                                                <div style="font-family:Arial,Helvetica,sans-serif; font-size:15px; color:#1f2430; font-weight:700; padding-top:3px;">{{ $reference }}</div>
                                            </td></tr>
                                        </table>
                                    </td>
                                    <td class="meta-cell" width="34%" valign="top" style="padding:0 4px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5fb; border:1px solid #e7e9f2; border-radius:12px;">
                                            <tr><td style="padding:12px 14px;">
                                                <div style="font-family:Arial,Helvetica,sans-serif; font-size:10px; letter-spacing:.8px; text-transform:uppercase; color:#6b7280; font-weight:700;">Date</div>
                                                <div style="font-family:Arial,Helvetica,sans-serif; font-size:15px; color:#1f2430; font-weight:700; padding-top:3px;">{{ $orderDate ?? '—' }}</div>
                                            </td></tr>
                                        </table>
                                    </td>
                                    <td class="meta-cell" width="33%" valign="top" style="padding-left:8px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5fb; border:1px solid #e7e9f2; border-radius:12px;">
                                            <tr><td style="padding:12px 14px;">
                                                <div style="font-family:Arial,Helvetica,sans-serif; font-size:10px; letter-spacing:.8px; text-transform:uppercase; color:#6b7280; font-weight:700;">Articles</div>
                                                <div style="font-family:Arial,Helvetica,sans-serif; font-size:15px; color:#1f2430; font-weight:700; padding-top:3px;">{{ $refCount }} réf.</div>
                                            </td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    @if(trim($content) !== '')
                    {{-- Message d'introduction --}}
                    <tr>
                        <td class="px" style="padding:18px 36px 0 36px;">
                            <div style="font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:1.65; color:#1f2430;">
                                {!! nl2br(e($content)) !!}
                            </div>
                        </td>
                    </tr>
                    @endif

                    {{-- Tableau produits --}}
                    <tr>
                        <td class="px" style="padding:22px 36px 0 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e7e9f2; border-radius:12px; overflow:hidden;">
                                <tr style="background-color:#3645b1;">
                                    <th align="left" style="font-family:Arial,Helvetica,sans-serif; font-size:11px; letter-spacing:.6px; text-transform:uppercase; color:#ffffff; font-weight:700; padding:12px 16px;">Produit</th>
                                    <th align="center" style="font-family:Arial,Helvetica,sans-serif; font-size:11px; letter-spacing:.6px; text-transform:uppercase; color:#ffffff; font-weight:700; padding:12px 10px; white-space:nowrap;">Qté</th>
                                    <th align="right" style="font-family:Arial,Helvetica,sans-serif; font-size:11px; letter-spacing:.6px; text-transform:uppercase; color:#ffffff; font-weight:700; padding:12px 16px;">Unité</th>
                                </tr>
                                @foreach($lines as $i => $orderLine)
                                @php($rowBg = $i % 2 === 0 ? '#ffffff' : '#f4f5fb')
                                <tr bgcolor="{{ $rowBg }}">
                                    <td style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#1f2430; padding:12px 16px; border-top:1px solid #e7e9f2;">
                                        {{ $orderLine->product?->name ?? 'Produit' }}
                                    </td>
                                    <td align="center" style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#1f2430; font-weight:700; padding:12px 10px; border-top:1px solid #e7e9f2; white-space:nowrap;">
                                        {{ $fmt($orderLine->quantity) }}
                                    </td>
                                    <td align="right" style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#6b7280; padding:12px 16px; border-top:1px solid #e7e9f2;">
                                        {{ $orderLine->unity?->name ?? '—' }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="background-color:#f4f5fb;">
                                    <td style="font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#6b7280; font-weight:700; padding:12px 16px; border-top:2px solid #e7e9f2;">
                                        Total
                                    </td>
                                    <td align="center" style="font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#1f2430; font-weight:700; padding:12px 10px; border-top:2px solid #e7e9f2; white-space:nowrap;">
                                        {{ $fmt($totalQty) }}
                                    </td>
                                    <td align="right" style="font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#6b7280; padding:12px 16px; border-top:2px solid #e7e9f2;">
                                        {{ $refCount }} réf.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- CTA --}}
                    <tr>
                        <td class="px" align="center" style="padding:28px 36px 6px 36px;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="border-radius:12px; background-color:#3645b1;">
                                        <a href="{{ $url }}" target="_blank"
                                           style="display:inline-block; font-family:Arial,Helvetica,sans-serif; font-size:16px; font-weight:700; color:#ffffff; text-decoration:none; padding:15px 34px; border-radius:12px; background-color:#3645b1;">
                                            Valider les produits disponibles
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:12px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#6b7280;">
                                Ce lien vous est réservé, merci de ne pas le transférer.
                            </p>
                        </td>
                    </tr>

                    {{-- Encadré explicatif --}}
                    <tr>
                        <td class="px" style="padding:20px 36px 4px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef1fc; border:1px solid #d9defa; border-radius:12px;">
                                <tr>
                                    <td style="padding:16px 18px; font-family:Arial,Helvetica,sans-serif; font-size:13px; line-height:1.6; color:#2b3792;">
                                        <strong>Comment ça marche&nbsp;?</strong><br>
                                        Ouvrez la page de la commande, indiquez pour chaque produit s'il est <strong>disponible</strong> ou <strong>manquant</strong>, puis validez. {{ $tenant?->name ?? $appName }} sera notifié automatiquement de votre réponse.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    @if(trim($footer) !== '')
                    {{-- Signature --}}
                    <tr>
                        <td class="px" style="padding:22px 36px 0 36px;">
                            <div style="border-top:1px solid #e7e9f2; padding-top:16px; font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.6; color:#6b7280;">
                                {!! nl2br(e($footer)) !!}
                            </div>
                        </td>
                    </tr>
                    @endif

                    {{-- Pied --}}
                    <tr>
                        <td class="px" style="padding:26px 36px 30px 36px;">
                            <div style="border-top:1px solid #e7e9f2; padding-top:18px; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:1.6; color:#9aa0ac; text-align:center;">
                                @if($customer?->name)
                                    Commande passée par {{ $customer->name }}.<br>
                                @endif
                                Généré par <strong style="color:#3645b1;">{{ $appName }}</strong>, le logiciel de commande fournisseur.
                            </div>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>
