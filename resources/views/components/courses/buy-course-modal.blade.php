<div
    x-cloak
    x-show="openBuyModal"
    x-data="{
        isProcessing: false,
        pay() {
            this.isProcessing = true;
            fetch(this.selectedCourse.buyUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            })
            .then(r => r.json())
            .then(data => {
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: (result) => {
                            this.isProcessing = false;
                            this.openBuyModal = false;
                            window.location.href = '/payment/finish?order_id=' + result.order_id + '&transaction_status=settlement';
                        },
                        onPending: (result) => {
                            this.isProcessing = false;
                            this.openBuyModal = false;
                            window.location.href = '/payment/pending?order_id=' + result.order_id;
                        },
                        onError: (result) => {
                            this.isProcessing = false;
                            this.openBuyModal = false;
                            window.location.href = this.selectedCourse.url;
                        },
                        onClose: () => {
                            this.isProcessing = false;
                            this.openBuyModal = false;
                            window.location.href = this.selectedCourse.url;
                        },
                    });
                }
            })
            .catch(() => {
                this.isProcessing = false;
            });
        }
    }"
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
                        class="text-3xl font-bold text-indigo-600"
                        x-text="'Rp' + selectedCourse.price">
                    </p>
                </div>

                <button
                    @click="pay()"
                    :disabled="isProcessing"
                    class="mt-6 w-full py-3 rounded-xl bg-indigo-600 text-white font-semibold transition hover:bg-indigo-500 disabled:opacity-50"
                    x-text="isProcessing ? 'Memproses...' : 'Bayar Sekarang'">
                </button>
            </div>
        </template>
    </div>
</div>
