<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Stream
 *
 * @property int $id
 * @property int $game_id
 * @property int $user_id
 * @property string $user_login
 * @property string $user_name
 * @property string $game_name
 * @property string $title
 * @property int $viewer_count
 * @property string $started_at
 * @property string $language
 * @property string $thumbnail_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Game $game
 * @property-read Collection|Tag[] $tags
 * @property-read int|null $tags_count
 * @method static Builder|Stream newModelQuery()
 * @method static Builder|Stream newQuery()
 * @method static Builder|Stream query()
 * @method static Builder|Stream whereCreatedAt($value)
 * @method static Builder|Stream whereGameId($value)
 * @method static Builder|Stream whereGameName($value)
 * @method static Builder|Stream whereId($value)
 * @method static Builder|Stream whereLanguage($value)
 * @method static Builder|Stream whereStartedAt($value)
 * @method static Builder|Stream whereThumbnailUrl($value)
 * @method static Builder|Stream whereTitle($value)
 * @method static Builder|Stream whereUpdatedAt($value)
 * @method static Builder|Stream whereUserId($value)
 * @method static Builder|Stream whereUserLogin($value)
 * @method static Builder|Stream whereUserName($value)
 * @method static Builder|Stream whereViewerCount($value)
 * @mixin Eloquent
 * @property mixed $0
 */
class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'user_login',
        'user_name',
        'game_id',
        'game_name',
        'title',
        'viewer_count',
        'started_at',
        'language',
        'thumbnail_url',
    ];

    protected $casts = [
        'started_at',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->with(TagDescription::class);
    }
}
