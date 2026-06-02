<div class="flex justify-between items-center gap-2 text-zinc-400 p-8 mb-6">

    <flux:heading size="xl" class="dark:text-white">
        Welcome {{ $user->name }}
    </flux:heading>

    <div class="flex items-center gap-2">

        <div class="flex -space-x-2">

            @foreach ($members as $member)

                <flux:avatar
                    circle
                    size="sm"
                    class="ring-2 ring-white dark:ring-zinc-950"
                    src="{{ $member->avatar_url }}" />

            @endforeach

        </div>

        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            +{{ number_format($totalStudents) }} members
        </p>

    </div>

</div>