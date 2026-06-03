@props([
'courses',
'mode' => 'default'
])
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($courses as $course)
    <x-courses.course-card
        :course="$course"
        :mode="$mode" />
    @endforeach
</div>