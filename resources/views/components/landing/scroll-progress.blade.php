<div
    x-data="{ width: 0 }"
    x-init="
        window.addEventListener('scroll', () => {
            const winScroll =
                document.documentElement.scrollTop;

            const height =
                document.documentElement.scrollHeight -
                document.documentElement.clientHeight;

            width = (winScroll / height) * 100;
        });
    "

    class="
        fixed
        top-0
        left-0
        z-[999]
        h-1
        bg-gradient-to-r
        from-blue-700
        to-emerald-500
    "

    :style="`width:${width}%`">
</div>