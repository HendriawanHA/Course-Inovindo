<div
    x-cloak
    x-show="openBuyModal"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div
        @click="openBuyModal = false"
        class="absolute inset-0 bg-black/60 backdrop-blur-sm">
    </div>

    <div
        @click.stop
        x-show="openBuyModal"
        x-transition
        class="relative w-full max-w-md rounded-3xl
               bg-white dark:bg-zinc-900
               border border-zinc-200 dark:border-zinc-800
               p-6 shadow-2xl">
        <div class="flex justify-between">
            <h2 class="text-xl font-bold">
                Purchase Course
            </h2>
            <button
                @click="openBuyModal = false">
                ✕
            </button>
        </div>
        <template x-if="selectedCourse">
            <div>
                <div class="mt-6 aspect-video overflow-hidden rounded-xl">
                    <img
                        :src="selectedCourse.thumbnail"
                        class="w-full h-full object-cover">
                </div>
                <h3
                    class="mt-4 font-bold text-lg"
                    x-text="selectedCourse.title">
                </h3>
                <div class="flex items-center gap-3 mt-2">
                    <img
                        :src="selectedCourse.avatar"
                        class="w-8 h-8 rounded-full object-cover">
                    <span
                        class="text-sm text-zinc-500"
                        x-text="selectedCourse.instructor">
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3 mt-4">
                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-2xl bg-zinc-50 dark:bg-zinc-800 p-4 h-full">
                            <p>Modules</p>
                            <p
                                class="font-bold"
                                x-text="selectedCourse.modules">
                            </p>
                        </div>
                    </div>
                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-2xl bg-zinc-50 dark:bg-zinc-800 p-4 h-full">
                            <p>Lessons</p>
                            <p
                                class="font-bold"
                                x-text="selectedCourse.lessons">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <p class="text-sm">
                        Price
                    </p>
                    <p
                        class="text-3xl font-bold text-blue-700"
                        x-text="'Rp' + selectedCourse.price">
                    </p>
                </div>

                <form
                    class="mt-6"
                    method="POST"
                    :action="selectedCourse.buyUrl">
                    @csrf
                    <button
                        type="submit"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-700 to-emerald-500 text-white font-semibold hover:scale-[1.02] transition">
                        Confirm Purchase
                    </button>
                </form>
            </div>
        </template>
    </div>
</div>