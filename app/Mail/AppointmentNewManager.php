<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inventory;
use App\Models\Appointment;
use App\Models\User;

use Carbon;

class AppointmentNewManager extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Inventory Instance
     *
     * @var \App\Models\Inventory
     */

    protected $inventory;
    protected $type;
    protected $appointmentDate;
    protected $user_referent_id;
    protected $userReferentName;
    protected $userReferentTel;
    protected $tenantName;

    public function __construct(Inventory $inventory, $appointment_id, $user_referent_id)
    {
        /* Inventory */
        $this->inventory = $inventory->getDetails($inventory);

        Carbon\Carbon::setLocale('fr');
        /* Format Dates */
        $input  = Appointment::find($appointment_id)->date;
        $format = 'd/m/Y H:i';
        $date = Carbon\Carbon::parse($input)->format($format);
        $this->appointmentDate = $date;

        /* Format Type */
        if ($this->inventory['type'] == 1) {
            $this->type = 'État des lieux d’entrée';
        } else {
            $this->type = 'État des lieux de sortie';
        }

        /* User referent */
        $this->userReferentName = User::find($user_referent_id)->name;
        $this->userReferentTel = User::find($user_referent_id)->phone_number;

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
        return $this->view('emails.appointmentNewManager')->with([
            'tenantName' => $this->tenantName,
            'inventoryRef' => $this->inventory['reference'],
            'userReferentName' => $this->userReferentName,
            'userReferentTel' => $this->userReferentTel,
            'appointmentDate' => $this->appointmentDate,
            'type' => $this->type
        ])->subject('[RDV Fixé] ' . $this->type . ' - ' . $this->inventory['reference'] . ' - ' . $this->tenantName);
    }
}
