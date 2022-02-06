<?php

namespace Tests\Feature\jobs;

use App\Jobs\ImportTwitchTopLiveStreamsJob;
use App\Models\Game;
use App\Models\Stream;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportTwitchTopLiveStreamsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_import_live_streams()
    {
        $job = new ImportTwitchTopLiveStreamsJob(50);
        $job->handle();

        $this->assertTrue(Stream::count() > 40);
        $this->assertTrue(Game::count() > 0);
        $this->assertTrue(Tag::count() > 0);
    }
}