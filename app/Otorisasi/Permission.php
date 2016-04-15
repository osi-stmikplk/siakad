<?php

namespace Stmik\Otorisasi;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * Berikan role yang menjadi bagian dari permission ini!
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
