<x-app-layout>

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex flex-1">

        <!-- MAIN -->
        <div class="flex-1 flex flex-col pt-5 bg-zinc-50 dark:bg-zinc-900 min-h-screen">

            <!-- HEADER -->
            <x-courses.video-header
                :course="$course"
                :discussions="$discussions" />

            <flux:separator />

            <!-- CONTENT -->
            <div class="max-w-4xl mx-auto w-full px-6 mt-8">

                <!-- LESSON HEADER -->
                <x-courses.lesson-header
                    :lesson="$lesson"
                    :current-index="$currentIndex"
                    :total-lessons="$totalLessons"
                    :previous-lesson="$previousLesson"
                    :next-lesson="$nextLesson"
                    :course="$course" />

                <!-- VIDEO -->
                <x-courses.video-player
                    :lesson="$lesson" />

            </div>

            <!-- COMPLETE -->
            <x-courses.complete-btn
                :lesson="$lesson"
                :course="$course" />

            <flux:separator />

            <div id="discussion-section">
                <livewire:discussions.lesson-discussion :lesson="$lesson" />
            </div>

        </div>

        <!-- SIDEBAR -->
        <x-courses.sidebar-lesson
            :course="$course"
            :modules="$modules"
            :current-lesson="$lesson" />

    </div>
</x-app-layout>