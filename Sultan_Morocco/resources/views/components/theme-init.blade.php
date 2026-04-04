<script>
    (function () {
        try {
            var k = 'sultan-theme',
                s = localStorage.getItem(k),
                d = document.documentElement;
            var dark =
                s === 'dark' ||
                (s !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            d.classList.toggle('dark', dark);
            d.setAttribute('data-theme', dark ? 'dark' : 'light');
            d.style.colorScheme = dark ? 'dark' : 'light';
        } catch (e) {}
    })();
</script>
