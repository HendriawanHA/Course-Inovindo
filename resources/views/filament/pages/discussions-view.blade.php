<x-filament-panels::page>
    <div class="flex gap-6">
        <aside class="hidden w-64 shrink-0 lg:block">
            <div class="sticky top-28 space-y-1">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Semua Course</h3>
                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                        {{ $sidebarCourses->count() }}
                    </span>
                </div>

                <a
                    href="{{ \App\Filament\Pages\Discussions::getUrl() }}"
                    class="block rounded-lg px-3 py-2 text-sm text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
                >
                    &larr; Kembali ke semua course
                </a>

                @foreach ($sidebarCourses as $sc)
                    <a
                        href="{{ \App\Filament\Pages\DiscussionsView::getUrl(['course' => $sc->id]) }}"
                        @class([
                            'flex items-center justify-between rounded-lg px-3 py-2 text-sm transition',
                            'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300' => $sc->id === $this->course->id,
                            'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => $sc->id !== $this->course->id,
                        ])
                    >
                        <span class="truncate">{{ Str::limit($sc->title, 25) }}</span>

                        @if ($sc->unanswered_count > 0)
                            <span @class([
                                'ml-2 shrink-0 rounded-full px-2 py-0.5 text-xs font-medium',
                                'bg-indigo-200 text-indigo-800 dark:bg-indigo-500/30 dark:text-indigo-200' => $sc->id === $this->course->id,
                                'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300' => $sc->id !== $this->course->id,
                            ])>
                                {{ $sc->unanswered_count }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <div class="mb-4 flex flex-wrap items-center gap-3 text-sm">
                <span class="rounded-lg bg-gray-100 px-3 py-1 font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    {{ $this->course->title }}
                </span>
                <span class="text-gray-400">{{ $totalDiscussions }} diskusi</span>
                @if ($unansweredDiscussions > 0)
                    <span class="font-medium text-amber-600 dark:text-amber-400">
                        {{ $unansweredDiscussions }} belum dibalas
                    </span>
                @endif
            </div>

            @if ($this->course->discussions->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-300 p-12 text-center dark:border-gray-600">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada diskusi di course ini.</p>
                </div>
            @else
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($this->course->discussions as $discussion)
                            @php
                                $replies = $discussion->replies->sortBy('created_at');
                                $hasInstructorReply = $replies->contains(fn($r) => $r->user->role === 'instructor');
                                $isUnanswered = ! $hasInstructorReply;
                            @endphp

                            <div class="p-5 sm:p-6">
                                <div class="flex flex-wrap items-center gap-2 mb-4">
                                    <span class="font-semibold text-sm text-gray-900 dark:text-white">
                                        {{ $discussion->lesson?->title ?? 'Diskusi Course' }}
                                    </span>

                                    @if ($isUnanswered)
                                        <span class="rounded-lg bg-amber-400/15 px-2 py-0.5 text-xs font-semibold text-amber-700 dark:text-amber-300">Belum dibalas</span>
                                    @else
                                        <span class="rounded-lg bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">Sudah dibalas</span>
                                    @endif
                                </div>

                                <div class="flex gap-4">
                                    <img
                                        src="{{ $discussion->user->avatar ? asset('storage/' . $discussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}"
                                        alt="{{ $discussion->user->name }}"
                                        class="size-10 shrink-0 rounded-full object-cover"
                                    >

                                    <div class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-600 dark:bg-gray-900/60">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $discussion->user->name }}</p>
                                            <span class="rounded-md bg-gray-200 px-2 py-0.5 text-[11px] font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">Student</span>
                                            <span class="text-xs text-gray-400">{{ $discussion->created_at->diffForHumans() }}</span>

                                            <button
                                                wire:click="deleteDiscussion({{ $discussion->id }})"
                                                wire:confirm="Yakin hapus diskusi ini? Semua balasan juga akan terhapus."
                                                class="ml-auto shrink-0 rounded-lg p-1 text-gray-400 transition hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400"
                                                title="Hapus diskusi"
                                            >
                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-700 dark:text-gray-300">{{ $discussion->content }}</p>
                                    </div>
                                </div>

                                @foreach ($replies as $reply)
                                    <div class="mt-4 flex gap-4 pl-8 sm:pl-12">
                                        <img
                                            src="{{ $reply->user->avatar ? asset('storage/' . $reply->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}"
                                            alt="{{ $reply->user->name }}"
                                            class="size-10 shrink-0 rounded-full object-cover"
                                        >

                                        <div class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-600 dark:bg-gray-900/60">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $reply->user->name }}</p>
                                                @if ($reply->user->role === 'instructor')
                                                    <span class="rounded-md bg-indigo-100 px-2 py-0.5 text-[11px] font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Instructor</span>
                                                @elseif ($reply->user->role === 'admin')
                                                    <span class="rounded-md bg-red-100 px-2 py-0.5 text-[11px] font-medium text-red-700 dark:bg-red-500/20 dark:text-red-300">Admin</span>
                                                @else
                                                    <span class="rounded-md bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">Student</span>
                                                @endif
                                                <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>

                                                <button
                                                    wire:click="deleteReply({{ $reply->id }})"
                                                    wire:confirm="Yakin hapus balasan ini? Tindakan tidak bisa dibatalkan."
                                                    class="ml-auto shrink-0 rounded-lg p-1 text-gray-400 transition hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400"
                                                    title="Hapus balasan"
                                                >
                                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-600 dark:text-gray-300">{{ $reply->content }}</p>

                                            @if ($reply->children->isNotEmpty())
                                                <div class="mt-4 space-y-3">
                                                    @foreach ($reply->children as $child)
                                                        <div class="flex gap-3">
                                                            <img
                                                                src="{{ $child->user->avatar ? asset('storage/' . $child->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($child->user->name) }}"
                                                                alt="{{ $child->user->name }}"
                                                                class="size-8 shrink-0 rounded-full object-cover"
                                                            >
                                                            <div class="min-w-0 flex-1 rounded-lg border border-gray-200 bg-white p-3 dark:border-gray-600 dark:bg-gray-800">
                                                                <div class="flex flex-wrap items-center gap-2">
                                                                    <p class="text-xs font-semibold text-gray-900 dark:text-white">{{ $child->user->name }}</p>
                                                                    @if ($child->user->role === 'instructor')
                                                                        <span class="rounded-md bg-indigo-100 px-1.5 py-0.5 text-[10px] font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Instructor</span>
                                                                    @elseif ($child->user->role === 'admin')
                                                                        <span class="rounded-md bg-red-100 px-1.5 py-0.5 text-[10px] font-medium text-red-700 dark:bg-red-500/20 dark:text-red-300">Admin</span>
                                                                    @else
                                                                        <span class="rounded-md bg-gray-100 px-1.5 py-0.5 text-[10px] font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">Student</span>
                                                                    @endif
                                                                    <span class="text-[11px] text-gray-400">{{ $child->created_at->diffForHumans() }}</span>

                                                                    <button
                                                                        wire:click="deleteReply({{ $child->id }})"
                                                                        wire:confirm="Yakin hapus balasan ini? Tindakan tidak bisa dibatalkan."
                                                                        class="ml-auto shrink-0 rounded p-0.5 text-gray-400 transition hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-400"
                                                                        title="Hapus balasan"
                                                                    >
                                                                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <p class="mt-1.5 whitespace-pre-line text-xs leading-relaxed text-gray-600 dark:text-gray-300">{{ $child->content }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </main>
    </div>
</x-filament-panels::page>
