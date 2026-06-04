<div class="flex flex-row justify-between items-center gap-4 p-4 md:p-8 mb-6">

    <flux:heading size="xl" class="dark:text-white">
        Welcome {{ $user->name }}
    </flux:heading>

    <div class="flex items-center gap-2 flex-wrap">

        <div class="flex md:flex-row md:items-center md:gap-4 flex-col gap-2">

            <div class="flex -space-x-2">

                @foreach ($members as $member)

                <flux:avatar
                    circle
                    color="auto"
                    class="ring-2 ring-white dark:ring-zinc-950 size-8 md:size-12"
                    src="{{ $member->avatar_url }}" />

                @endforeach

            </div>

            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
                +{{ number_format($totalStudents) }} members
            </p>
        </div>

    </div>

</div>