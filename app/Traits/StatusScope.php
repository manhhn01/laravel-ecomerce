<?php

namespace App\Traits;

trait StatusScope
{
    public function scopePublic($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnlisted($query)
    {
        return $query->where('status', 0);
    }

    public function scopeStatus($query, $status)
    {
        if (empty($status)) {
            return $query;
        }
        return $query->where('status', $status);
    }
}
