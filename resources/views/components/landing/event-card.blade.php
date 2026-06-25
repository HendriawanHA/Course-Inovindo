@props(['event'])
<x-landing.card-wrapper>
    <flux:card class="h-full bg-white dark:bg-zinc-900 flex flex-col border border-zinc-200 dark:border-zinc-800 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
        <!-- Thumbnail -->
        <div class="relative">
            <img src="{{ asset('storage/'.$event->thumbnail) }}" class="w-full h-52 object-cover rounded-xl">
        </div>
        <div class="mt-4 flex flex-col flex-1">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white line-clamp-2">
                {{ $event->title }}
            </h3>
            <!-- Description -->
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 min-h-[60px]">
                {{ Str::limit(strip_tags($event->description), 90) }}
            </p>
            <!-- Meta -->
            <div class="flex flex-wrap gap-4 mt-4 text-sm text-zinc-500 dark:text-zinc-400">
                <div class="flex items-center gap-1">
                    <flux:icon.calendar-days class="size-4" />
                    <span>
                        {{ $event->start_time->format('d M Y') }}
                    </span>
                </div>
                <div class="flex items-center gap-1">
                    <flux:icon.video-camera class="size-4" />
                    <span>
                        {{ ucfirst($event->delivery_type) }}
                    </span>
                </div>
                <div class="flex items-center gap-1">
                    <flux:icon.users class="size-4" />
                    <span>
                        {{ $event->capacity }}
                    </span>
                </div>
            </div>
            <!-- Footer -->
            <div class="flex justify-end items-center mt-auto pt-6">
                <span class="font-bold text-emerald-500 ">
                    @if($event->is_paid)
                    Rp {{ number_format($event->price,0,',','.') }}
                    @else
                    GRATIS
                    @endif
                </span>
            </div>
        </div>
    </flux:card>
</x-landing.card-wrapper>