<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property User $user
 * @property string $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $province
 * @property string|null $zip
 * @property string|null $country
 * @property bool $is_main
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class UserAddress extends Model
{
    protected $table = 'user_addresses';

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class,
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
