<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\Stream;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use romanzipp\Twitch\Twitch;
use Throwable;

class ImportTwitchTopLiveStreamsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WithFaker;

    private int $quantity;
    private bool $shuffle;

    public function __construct(int $quantity = 1000, bool $shuffle = true)
    {
        $this->quantity = $quantity;
        $this->shuffle  = $shuffle;
        $this->setUpFaker();
    }

    /**
     * @throws Throwable
     */
    public function handle()
    {
        DB::transaction(function () {
            $twitch = new Twitch();

            $trys = 0;
            do {
                $result = $twitch->getStreams([
                    'first' => 100,
                ], isset($result) ? $result->next() : null);

                foreach ($result->data() as $stream) {
                    if ($stream->game_id) {
                        Game::updateOrCreate([
                            'id'   => $stream->game_id,
                            'name' => $stream->game_name,
                        ]);
                    }

                    $tags = [];
                    if ($stream->tag_ids) {
                        foreach ($stream->tag_ids as $tagId) {
                            $tag = Tag::firstOrCreate([
                                'tag_id' => $tagId,
                            ]);
                            $tags[] = $tag->id;
                        }
                    }

                    $this->updateOrCreateShuffledStream($stream, $tags);
                }

                if (!$result->hasMoreResults()) {
                    break;
                }
            } while (Stream::query()->count() < $this->quantity && $trys++ < 15);
        });
    }

    private function updateOrCreateShuffledStream(object $stream, array $tags): Stream
    {
        Stream::query()->updateOrCreate([
            'id' => $stream->id,
        ], [
            'game_id'       => $stream->game_id ?: null,
            'user_id'       => $this->shuffle ? $this->faker()->randomNumber(8) : $stream->user_id,
            'user_login'    => $this->shuffle ? $this->faker()->slug(2) : $stream->user_login,
            'user_name'     => $this->shuffle ? $this->faker()->slug(2) : $stream->user_name,
            'game_name'     => $stream->game_name,
            'title'         => $this->shuffle ? $this->faker()->words(3, true) : $stream->title,
            'viewer_count'  => $stream->viewer_count,
            'started_at'    => Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $stream->started_at),
            'language'      => $stream->language,
            'thumbnail_url' => $this->shuffle
                ? Str::replace($stream->user_login, Str::random(6), $stream->thumbnail_url)
                : $stream->thumbnail_url,
        ]);

        $stream = Stream::find($stream->id);
        $stream->tags()->sync($tags);

        return $stream;
    }
}
