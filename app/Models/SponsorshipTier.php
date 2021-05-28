<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         $id
 * @property string      $node_id
 * @property bool        $one_time
 * @property int         $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|SponsorshipTier query()
 */
class SponsorshipTier extends Model
{
    protected $fillable = [
        'node_id',
        'one_time',
        'price',
    ];

    protected $casts = [
        'one_time' => 'boolean',
        'price' => 'int',
    ];
}
