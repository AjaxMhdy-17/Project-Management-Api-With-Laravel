<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{

    public $collects = ProjectResources::class;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
