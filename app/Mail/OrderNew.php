<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inventory;

use Carbon;

class OrderNew extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Inventory Instance
     *
     * @var \App\Models\Inventory
     */

    protected $inventory;
    protected $type;
    // protected $dateWanted;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inventory $inventory, $date_wanted)
    {
        $this->inventory = $inventory->getDetails($inventory);

        $inventoryArray = $inventory->getDetails($inventory);

        /* Format Dates */
        $input  = $date_wanted;
        $format = 'd/m/Y';
        $date = Carbon\Carbon::parse($input)->format($format);
        $this->dateWanted = $date;

        /* Format Type */
        if ($this->inventory['type'] == 1) {
            $this->type = 'EDL Entrée';
        } else {
            $this->type = 'EDL Sortie';
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orderNew')->with([
            'keyNotes' => $this->inventory['key_notes'],
            'dateWanted' => $this->dateWanted,
            'tenantNotes' => $this->inventory['tenant']['notes'],
            'type' => $this->type
        ])->subject('[Commande] ' . $this->inventory['reference'] . ' - ' . $this->type);
    }
}
