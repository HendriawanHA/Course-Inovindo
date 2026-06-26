<div
    x-cloak
    x-show="openEventModal"
    x-data="{
        openEventModal: false,
        selectedEvent: null,
        isProcessing: false,
        errorMessage: '',
        pay() {
            this.isProcessing = true;
            this.errorMessage = '';
            fetch(this.selectedEvent.buyUrl, {
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
                            this.openEventModal = false;
                            window.location.href = '/payment/finish?order_id=' + result.order_id + '&transaction_status=settlement';
                        },
                        onPending: (result) => {
                            this.isProcessing = false;
                            this.openEventModal = false;
                            window.location.href = '/payment/pending?order_id=' + result.order_id;
                        },
                        onError: (result) => {
                            this.isProcessing = false;
                            this.openEventModal = false;
                            window.location.reload();
                        },
                        onClose: () => {
                            this.isProcessing = false;
                            this.openEventModal = false;
                            window.location.reload();
                        },
                    });
                } else {
                    this.isProcessing = false;
                    this.errorMessage = data.error || 'Gagal memproses pembayaran. Silakan coba lagi.';
                }
            })
            .catch(() => {
                this.isProcessing = false;
                this.errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
            });
        }
    }"
    @open-event-modal.window="selectedEvent = $event.detail; openEventModal = true;"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <!-- Overlay -->
    <div
        @click="openEventModal = false"
        class="absolute inset-0 bg-black/60 backdrop-blur-sm">
    </div>

    <!-- Modal -->
    <div
        @click.stop
        x-show="openEventModal"
        x-transition
        class="relative w-full max-w-4xl
           max-h-[90vh] overflow-y-auto
           rounded-3xl
           bg-white dark:bg-zinc-900
           border border-zinc-200 dark:border-zinc-800
           shadow-2xl scroll-hide">

        <template x-if="selectedEvent">
            <div>
                <!-- Thumbnail -->
                <div class="h-72 overflow-hidden rounded-t-3xl">
                    <img
                        :src="selectedEvent.thumbnail"
                        class="w-full h-full object-cover">
                </div>

                <div class="p-8">
                    <!-- Header -->
                    <div class="flex justify-between">
                        <h2
                            class="text-3xl font-bold"
                            x-text="selectedEvent.title">
                        </h2>
                        <flux:badge color="amber">
                            Paid Event
                        </flux:badge>
                    </div>
                    <div class="flex items-center gap-3 mt-4">
                        <img
                            :src="selectedEvent.avatar"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p
                                class="font-medium"
                                x-text="selectedEvent.instructor">
                            </p>
                            <p class="text-sm text-zinc-500">
                                Event Instructor
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-8">
                    <div class="mt-6 rounded-[18px] p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-[17px] bg-zinc-50 dark:bg-zinc-800 p-5">
                            <p
                                class="text-zinc-600 dark:text-zinc-300 leading-relaxed"
                                x-html="selectedEvent.description">
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="grid md:grid-cols-2 gap-4 mt-8 px-8">
                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-2xl bg-zinc-50 dark:bg-zinc-800 p-4 h-full">
                            <div class="flex items-center gap-2 text-blue-700">
                                <flux:icon.calendar-days class="size-5" />
                                <span class="font-medium">
                                    Date
                                </span>
                            </div>
                            <p
                                class="mt-2 font-semibold"
                                x-text="selectedEvent.date">
                            </p>
                        </div>
                    </div>

                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-2xl bg-zinc-50 dark:bg-zinc-800 p-4 h-full">
                            <div class="flex items-center gap-2 text-blue-700">
                                <flux:icon.clock class="size-5" />
                                <span class="font-medium">
                                    Time
                                </span>
                            </div>
                            <p
                                class="mt-2 font-semibold"
                                x-text="selectedEvent.time">
                            </p>
                        </div>
                    </div>


                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-2xl bg-zinc-50 dark:bg-zinc-800 p-4 h-full">
                            <div class="flex items-center gap-2 text-blue-700">
                                <flux:icon.video-camera class="size-5" />
                                <span class="font-medium">
                                    Delivery
                                </span>
                            </div>
                            <p
                                class="mt-2 font-semibold"
                                x-text="selectedEvent.delivery">
                            </p>
                        </div>
                    </div>

                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-2xl bg-zinc-50 dark:bg-zinc-800 p-4 h-full">
                            <div class="flex items-center gap-2 text-blue-700">
                                <flux:icon.users class="size-5" />
                                <span class="font-medium">
                                    Capacity
                                </span>
                            </div>
                            <p
                                class="mt-2 font-semibold"
                                x-text="selectedEvent.capacity + ' Participants'">
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="px-8 mt-4">
                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500">
                        <div class="rounded-2xl bg-zinc-50 dark:bg-zinc-800 p-4 h-full">
                            <div class="flex items-center gap-2 text-emerald-500">
                                <flux:icon.map-pin class="size-5" />
                                <span class="font-medium">
                                    Location
                                </span>
                            </div>
                            <p
                                class="mt-2 font-semibold"
                                x-text="selectedEvent.location">
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Price -->
                <div class="my-8">
                    <div class="px-8">
                        <p class="text-sm text-zinc-500">
                            Event Price
                        </p>
                        <p
                            class="text-4xl font-bold text-blue-700"
                            x-text="'Rp ' + selectedEvent.price">
                        </p>
                    </div>
                </div>

                <!-- Error -->
                <div class="px-8" x-show="errorMessage">
                    <div class="rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 p-4">
                        <p class="text-sm text-red-600 dark:text-red-400" x-text="errorMessage"></p>
                    </div>
                </div>

                <!-- Button -->
                <div class="my-8 px-8">
                    <button
                        @click="pay()"
                        :disabled="isProcessing"
                        class="w-full py-4 rounded-2xl bg-gradient-to-r from-blue-700 to-emerald-500 text-white font-semibold hover:scale-[1.02] transition disabled:opacity-50"
                        x-text="isProcessing ? 'Memproses...' : 'Purchase Ticket'">
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>