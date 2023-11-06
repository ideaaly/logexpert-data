<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inventory;
use App\Models\User;

use Carbon;

class ExpertAssigned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Inventory Instance
     *
     * @var \App\Models\Inventory
     */

    protected $inventory;
    protected $cancellation;
    protected $inventoryRef;
    protected $inventoryType;
    protected $inventoryUserRefName;
    protected $reason;
    protected $dateWanted;
    protected $permalink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inventory $inventory, User $user)
    {
        $this->inventory = $inventory->getDetails($inventory);

        $inventoryArray = $inventory->getDetails($inventory);

        /* Format Type */
        if ($this->inventory['type'] == 1) {
            $this->type = 'État des lieux d\'Entrée';
        } else {
            $this->type = 'État des lieux de Sortie';
        }

        /* Format Dates */
        $input  = $inventoryArray['date_wanted'];
        $format = 'd/m/Y';
        $date = Carbon\Carbon::parse($input)->format($format);
        $this->dateWanted = $date;

        $this->permalink = route("create.inventappt", $this->inventory['id']);
        /* User Name */
        $this->inventoryUserRefName = $user->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.expertAssigned')->with([
            'type' => $this->type,
            'inventoryRef' => $this->inventory['reference'],
            'keyNotes' => $this->inventory['key_notes'],
            'tenantNotes' => $this->inventory['tenant']['notes'],
            'tenantName' => $this->inventory['tenant']['last_name'],
            'dateWanted' => $this->dateWanted,
            'permalink' => $this->permalink,
            'inventoryUserRefName' => $this->inventoryUserRefName,
        ])->subject('[Commande EDL] ' . $this->type . ' - ' . $this->inventory['reference'] . ' - LOC :' . $this->inventory['tenant']['last_name']);
    }
}
