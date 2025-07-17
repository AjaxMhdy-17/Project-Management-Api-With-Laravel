<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        $data['status'] = $this->is_done ? 'Completed' : 'Pending';
        $data['created_at'] = Carbon::parse($this->created_at)->format('d/m/Y');
        return $data ; 
    }
}
