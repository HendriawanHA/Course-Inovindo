<x-app-layout>
    <x-courses.detail-header
        :title="$course->title"
        :back-url="request('back', route('courses.index'))" />

    <flux:separator />

    <div class="max-w-4xl mx-auto mt-6 py-6 px-4">
        <div class="space-y-8 mb-12">
            <x-courses.header-page
                :course="$course"
                :target-lesson="$targetLesson"
                :has-started="$hasStarted"
                :is-completed="$isCompleted"
                :back-url="request('back', route('courses.index'))" />

            <x-courses.progress-detail
                :completedLessons="$completedLessons"
                :totalLessons="$totalLessons"
                :progress="$progress" />

            <x-courses.course-accordion :modules="$modules" />
            @if($isCompleted)
            <x-courses.certificate-banner :course="$course" />
            @endif
        </div>
</x-app-layout>