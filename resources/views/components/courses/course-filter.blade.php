<div class="flex gap-2 mb-8">
    <a href="{{ route('courses.index') }}">
        <flux:button
            variant="{{ request()->routeIs('courses.index') ? 'filled' : 'ghost' }}"
            class="rounded-full">
            All Courses
        </flux:button>
    </a>
    <a href="{{ route('courses.my') }}">
        <flux:button
            variant="{{ request()->routeIs('courses.my') ? 'filled' : 'ghost' }}"
            class="rounded-full">
            My Courses
        </flux:button>
    </a>
</div>