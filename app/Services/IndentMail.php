<?php

namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Facades\Mail;

class IndentMail
{
    /**
     * Create html mail
     * @return string
     */
    public function createIndentMail(Provider $provider, $content, $footer)
    {
        $table = '<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 20px;">'
            . '<tr style="background-color: #007BFF; color: #ffffff;">'
                . '<th style="padding: 10px; border: 1px solid #dddddd; text-align: left;">Produit</th>'
                . '<th style="padding: 10px; border: 1px solid #dddddd; text-align: center;">Quantité</th>'
                . '<th style="padding: 10px; border: 1px solid #dddddd; text-align: right;">Unité</th>'
            . '</tr>';

        foreach($provider->orderWaitings as $orderWaiting)
        {
            $table .= '<tr style="background-color: #f8f9fa;">'
                    . '<td style="padding: 10px; border: 1px solid #dddddd;">' . $orderWaiting->product?->name . '</td>'
                    . '<td style="padding: 10px; border: 1px solid #dddddd; text-align: center;">' . $orderWaiting->quantity . '</td>'
                    . '<td style="padding: 10px; border: 1px solid #dddddd; text-align: right;">' . $orderWaiting->unity?->name . '</td>'
                . '</tr>';
        }

        $table .= '</table>';

        return $content . "<br>" . $table . "<br>" . $footer;
    }
}