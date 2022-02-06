<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $tag_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|TagDescription[] $descriptions
 * @property-read int|null $descriptions_count
 * @property-read Collection|Stream[] $streams
 * @property-read int|null $streams_count
 * @method static Builder|Tag newModelQuery()
 * @method static Builder|Tag newQuery()
 * @method static Builder|Tag query()
 * @method static Builder|Tag whereCreatedAt($value)
 * @method static Builder|Tag whereId($value)
 * @method static Builder|Tag whereTagId($value)
 * @method static Builder|Tag whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_id',
    ];

    public function streams(): BelongsToMany
    {
        return $this->belongsToMany(Stream::class);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(TagDescription::class);
    }
}
