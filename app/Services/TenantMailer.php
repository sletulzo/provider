<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class TenantMailer
{
    public static function send($tenant, $to, $mailable)
    {
        if (!$tenant->smtp_email || !$tenant->smtp_password) {
            throw new \Exception("SMTP tenant incomplet.");
        }

        config([
            'mail.mailers.tenant' => [
                'transport'  => 'smtp',
                'host'       => 'smtp.hostinger.com',
                'port'       => 587,
                'encryption' => 'tls',
                'username'   => $tenant->smtp_email,
                'password'   => $tenant->smtp_password,
                'timeout'    => null,
                'auth_mode'  => null,
            ],

            'mail.from' => [
                'address' => $tenant->smtp_email,
                'name'    => $tenant->name ?? 'Application',
            ]
        ]);

        \Mail::mailer('tenant')->to($to)->send($mailable);
    }
}