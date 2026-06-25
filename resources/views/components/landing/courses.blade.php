@props(['courses'])

<section class="bg-white mx-auto px-24 py-24">

    <div class="flex justify-between items-center">

        <h2 class="text-4xl font-bold flex items-center gap-6">
            <flux:icon.book-open class="size-8 text-blue-700" />
            Featured Courses

        </h2>

        <a href="{{ route('courses.index') }}">

            <flux:button class="!text-white !bg-emerald-500 hover:!bg-emerald-700 font-medium shadow-lg shadow-emerald-500/20 rounded-xl transition-all duration-200">
                View All
            </flux:button>

        </a>

    </div>

    <div class="grid md:grid-cols-3 gap-8 mt-12">

        @foreach($courses as $course)

        <x-landing.course-card
            :course="$course" />

        @endforeach

    </div>

</section>