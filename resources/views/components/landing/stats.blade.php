<div class="p-6">

    <div class="grid md:grid-cols-3 gap-6">
        <x-landing.card-wrapper>
            <flux:card class="text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                <flux:heading size="xl" class="text-emerald-500">
                    {{ $coursesCount ?? '50+' }}
                </flux:heading>
                <flux:text>
                    Courses
                </flux:text>
            </flux:card>
        </x-landing.card-wrapper>

        <x-landing.card-wrapper>
            <flux:card class="text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                <flux:heading size="xl" class="text-emerald-500">
                    {{ $studentsCount ?? '1000+' }}
                </flux:heading>
                <flux:text class="text-zinc-900">
                    Students
                </flux:text>
            </flux:card>
        </x-landing.card-wrapper>

        <x-landing.card-wrapper>
            <flux:card class="text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                <flux:heading size="xl" class="text-emerald-500">
                    {{ $eventsCount ?? '20+' }}
                </flux:heading>
                <flux:text>
                    Events
                </flux:text>
            </flux:card>
        </x-landing.card-wrapper>

    </div>

</div>