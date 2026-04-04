/**
 * Master navbar: mobile drawer + scroll-compact header.
 */
function initMasterNav() {
    const root = document.querySelector('[data-master-nav]');
    if (!root) {
        return;
    }

    const toggle = root.querySelector('[data-nav-toggle]');
    const panel = root.querySelector('[data-nav-panel]');
    const inner = root.querySelector('.nav-master__inner');

    let open = false;

    const setOpen = (next) => {
        open = next;
        if (toggle) {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
        if (panel) {
            panel.dataset.open = open ? 'true' : 'false';
            panel.setAttribute('aria-hidden', open ? 'false' : 'true');
        }
        document.body.classList.toggle('overflow-hidden', open && window.matchMedia('(max-width: 1023px)').matches);
    };

    toggle?.addEventListener('click', () => {
        setOpen(!open);
    });

    panel?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            setOpen(false);
        }
    });

    window.addEventListener(
        'resize',
        () => {
            if (window.innerWidth >= 1024) {
                setOpen(false);
            }
        },
        { passive: true },
    );

    const scrollThreshold = 12;
    const onScroll = () => {
        const y = window.scrollY || document.documentElement.scrollTop;
        root.classList.toggle('nav-master--scrolled', y > scrollThreshold);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    /** Optional: CSS variable --nav-master-h for sticky subbars / page offset */
    if (typeof ResizeObserver !== 'undefined' && inner) {
        const ro = new ResizeObserver(() => {
            const h = inner.getBoundingClientRect().height ?? 64;
            document.documentElement.style.setProperty('--nav-master-h', `${Math.round(h)}px`);
        });
        ro.observe(inner);
    }
}

document.addEventListener('DOMContentLoaded', initMasterNav);
