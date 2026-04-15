<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BazaarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'item_id'       => $this->item->id,
            'item_name'     => $this->item->Name,
            'item_icon'     => $this->item->icon,
            'item_type'     => config('everquest.item_types.' . $this->item->itemtype) ?? 'Unknown',
            'qty'           => $this->item_charges == -1 ? 1 : $this->item_charges,
            'price'         => $this->item_cost / 1000,
            'trader'        => $this->character->name,
        ];
    }
}
