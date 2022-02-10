<div class="space-y-4" wire:init="updateFollowedStreams">
    <div class="xl:flex xl:space-x-2">
        <x-card title="Top Games">
            <livewire:top-games-by-viewer-table/>
        </x-card>

        <x-card title="Top Streams">
            <livewire:top-streams-by-viewers-table/>
        </x-card>
    </div>

    <div class="xl:flex xl:space-x-2">
        <x-card title="Streams By Start Time">
            <livewire:streams-by-start-time-table/>
        </x-card>
        <x-card title="Top 1000 Streams you are Following">
            <livewire:top-following-streams-for-user-table :user="$user"/>
        </x-card>
    </div>
</div>
