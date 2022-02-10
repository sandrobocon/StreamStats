<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\TagDescription
 *
 * @property int $id
 * @property int $tag_uuid
 * @property string $localization
 * @property string name
 * @property string descriptions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tag $tag
 * @method static Builder|TagDescription newModelQuery()
 * @method static Builder|TagDescription newQuery()
 * @method static Builder|TagDescription query()
 * @method static Builder|TagDescription whereCreatedAt($value)
 * @method static Builder|TagDescription whereId($value)
 * @method static Builder|TagDescription whereLocalization($value)
 * @method static Builder|TagDescription whereLocalizationDescriptions($value)
 * @method static Builder|TagDescription whereLocalizationName($value)
 * @method static Builder|TagDescription whereTagId($value)
 * @method static Builder|TagDescription whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TagDescription extends Model
{
    protected $fillable = [
        'tag_id',
        'localization',
        'name',
        'description',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
