<x-app-layout>
    <div class="flex justify-between items-center gap-2 text-zinc-400 p-8 mb-6">
        <flux:heading size="xl" class="dark:text-white">Welcome {{ auth()->user()->name }}</flux:heading>
        <div class="flex items-center gap-2">
            <div class="flex -space-x-2">

                @foreach ($members as $member)

                <flux:avatar
                    circle
                    size="sm"
                    class="ring-2 ring-white dark:ring-zinc-950"
                    src="{{ $member->avatar
                    ? asset('storage/' . $member->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" />

                @endforeach

            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                +{{ number_format($totalStudents) }} members
            </p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 px-8">

        <!-- Total Students -->
        <flux:card class="rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg">
            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center">
                    <flux:icon.users variant="solid" class="text-indigo-500 size-6" />
                </div>

                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Students
                    </p>

                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">
                        {{ $totalStudents }}
                    </h2>
                </div>

            </div>
        </flux:card>

        <!-- Courses -->
        <flux:card class="rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg">
            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-pink-500/10 flex items-center justify-center">
                    <flux:icon.book-open variant="solid" class="text-pink-500 size-6" />
                </div>

                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Courses
                    </p>

                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">
                        {{ $totalCourses }}
                    </h2>
                </div>

            </div>
        </flux:card>

        <!-- Events -->
        <flux:card class="rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg">
            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center">
                    <flux:icon.calendar-days variant="solid" class="text-emerald-500 size-6" />
                </div>

                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Events
                    </p>

                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">
                        {{ $latestEvents->count() }}
                    </h2>
                </div>

            </div>
        </flux:card>

    </div>
    <div class="px-8 mt-10">

        <div class="flex items-center justify-between mb-6">

            <flux:heading size="lg">
                Featured Courses
            </flux:heading>

            <flux:link href="{{ route('courses.index') }}" wire:navigate>
                View all
            </flux:link>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            @foreach ($featuredCourses as $course)

            <a href="{{ route('courses.show', $course->id) }}" wire:navigate>

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 
                            rounded-2xl overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 shadow-sm
                            hover:shadow-lg transition-all duration-200">

                    <div class="aspect-video bg-zinc-900 relative overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $course->thumbnail) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="{{ $course->title }}" />
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <flux:heading size="sm" class="text-zinc-900 dark:text-white font-semibold leading-tight line-clamp-2">
                            {{ $course->title }}
                        </flux:heading>

                        <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-3">
                            {{ $course->category ?? 'Course' }}
                        </flux:text>

                    </div>

                </div>

            </a>

            @endforeach

        </div>

    </div>
    <div class="px-8 mt-10">
        <div class="flex items-center justify-between mb-6">
            <flux:heading size="lg">
                Upcoming Events
            </flux:heading>
            <flux:link href="{{ route('events.index') }}" wire:navigate>
                View all
            </flux:link>
        </div>


        <div class="space-y-4">

            @foreach ($latestEvents as $event)

            <a href="{{ route('events.show', $event->slug) }}" wire:navigate>

                <flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm hover:shadow-xl transition-all mb-4">

                    <div class="flex flex-col md:flex-row gap-6 items-start">

                        <img
                            src="{{ asset('storage/' . $event->thumbnail) }}"
                            alt="Event"
                            class="w-full md:w-56 h-24 object-cover rounded-2xl" />

                        <div class="flex-1 min-w-0">

                            <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                                {{ $event->title }}
                            </flux:heading>

                            <div class="flex items-center gap-2 mt-3 text-zinc-500 dark:text-zinc-400">

                                <flux:icon.calendar-days variant="micro" />

                                <flux:text class="text-sm">
                                    {{ $event->start_time->format('l, F d, Y • h:i A') }}
                                </flux:text>

                            </div>

                            <div class="flex items-center gap-2 mt-2 text-zinc-500 dark:text-zinc-400">

                                <flux:icon.video-camera variant="micro" />

                                <flux:text class="text-sm">
                                    {{ $event->delivery_type }}
                                </flux:text>

                            </div>

                        </div>

                    </div>

                </flux:card>

            </a>

            @endforeach

        </div>

    </div>
    <div class="px-8 mt-10 pb-10">

        <flux:heading size="lg" class="mb-6">
            Top Students
        </flux:heading>

        <flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800 shadow-xl">

            @foreach ($topStudents as $index => $leader)

            <div class="flex items-center justify-between p-5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">

                <div class="flex items-center gap-5">

                    <!-- Rank -->
                    <div class="w-10 text-center">

                        @if ($index < 3)

                            <div class="w-9 h-9 rounded-full bg-amber-500 text-black font-bold flex items-center justify-center text-lg">
                            {{ $index + 1 }}
                    </div>

                    @else

                    <div class="text-xl font-bold text-zinc-400 dark:text-zinc-500">
                        {{ $index + 1 }}
                    </div>

                    @endif

                </div>

                <!-- Avatar -->
                <flux:avatar
                    size="md"
                    circle
                    src="{{ $leader->avatar
                    ? asset('storage/' . $leader->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($leader->name) }}" />

                <!-- User Info -->
                <div>

                    <flux:heading size="sm" class="text-zinc-900 dark:text-white">
                        {{ $leader->name }}
                    </flux:heading>

                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $leader->bio ?? 'No bio yet' }}
                    </flux:text>

                </div>

            </div>

            <!-- Points -->
            <div class="text-right">

                <div class="text-emerald-600 dark:text-emerald-400 font-bold text-xl">
                    +{{ $leader->points }}
                </div>

                <flux:text class="text-xs text-zinc-400">
                    points
                </flux:text>

            </div>

    </div>

    @endforeach

    </flux:card>

    </div>
</x-app-layout>