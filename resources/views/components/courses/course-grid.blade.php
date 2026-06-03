@props([
'courses',
'mode' => 'default',
'backUrl' => route('courses.index'),

])
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($courses as $course)
    <x-courses.course-card
        :course="$course"
        :mode="$mode"
        :back-url="$backUrl" />
    @endforeach
</div>