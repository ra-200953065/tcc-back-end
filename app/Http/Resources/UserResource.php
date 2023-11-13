<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'is_admin' => $this->is_admin,
            // 'is_expired_password' => $this->is_expired_password,
            // 'adm' => $this->is_admin ? 'SIM' : 'NÃO',
            'created_at' => date_format($this->created_at, "Y-m-d H:i:s"),
            'updated_at' => date_format($this->updated_at, "Y-m-d H:i:s"),
        ];
    }
}
