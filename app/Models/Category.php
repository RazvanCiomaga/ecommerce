<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
