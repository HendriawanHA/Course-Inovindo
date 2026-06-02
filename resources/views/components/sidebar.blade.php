<!-- Sidebar -->
<div x-show="sidebarOpen"
    class="w-64 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 flex flex-col flex-shrink-0 overflow-hidden transition-all duration-300 shadow-xl"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="-ml-64"
    x-transition:enter-end="ml-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="ml-0"
    x-transition:leave-end="-ml-64">

    <flux:sidebar sticky class="w-full h-full bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white border-none overflow-y-auto scroll-hide">

        <flux:sidebar.nav class="px-3 py-6">
            <flux:sidebar.item icon="pencil-square" href="#">Feed</flux:sidebar.item>
            <flux:sidebar.group heading="WELCOME" class="mt-8">
                <flux:sidebar.item icon="map-pin" href="#">Start Here</flux:sidebar.item>
                <flux:sidebar.item icon="list-bullet" href="#">Welcome Checklist</flux:sidebar.item>
                <flux:sidebar.item icon="megaphone" href="#">Announcements</flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group heading="NEWS & UPDATES" class="mt-8">
                <flux:sidebar.item icon="newspaper" href="#">AI News</flux:sidebar.item>
                <flux:sidebar.item icon="document-text" href="#" badge="1">Prompt Updates</flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group heading="COURSES" class="mt-8">

                @foreach($topCourses as $index => $course)

                <flux:sidebar.item
                    href="{{ route('courses.show', $course->id) }}"
                    icon="book-open">
                    {{ $course->title }}

                </flux:sidebar.item>

                @endforeach

            </flux:sidebar.group>

            <flux:sidebar.group heading="COMMUNITY" class="mt-8">
                <!-- Isi community nanti -->
            </flux:sidebar.group>

            <flux:sidebar.group heading="PREMIUM AREA" class="mt-8">
                <!-- Isi premium nanti -->
            </flux:sidebar.group>

            <flux:sidebar.group heading="LINK" class="mt-8">
                <flux:sidebar.item icon="link" href="#">Download the Android app</flux:sidebar.item>
                <flux:sidebar.item icon="link" href="#">Download the iOS app</flux:sidebar.item>
            </flux:sidebar.group>

        </flux:sidebar.nav>

    </flux:sidebar>
</div>