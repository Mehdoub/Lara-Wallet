<?php

namespace App\Http\Resources;

use App\Enums\Payment\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'unique_id' => $this->unique_id,
            'status' => $this->status ?: PaymentStatus::PENDING,
            'amount' => $this->amount,
            'currency' => new CurrencyResource($this->currency),
            'user' => new UserResource($this->user)
        ];
    }
}
