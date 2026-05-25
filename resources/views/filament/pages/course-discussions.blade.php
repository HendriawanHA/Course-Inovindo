<x-filament-panels::page>
    <div class="space-y-6">
        @forelse ($this->courses as $course)
            <x-filament::section>
                <x-slot name="heading">
                    {{ $course->title }}
                </x-slot>

                <x-slot name="description">
                    {{ $course->discussions->count() }} diskusi
                </x-slot>

                <div class="space-y-4">
                    @forelse ($course->discussions as $discussion)
                        <x-filament::section>
                            <div class="space-y-5">

                                <!-- Header -->
                                <div class="flex items-start gap-3">

                                    <img src="{{ $discussion->user->avatar
                                        ? asset('storage/' . $discussion->user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}"
                                        class="h-10 w-10 rounded-full object-cover">

                                    <div class="min-w-0 flex-1">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h3 class="font-semibold text-white">
                                                {{ $discussion->user->name }}
                                            </h3>

                                            <span class="text-xs text-gray-500">
                                                {{ $discussion->created_at->diffForHumans() }}
                                            </span>

                                        </div>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Lesson: {{ $discussion->lesson?->title ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                                <!-- Discussion Content -->
                                <div class="pl-13">
                                    <p class="leading-relaxed text-gray-300">
                                        {{ $discussion->content }}
                                    </p>
                                </div>

                                <!-- Replies -->
                                @if ($discussion->replies->count())
                                    <div class="ml-5 border-l border-gray-800 pl-5 space-y-4">

                                        @foreach ($discussion->replies as $reply)
                                            <div class="flex items-start gap-3">

                                                <img src="{{ $reply->user->avatar
                                                    ? asset('storage/' . $reply->user->avatar)
                                                    : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}"
                                                    class="h-8 w-8 rounded-full object-cover">

                                                <div class="flex-1">

                                                    <div class="flex flex-wrap items-center gap-2">

                                                        <span class="font-semibold text-sm text-white">
                                                            {{ $reply->user->name }}
                                                        </span>

                                                        @if ($reply->user->role === 'instructor')
                                                            <x-filament::badge color="primary">
                                                                Instructor
                                                            </x-filament::badge>
                                                        @endif

                                                        <span class="text-xs text-gray-500">
                                                            {{ $reply->created_at->diffForHumans() }}
                                                        </span>

                                                    </div>

                                                    <p class="mt-1 text-sm leading-relaxed text-gray-300">
                                                        {{ $reply->content }}
                                                    </p>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                                <!-- Reply Form -->
                                @if ($replyingTo === $discussion->id)
                                    <div class="border-t border-gray-800 pt-4 space-y-3">

                                        <x-filament::input.wrapper>
                                            <textarea wire:model="replyContent" rows="3"
                                                class="fi-input block w-full border-none bg-transparent px-3 py-2 text-sm text-white outline-none ring-0 focus:ring-0"
                                                placeholder="Tulis balasan instruktur..."></textarea>
                                        </x-filament::input.wrapper>

                                        @error('replyContent')
                                            <p class="text-sm text-danger-500">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                        <div class="flex items-center gap-2">

                                            <x-filament::button wire:click="sendReply({{ $discussion->id }})">
                                                Kirim Balasan
                                            </x-filament::button>

                                            <x-filament::button color="gray" wire:click="cancelReply">
                                                Batal
                                            </x-filament::button>

                                        </div>

                                    </div>
                                @else
                                    <div class="pt-2">

                                        <x-filament::button size="sm" color="gray"
                                            wire:click="setReplyingTo({{ $discussion->id }})">
                                            Balas
                                        </x-filament::button>

                                    </div>
                                @endif

                            </div>
                        </x-filament::section>
                    @empty
                        <p class="text-sm text-gray-500">
                            Belum ada diskusi pada course ini.
                        </p>
                    @endforelse
                </div>
            </x-filament::section>
        @empty
            <x-filament::section>
                Belum ada course milik instruktur.
            </x-filament::section>
        @endforelse
    </div>
</x-filament-panels::page>
