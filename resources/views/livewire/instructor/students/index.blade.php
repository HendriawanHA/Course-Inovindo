<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-white">Students</h1>
        <p class="mt-2 text-sm text-zinc-400">
            Pantau student yang mengikuti course kamu.
        </p>
    </div>

    <div class="rounded-3xl border border-zinc-800 bg-zinc-900 overflow-hidden">
        <div class="grid grid-cols-12 border-b border-zinc-800 px-6 py-4 text-xs font-semibold uppercase tracking-wide text-zinc-500">
            <div class="col-span-4">Student</div>
            <div class="col-span-4">Course</div>
            <div class="col-span-2">Progress</div>
            <div class="col-span-2">Enrolled</div>
        </div>

        @forelse ($enrollments as $enrollment)
            <div class="grid grid-cols-12 items-center border-b border-zinc-800 px-6 py-4 last:border-b-0">
                <div class="col-span-4 flex items-center gap-3">
                    <img
                        src="{{ $enrollment->user->avatar
                            ? asset('storage/' . $enrollment->user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($enrollment->user->name) }}"
                        class="h-10 w-10 rounded-full object-cover"
                    >

                    <div>
                        <p class="font-semibold text-white">
                            {{ $enrollment->user->name }}
                        </p>
                        <p class="text-sm text-zinc-500">
                            {{ $enrollment->user->email }}
                        </p>
                    </div>
                </div>

                <div class="col-span-4">
                    <p class="font-medium text-white">
                        {{ $enrollment->course->title }}
                    </p>
                </div>

                <div class="col-span-2">
                    <div class="h-2 w-full rounded-full bg-zinc-800">
                        <div class="h-2 rounded-full bg-indigo-500" style="width: 0%"></div>
                    </div>
                    <p class="mt-1 text-xs text-zinc-500">0%</p>
                </div>

                <div class="col-span-2 text-sm text-zinc-400">
                    {{ $enrollment->created_at->format('d M Y') }}
                </div>
            </div>
        @empty
            <div class="p-10 text-center">
                <h3 class="font-semibold text-white">Belum ada student</h3>
                <p class="mt-2 text-sm text-zinc-500">
                    Student yang enroll di course kamu akan muncul di sini.
                </p>
            </div>
        @endforelse
    </div>
</div>
