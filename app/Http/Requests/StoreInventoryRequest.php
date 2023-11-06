<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            // Inventory
            'status' => 'required',
            'type' => 'required',
            'reference' => 'required',
            'lease_end_at' => '',
            'lease_begins_at' => '',
            'date_wanted' => '',

            // Tenant
            // 'tenant_last_name' => '',
            // 'tenant_name' => '',
            // 'tenant_type' => '',
            // 'tenant_gender' => '',
            // 'tenant_email' => '',
            // 'tenant_phone' => '',
            // 'tenant_notes' => '',
        ];
    }
}
