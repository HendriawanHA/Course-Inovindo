<x-layouts.landing>

            <div class="text-4xl">jika</div>


    <x-landing.scroll-progress />

    <x-landing.landing-navbar />

    <x-landing.hero
        :courses-count="$coursesCount"
        :students-count="$studentsCount"
        :events-count="$eventsCount" />

    <x-landing.features />

    <x-landing.courses :courses="$courses" />

    <x-landing.learn />

    <x-landing.certificate />

    <x-landing.events :events="$events" />

    <x-landing.testimoni />

    <x-landing.cta />

    <x-landing.footer />

    <x-landing.back-to-top />


</x-layouts.landing>
