<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Students</h1>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            Pantau student yang mengikuti course kamu.
        </p>
    </div>

    <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="grid grid-cols-12 border-b border-zinc-200 px-6 py-4 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">
            <div class="col-span-4">Student</div>
            <div class="col-span-4">Course</div>
            <div class="col-span-2">Progress</div>
            <div class="col-span-2">Enrolled</div>
        </div>

        @forelse ($enrollments as $enrollment)
        <div class="grid grid-cols-12 items-center border-b border-zinc-200 px-6 py-4 last:border-b-0 dark:border-zinc-800">
            <div class="col-span-4 flex items-center gap-3">
                <img
                    src="{{ $enrollment->user->avatar
                            ? asset('storage/' . $enrollment->user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($enrollment->user->name) }}"
                    class="h-10 w-10 rounded-full object-cover">

                <div>
                    <p class="font-semibold text-zinc-900 dark:text-white">
                        {{ $enrollment->user->name }}
                    </p>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $enrollment->user->email }}
                    </p>
                </div>
            </div>

            <div class="col-span-4">
                <p class="font-medium text-zinc-900 dark:text-white">
                    {{ $enrollment->course->title }}
                </p>
            </div>

            @php
            $progress = $enrollment->progress;

            $color =
            $progress >= 100 ? 'bg-emerald-500' :
            ($progress >= 50 ? 'bg-indigo-500' :
            'bg-amber-500');
            @endphp

            <div class="col-span-2">
                <div class="h-2 w-full rounded-full bg-zinc-200 dark:bg-zinc-800">
                    <div
                        class="h-2 rounded-full {{ $color }} transition-all duration-500"
                        style="width: {{ $progress }}%">
                    </div>
                </div>

                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    {{ $progress }}%
                </p>
            </div>

            <div class="col-span-2 text-sm text-zinc-500 dark:text-zinc-400">
                {{ $enrollment->created_at->format('d M Y') }}
            </div>
        </div>
        @empty
        <div class="p-10 text-center">
            <h3 class="font-semibold text-zinc-900 dark:text-white">Belum ada student</h3>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                Student yang enroll di course kamu akan muncul di sini.
            </p>
        </div>
        @endforelse
    </div>
</div>
