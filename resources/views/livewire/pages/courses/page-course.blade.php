<x-app-layout>
    <flux:main
        class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900"

        x-data="{
            openBuyModal:false,
            selectedCourse:null
        }"
        @open-buy-modal.window="
            selectedCourse = $event.detail;
            openBuyModal = true;
        ">

        <x-courses.page-header
            icon="book-open"
            title="Courses" />

        <flux:separator class="mb-8" />

        <x-courses.course-filter />

        <x-courses.course-grid
            :courses="$courses"/>

        <x-courses.buy-course-modal />

    </flux:main>
</x-app-layout>