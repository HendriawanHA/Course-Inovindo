<x-app-layout>
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
        class="flex flex-1 overflow-hidden">
        <div class="flex-1 flex flex-col min-w-0 pt-5 bg-zinc-50 dark:bg-zinc-900 min-h-screen">
            <x-courses.video-header
                :course="$course"
                :discussions="$discussions" />

            <flux:separator />

            <div class="max-w-4xl mx-auto w-full px-4 md:px-6 mt-6 md:mt-8">
                <x-courses.lesson-header
                    :lesson="$lesson"
                    :current-index="$currentIndex"
                    :total-lessons="$totalLessons"
                    :previous-lesson="$previousLesson"
                    :next-lesson="$nextLesson"
                    :course="$course" />

                <x-courses.video-player
                    :lesson="$lesson" />
            </div>

            <x-courses.complete-btn
                :lesson="$lesson"
                :course="$course" />

            <flux:separator />

            <div id="discussion-section">
                <livewire:discussions.lesson-discussion :lesson="$lesson" />
            </div>
        </div>

        <x-courses.sidebar-lesson
            :course="$course"
            :modules="$modules"
            :current-lesson="$lesson" />
    </div>
</x-app-layout>