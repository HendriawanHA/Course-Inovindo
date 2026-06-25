@props(['courses'])
<section id="courses" class="bg-white dark:bg-zinc-900 px-6 md:px-12 lg:px-24 py-20 relative">
    <x-landing.dark-bg />
    <div class="flex items-center gap-3 mb-4">
        <div class="h-[3px] w-12 rounded-full bg-gradient-to-r from-blue-700 to-emerald-50"></div>
        <span class="text-sm font-medium text-blue-700 dark:text-emerald-40">
            Kursus Premium
        </span>
    </div>
    <div class="flex items-center justify-between gap-4">
        <h2 class="text-3xl md:text-4xl font-bold flex items-center gap-4 text-zinc-900 dark:text-white">
            <flux:icon.book-open class="size-8 text-blue-700" />
            <span>
                Kursus
                <span
                    class="bg-gradient-to-r from-blue-700 to-emerald-500 bg-clip-text text-transparent">
                    Unggulan
                </span>
            </span>
        </h2>
        <a href="{{ route('courses.index') }}">
            <flux:button
                class="!bg-emerald-500 hover:!bg-emerald-600 !text-white font-medium shadow-lg shadow-emerald-500/20 transition-all">
                Lihat Semua
            </flux:button>
        </a>
    </div>
    <p class="mt-4 text-zinc-600 dark:text-zinc-400 max-w-2xl">
        Pelajari berbagai materi teknologi, bisnis, dan pengembangan diri
        melalui kursus yang telah dipilih berdasarkan popularitas dan kualitas.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
        @foreach($courses as $course)
        <x-landing.course-card :course="$course" />
        @endforeach
    </div>
</section>