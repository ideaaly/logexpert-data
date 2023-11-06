<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inventory;

use Carbon;

class OrderNewEntryTenant extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Inventory Instance
     *
     * @var \App\Models\Inventory
     */

    protected $inventory;
    protected $type;
    protected $dateWanted;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory->getDetails($inventory);

        $inventoryArray = $inventory->getDetails($inventory);

        /* Format Dates */
        $input  = Inventory::find($inventoryArray['id'])->date_wanted;
        $format = 'd/m/Y';
        $date = Carbon\Carbon::parse($input)->format($format);
        $this->dateWanted = $date;

        /* Format Type */
        if ($this->inventory['type'] == 1) {
            $this->type = 'État des lieux d\'Entrée';
        } else {
            $this->type = 'État des lieux de Sortie';
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orderNewEntryTenant')->with([
            'address1' => $this->inventory['property']['address1'],
            'address2' => $this->inventory['property']['address2'],
            'zip_code' => $this->inventory['property']['zip_code'],
            'city' => $this->inventory['property']['city'],
            'dateWanted' => $this->dateWanted,
            'type' => $this->type
        ])->subject('Informations sur votre état des lieux d\'entrée');
    }
}
