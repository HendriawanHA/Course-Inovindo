@php
    use Illuminate\Support\Facades\Storage;

    $user = auth()->user();
@endphp

<x-filament::section>
    <div class="flex flex-col items-center text-center">
        <img
            src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
            class="h-28 w-28 rounded-full object-cover shadow"
        >

        <h2 class="mt-4 text-xl font-bold">
            {{ $user->name }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ $user->headline ?? 'Instructor' }}
        </p>

        <p class="mt-4 text-sm text-gray-500">
            {{ $user->bio ?? 'No bio added yet.' }}
        </p>
    </div>
</x-filament::section>
