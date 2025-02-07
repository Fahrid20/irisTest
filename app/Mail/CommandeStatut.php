<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Commande;

class CommandeStatut extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function build()
    {
        return $this->subject('Mise à jour de votre commande')
                    ->view('commande_status')
                    ->with([
                        'commandeId' => $this->commande->id,
                        'statut' => ucfirst($this->commande->statut),
                    ]);
    }
}
