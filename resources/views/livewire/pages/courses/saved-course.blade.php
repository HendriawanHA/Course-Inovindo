<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900"
        x-data="{
            openBuyModal:false,
            selectedCourse:null
        }"
        @open-buy-modal.window="
            selectedCourse = $event.detail;
            openBuyModal = true;
        ">
        <x-courses.page-header
            icon="bookmark"
            title="Saved Courses">
            <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                Courses you saved or joined will appear here.
            </flux:text>
        </x-courses.page-header>

        <flux:separator class="mb-8" />

        @if ($courses->isEmpty())
        <x-courses.empty-state-saved />
        @else
        <x-courses.course-grid
            :courses="$courses"
            mode="saved"
            :back-url="route('courses.saved')" />
        @endif

        <x-courses.buy-course-modal />

    </flux:main>
</x-app-layout>