<div class="flex justify-end">
    <div class="flex items-center gap-2">
        <label for="period" class="text-sm font-medium text-gray-600 dark:text-gray-300">Periode</label>
        <select
            id="period"
            wire:model.change="period"
            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm transition focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
        >
            <option value="today">Hari ini</option>
            <option value="7">7 hari terakhir</option>
            <option value="30">30 hari terakhir</option>
            <option value="90">90 hari terakhir</option>
            <option value="all">Semua waktu</option>
        </select>
    </div>
</div>
