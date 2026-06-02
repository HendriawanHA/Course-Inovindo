<x-layouts.instructor title="Course Discussions">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-6xl">

            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                        @isset($course)
                            {{ $course->title }}
                        @else
                            Course Discussions
                        @endisset
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        @isset($course)
                            Kelola diskusi untuk course ini
                        @else
                            Balas pertanyaan student dari semua course
                        @endisset
                    </p>
                </div>

                <form method="GET" action="{{ route('instructor.discussions.index') }}">
                    <select name="course_id"
                        onchange="this.form.submit()"
                        class="rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                        <option value="">Semua Course</option>
                        @foreach ($courses as $c)
                            <option value="{{ $c->id }}" @selected(request('course_id') == $c->id)>
                                {{ $c->title }} ({{ $c->discussions_count }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-5">
                @forelse ($discussions as $discussion)
                    <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">

                        <div class="flex gap-4">
                            <img src="{{ $discussion->user->avatar
                                ? asset('storage/' . $discussion->user->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}"
                                class="h-11 w-11 rounded-full object-cover">

                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-zinc-900 dark:text-white">
                                        {{ $discussion->user->name }}
                                    </h3>
                                    <span class="text-xs text-zinc-400">
                                        {{ $discussion->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $discussion->course->title }} &bull; {{ $discussion->lesson?->title ?? '-' }}
                                </p>

                                <p class="mt-4 leading-relaxed text-zinc-700 dark:text-zinc-300">
                                    {{ $discussion->content }}
                                </p>

                                @php
                                    $hasInstructorReply = $discussion->replies->contains(fn($r) => $r->user->role === 'instructor');
                                @endphp

                                @if (!$hasInstructorReply && $discussion->replies->isEmpty() && !isset($course))
                                    <div class="mt-3">
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">Belum dibalas</span>
                                    </div>
                                @endif

                                @if ($discussion->replies->count())
                                    <div class="mt-5 space-y-3 border-l-2 border-zinc-200 pl-4 dark:border-zinc-800">
                                        @foreach ($discussion->replies as $reply)
                                            <div class="rounded-2xl bg-zinc-50 px-4 py-3 dark:bg-zinc-800/70">
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                                                        {{ $reply->user->name }}
                                                    </p>
                                                    @if ($reply->user->role === 'instructor')
                                                        <span class="rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Instructor</span>
                                                    @endif
                                                    <span class="text-xs text-zinc-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="mt-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">{{ $reply->content }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('instructor.discussions.reply', $discussion->id) }}" class="mt-5">
                                    @csrf
                                    <textarea name="content" rows="2" required
                                        placeholder="Tulis balasan sebagai instruktur..."
                                        class="w-full resize-none rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"></textarea>
                                    <div class="mt-3 flex justify-end">
                                        <button type="submit"
                                            class="rounded-2xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                            Kirim Balasan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-zinc-300 bg-white p-10 text-center dark:border-zinc-700 dark:bg-zinc-900">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">Belum ada diskusi</h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Diskusi dari student akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-layouts.instructor>
