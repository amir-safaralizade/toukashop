<?php

namespace Modules\Visit\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Visit\Entities\Visit;

trait Visitable
{
    public function visits(): MorphMany
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    public function visitCount(): int
    {
        return $this->visits()->count();
    }

    public function uniqueVisitCount(): int
    {
        return $this->visits()->distinct('ip_address')->count('ip_address');
    }
}
