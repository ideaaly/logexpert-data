<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inventory;
use App\Models\Cancellation;
use App\Models\User;

use Carbon;

class InventoryCancelled extends Mailable
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
    protected $tenantName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inventory $inventory, Cancellation $cancellation, User $user)
    {
        $this->inventory = $inventory->getDetails($inventory);
        $this->cancellation = $cancellation;

        $inventoryArray = $inventory->getDetails($inventory);

        /* Raison */
        $this->reason = $this->cancellation->reason;

        /* Format Type */
        if ($this->inventory['type'] == 1) {
            $this->type = 'État des lieux d\'Entrée';
        } else {
            $this->type = 'État des lieux de Sortie';
        }

        /* User Name */
        $this->inventoryUserRefName = $user->name;

        /* Tenant Name */
        $this->tenantName = $this->inventory['tenant']['last_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.inventoryCancelled')->with([
            'type' => $this->type,
            'inventoryRef' => $this->inventory['reference'],
            'inventoryUserRefName' => $this->inventoryUserRefName,
            'tenantName' => $this->tenantName,
            'reason' => $this->reason

        ])->subject('[Annulation EDL] ' . $this->inventory['reference'] . ' - ' . $this->type);
    }
}
