<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class SalesQueryBuilder extends Builder
{
    public function createdByUser($userId): SalesQueryBuilder
    {
        return $this->where('created_by', '=', $userId);
    }
}
