<div class="flex justify-between items-center gap-2 text-zinc-500 dark:text-zinc-400 px-6 mb-6">

    <div class="flex items-center gap-3">

        <flux:navbar.item href="{{ request('back', route('courses.show', $course->id)) }}">
            <flux:icon.arrow-left variant="micro" />
        </flux:navbar.item>

        <flux:heading size="xl" class="dark:text-white text-zinc-900">
            {{ $course->title }}
        </flux:heading>

    </div>

    <div class="flex items-center gap-1 mr-5">

        <!-- DISCUSSION -->
        <flux:navbar.item
            @click="document.getElementById('discussion-section')?.scrollIntoView({ behavior: 'smooth' })"
            class="cursor-pointer">

            <flux:icon.chat-bubble-bottom-center-text class="w-5 h-5" />

            @if ($discussions->count())
            <div class="absolute top-1 right-1 w-2 h-2 rounded-full bg-blue-700"></div>
            @endif
        </flux:navbar.item>

        <!-- SIDEBAR -->
        <flux:navbar.item @click="sidebarOpen = !sidebarOpen" class="cursor-pointer">
            <flux:icon.list-bullet />
        </flux:navbar.item>

    </div>

</div>