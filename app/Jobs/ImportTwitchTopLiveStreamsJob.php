<?php

namespace App\Jobs;

use App\Actions\UpdateOrCreateStreamFromApiData;
use App\Models\Stream;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use romanzipp\Twitch\Facades\Twitch;
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
            $trys = 0;
            do {
                $result = Twitch::getStreams([
                    'first' => 100,
                ], isset($result) ? $result->next() : null);

                foreach ($result->data() as $stream) {
                    UpdateOrCreateStreamFromApiData::execute($stream);
                }

                if (!$result->hasMoreResults()) {
                    break;
                }
            } while (Stream::query()->count() < $this->quantity && $trys++ < 15);
        });

        $tags = Tag::query()->select(['id', 'tag_uuid'])->get();
        $tags->chunk(100)->each(function ($tagsChunk) {
            ImportTwitchTagsTranslationsJob::dispatch($tagsChunk->pluck('tag_uuid')->toArray());
        });

        cache()->tags('streams')->flush();
    }
}
