import './bootstrap';
import Alpine from 'alpinejs'
import Chart from 'chart.js/auto';

const tooltipDrag = { id: null, offsetX: 0, offsetY: 0 };

Alpine.data('eqsearch', (initialQuery = '') => ({
    query: initialQuery,
    results: [],
    loading: false,

    async load() {
        if (this.query.length < 2) {
            this.results = [];
            this.loading = false;
            return;
        }

        this.loading = true;

        try {
            const res = await fetch(`/search/suggest?q=${encodeURIComponent(this.query)}`);
            const data = await res.json();
            this.results = data;
        } catch (e) {
            //console.error('error loading search results:', e);
        } finally {
            this.loading = false;
        }
    }
}));

let zCounter = 1000;
Alpine.data('draggableBag', ({ id }) => ({
    visible: false,
    dragging: false,
    offsetX: 0,
    offsetY: 0,
    originX: null,
    originY: null,
    targetX: null,
    targetY: null,
    top: 0,
    left: 0,
    zIndex: zCounter++,
    hasBeenMoved: false,
    triggerEl: null,

    init() {
        this.windowWidth = window.innerWidth;

        window.addEventListener('resize', () => {
            const newWidth = window.innerWidth;
            if (Math.abs(newWidth - this.windowWidth) > 100) {
                this.hasBeenMoved = false;
            }

            this.windowWidth = newWidth;
        });

        window.addEventListener('closeAllBags', () => {
            this.visible = false;
        });

        const update = () => {
            this.pollOriginPosition();
            requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    },

    startDrag(e) {
        this.dragging = true;
        this.offsetX = e.clientX - this.left;
        this.offsetY = e.clientY - this.top;
        this.bringToFront();
        this.hasBeenMoved = true;
    },

    drag(e) {
        if (this.dragging) {
            const bag = this.$refs.bagWindow;
            const bagRect = bag?.getBoundingClientRect();
            const bagWidth = bagRect?.width || 240;
            const bagHeight = bagRect?.height || 300;

            let newTop = e.clientY - this.offsetY;
            let newLeft = e.clientX - this.offsetX;

            newTop = Math.max(0, Math.min(newTop, window.innerHeight - bagHeight));
            newLeft = Math.max(0, Math.min(newLeft, window.innerWidth - bagWidth));

            this.top = newTop;
            this.left = newLeft;
            this.updateTargetPoint();
        }
    },

    stopDrag() {
        this.dragging = false;
    },

    bringToFront() {
        this.zIndex = zCounter++;
    },

    openBag(triggerEl) {
        this.bringToFront();
        this.triggerEl = triggerEl;

        if (triggerEl) {
            const triggerRect = triggerEl.getBoundingClientRect();

            this.originX = triggerRect.left + triggerRect.width / 2;
            this.originY = triggerRect.top + triggerRect.height / 2;

            if (!this.hasBeenMoved) {
                this.left = triggerRect.left + triggerRect.width + 8 + window.scrollX;
                this.top = triggerRect.top + window.scrollY;
            }

            this.targetX = this.left;
            this.targetY = this.top;
        }

        this.visible = true;

        if (triggerEl) {
            const triggerRect = triggerEl.getBoundingClientRect();

            this.$nextTick(() => {
                if (this.hasBeenMoved) {
                    requestAnimationFrame(() => this.updateTargetPoint());
                    return;
                }

                const bag = this.$refs.bagWindow;
                if (!bag) return;

                const bagRect = bag.getBoundingClientRect();

                let newLeft = triggerRect.left + triggerRect.width + 8 + window.scrollX;
                let newTop = triggerRect.top + window.scrollY;

                if (newLeft + bagRect.width > window.innerWidth) {
                    newLeft = triggerRect.left - bagRect.width - 8 + window.scrollX;
                }

                if (newLeft < 0) {
                    newLeft = triggerRect.left + window.scrollX;
                    newTop = triggerRect.top + triggerRect.height + 8 + window.scrollY;
                }

                newLeft = Math.max(0, Math.min(newLeft, window.innerWidth - bagRect.width));
                newTop = Math.max(0, Math.min(newTop, window.innerHeight - bagRect.height));

                this.left = newLeft;
                this.top = newTop;

                requestAnimationFrame(() => this.updateTargetPoint());
            });
        }
    },

    closeBag() {
        this.visible = false;
    },

    updateTargetPoint() {
        const bag = this.$refs.bagWindow;
        if (bag) {
            const bagRect = bag.getBoundingClientRect();

            let targetX = bagRect.left + bagRect.width / 2;
            let targetY = bagRect.top;

            if (this.top > this.originY + 20) {
                targetY = bagRect.top;
            } else {
                targetY = bagRect.top + bagRect.height / 2;
            }

            this.targetX = targetX + window.scrollX;
            this.targetY = targetY + window.scrollY;
        }
    },

    pollOriginPosition() {
        if (this.triggerEl && this.visible) {
            const rect = this.triggerEl.getBoundingClientRect();
            this.originX = rect.left + rect.width / 2;
            this.originY = rect.top + rect.height / 2;
        }
    },

}));

Alpine.data('compare', (name = '') => ({
    name,
    key: 'compareChars',
    isSelected: false,
    showBar: false,
    compareUrl: '#',

    init() {
        this.refresh();
        window.addEventListener('storage', () => this.refresh());
    },

    getList() {
        try { return JSON.parse(localStorage.getItem(this.key) || '[]'); } catch (e) { return []; }
    },

    saveList(list) {
        localStorage.setItem(this.key, JSON.stringify(list));
    },

    refresh() {
        const list = this.getList();
        this.isSelected = list.includes(this.name);
        if (list.length >= 2) {
            this.showBar = true;
            const a = encodeURIComponent(list[0]);
            const b = encodeURIComponent(list[1]);
            this.compareUrl = '/character/compare?a=' + a + '&b=' + b;
        } else {
            this.showBar = false;
            this.compareUrl = '#';
        }
    },

    toggle() {
        let list = this.getList();
        if (this.isSelected) {
            list = list.filter(x => x !== this.name);
        } else {
            if (list.length >= 2) list.shift();
            list.push(this.name);
        }
        this.saveList(list);
        this.refresh();
    },

    clear() {
        this.saveList([]);
        this.refresh();
    }
}));

Alpine.store('tooltipz', {
    content: '',
    visible: false,
    cache: new Map(),
    tooltipEl: null,

    async loadTooltip(url, triggerEl, event) {
        if (!triggerEl) return;
        if (event && event.preventDefault) event.preventDefault();

        this.loadingUrl = url;
        this.tooltipEl = document.getElementById('global-tooltip-normal');

        const effectsOnly = triggerEl.dataset.effectsOnly === '1';
        if (effectsOnly) {
            url += '?effects-only=1';
        }

        if (this.cache.has(url)) {
            this.content = this.cache.get(url);
            this.loadingUrl = null;
        } else {
            try {
                const response = await fetch(url);
                const data = await response.json();
                this.cache.set(url, data.html);
                this.content = data.html;
            } catch (err) {
                this.content = '<div class="text-error">Failed to load tooltip.</div>';
            }
            this.loadingUrl = null;
        }

        this.visible = true;

        requestAnimationFrame(() => {
            this.positionTooltip(event, triggerEl);
        });
    },

    hideTooltip() {
        this.visible = false;
    },

    positionTooltip(e, triggerEl) {
        const tooltip = this.tooltipEl;
        if (!tooltip || !triggerEl) return;

        tooltip.style.visibility = 'hidden';
        tooltip.style.display = 'block';

        const tooltipHeight = tooltip.offsetHeight;
        const tooltipWidth = tooltip.offsetWidth;
        const rect = triggerEl.getBoundingClientRect();
        const scrollX = window.scrollX;
        const scrollY = window.scrollY;

        let top = rect.top + rect.height / 2 - tooltipHeight / 2 + scrollY;
        let left;

        const spaceRight = window.innerWidth - (rect.right + 10);
        const spaceLeft = rect.left - 10;

        if (spaceRight >= tooltipWidth) {
            left = rect.right + 10 + scrollX;
        } else if (spaceLeft >= tooltipWidth) {
            left = rect.left - tooltipWidth - 10 + scrollX;
        } else {
            left = scrollX + rect.left + (rect.width / 2) - (tooltipWidth / 2);
        }

        const maxBottom = scrollY + window.innerHeight - 10;
        if (top + tooltipHeight > maxBottom) {
            top = maxBottom - tooltipHeight;
        }
        if (top < scrollY + 10) {
            top = scrollY + 10;
        }

        tooltip.style.left = `${left}px`;
        tooltip.style.top = `${top}px`;
        tooltip.style.visibility = 'visible';
    }
});

Alpine.store('tooltip', {
    tooltips: {},
    activeTooltipId: null,

    register(id) {
        if (!this.tooltips[id]) {
            this.tooltips[id] = {
                id,
                el: null,
                content: '',
                visible: false,
                locked: false,
                cachedHtml: null,
            };
        }
    },

    _getOrCreateEl(id) {
        const t = this.tooltips[id];
        if (!t) return null;
        if (t.el) return t.el;

        const div = document.createElement('div');
        div.className = 'fixed bg-base-200 rounded shadow-[0px_0px_15px_0px_rgba(0,_0,_0,_0.7)] max-w-lg text-sm pointer-events-auto';
        div.style.cssText = 'position: fixed; display: none; user-select: none; z-index: 9999;';
        div.innerHTML = `
            <div class="flex items-center justify-between px-2 h-6 cursor-move bg-base-300 rounded-t text-base-content/40 text-xs select-none" data-drag-handle>
                <span class="tracking-widest">-</span>
                <button data-close class="text-base-content/40 hover:text-red-500 font-bold text-sm leading-none ml-2" title="Close">&times;</button>
            </div>
            <div class="relative p-0 cursor-default"><div data-tooltip-content></div></div>
        `;
        document.body.appendChild(div);
        t.el = div;

        div.querySelector('[data-drag-handle]').addEventListener('mousedown', (e) => {
            if (e.target.closest('[data-close]')) return;
            e.stopPropagation();
            e.preventDefault();
            const tt = Alpine.store('tooltip').tooltips[id];
            if (!tt || !tt.el) return;
            tt.locked = true;
            const rect = tt.el.getBoundingClientRect();
            tooltipDrag.id = id;
            tooltipDrag.offsetX = e.clientX - rect.left;
            tooltipDrag.offsetY = e.clientY - rect.top;
            zCounter++;
            tt.el.style.zIndex = zCounter;
        });

        div.querySelector('[data-close]').addEventListener('click', (e) => {
            e.stopPropagation();
            Alpine.store('tooltip').unlock(id);
        });

        div.addEventListener('mousedown', () => {
            const tt = Alpine.store('tooltip').tooltips[id];
            if (tt && tt.el) {
                zCounter++;
                tt.el.style.zIndex = zCounter;
            }
        });

        return div;
    },

    async show(id, url, triggerEl, event) {
        const tooltip = this.tooltips[id];
        if (!tooltip || tooltip.locked) return;

        this.activeTooltipId = id;
        this.closeAllUnlockedExcept(id);

        if (!tooltip.cachedHtml) {
            try {
                const res = await fetch(url);
                const data = await res.json();
                tooltip.cachedHtml = data.html;
                tooltip.content = data.html;
            } catch {
                tooltip.content = '<div class="text-error">Failed to load tooltip.</div>';
            }
        } else {
            tooltip.content = tooltip.cachedHtml;
        }

        if (this.activeTooltipId !== id || tooltip.locked) return;

        const el = this._getOrCreateEl(id);
        if (!el) return;

        el.querySelector('[data-tooltip-content]').innerHTML = tooltip.content;
        tooltip.visible = true;

        requestAnimationFrame(() => {
            this.positionTooltip(id, event, triggerEl);
        });
    },

    showStatic(id, triggerEl, event) {
        const tooltip = this.tooltips[id];
        if (!tooltip || tooltip.locked) return;

        this.activeTooltipId = id;
        this.closeAllUnlockedExcept(id);

        const el = this._getOrCreateEl(id);
        if (!el) return;

        el.querySelector('[data-tooltip-content]').innerHTML = tooltip.content;
        tooltip.visible = true;

        requestAnimationFrame(() => {
            this.positionTooltip(id, event, triggerEl);
        });
    },

    hide(id) {
        const t = this.tooltips[id];
        if (!t || t.locked) return;
        t.visible = false;
        if (t.el) t.el.style.display = 'none';
    },

    toggleLock(id) {
        const t = this.tooltips[id];
        if (!t) return;
        t.locked = !t.locked;
        if (t.locked && t.el) {
            zCounter++;
            t.el.style.zIndex = zCounter;
        }
        if (!t.locked) {
            t.visible = false;
            if (t.el) t.el.style.display = 'none';
        }
    },

    unlock(id) {
        const t = this.tooltips[id];
        if (!t) return;
        t.locked = false;
        t.visible = false;
        if (t.el) t.el.style.display = 'none';
    },

    closeAllUnlockedExcept(exceptId) {
        for (const [id, t] of Object.entries(this.tooltips)) {
            if (id !== exceptId && !t.locked) {
                t.visible = false;
                if (t.el) t.el.style.display = 'none';
            }
        }
    },

    hideAll() {
        for (const t of Object.values(this.tooltips)) {
            t.visible = false;
            t.locked = false;
            if (t.el) t.el.style.display = 'none';
        }
        tooltipDrag.id = null;
    },

    positionTooltip(id, e, triggerEl) {
        const t = this.tooltips[id];
        if (!t || !triggerEl) return;
        const el = t.el;
        if (!el) return;

        el.style.visibility = 'hidden';
        el.style.display = 'block';

        const tooltipWidth = el.offsetWidth || 300;
        const tooltipHeight = el.offsetHeight || 200;
        const rect = triggerEl.getBoundingClientRect();

        let top = rect.top + rect.height / 2 - tooltipHeight / 2;
        let left = rect.right + 10;

        if (left + tooltipWidth > window.innerWidth) {
            left = rect.left - tooltipWidth - 10;
        }
        if (left < 10) {
            left = rect.left + (rect.width / 2) - (tooltipWidth / 2);
        }

        if (top + tooltipHeight > window.innerHeight - 10) top = window.innerHeight - 10 - tooltipHeight;
        if (top < 10) top = 10;

        el.style.left = `${left}px`;
        el.style.top = `${top}px`;
        zCounter++;
        el.style.zIndex = zCounter;
        el.style.visibility = 'visible';
    }
});

Alpine.store('invSearch', {
    query: '',
    index: [],
    matchedIds: new Set(),
    matchedBags: new Set(),

    init() {
        Alpine.effect(() => {
            this.search(this.query);
        });
    },

    load(items) {
        this.index = items;
    },

    search(q) {
        const ids = new Set();
        const bags = new Set();

        if (q.length >= 2) {
            const lower = q.toLowerCase();
            const isNumeric = /^\d+$/.test(q);

            for (const item of this.index) {
                const match = isNumeric
                    ? String(item.id) === q
                    : item.name.toLowerCase().includes(lower);

                if (match) {
                    ids.add(item.id);
                    // When an aug matches, also highlight its parent item
                    if (item.parentId) {
                        ids.add(item.parentId);
                    }
                    if (item.bagSlot !== null) {
                        bags.add(item.bagSlot);
                    }
                }
            }
        }

        this.matchedIds = ids;
        this.matchedBags = bags;
        this._applyHighlights();
    },

    _applyHighlights() {
        document.querySelectorAll('[data-inv-highlight]').forEach(el => {
            el.removeAttribute('data-inv-highlight');
        });

        if (this.matchedIds.size === 0 && this.matchedBags.size === 0) return;

        for (const id of this.matchedIds) {
            document.querySelectorAll(`[data-inv-item-id="${id}"]`).forEach(el => {
                el.setAttribute('data-inv-highlight', 'item');
            });
        }

        for (const bagSlot of this.matchedBags) {
            document.querySelectorAll(`[data-inv-bag-slot="${bagSlot}"]`).forEach(el => {
                el.setAttribute('data-inv-highlight', 'bag');
            });
        }
    },

    clear() {
        this.query = '';
    },

    isActive() {
        return this.query.length >= 2;
    }
});

window.Alpine = Alpine
Alpine.start()

document.body.addEventListener('click', () => {
    const ttStore = Alpine.store ? Alpine.store('tooltip') : null;
    if (ttStore && typeof ttStore.closeAllUnlockedExcept === 'function') {
        ttStore.closeAllUnlockedExcept(null);
    }

    const tzStore = Alpine.store ? Alpine.store('tooltipz') : null;
    if (tzStore && typeof tzStore.hideTooltip === 'function') {
        tzStore.hideTooltip();
    }
});

window.addEventListener('resize', () => {
    if (window.Alpine) {
        const tt = Alpine.store('tooltip');
        if (tt && typeof tt.hideAll === 'function') {
            tt.hideAll();
        }
    }

    try {
        window.dispatchEvent(new Event('closeAllBags'));
    } catch (e) {

    }
});

document.addEventListener('mousemove', (e) => {
    if (!tooltipDrag.id) return;
    const store = Alpine.store('tooltip');
    const t = store.tooltips[tooltipDrag.id];
    if (!t || !t.el) return;
    const el = t.el;
    const w = el.offsetWidth || 300;
    const h = el.offsetHeight || 200;
    let newLeft = e.clientX - tooltipDrag.offsetX;
    let newTop = e.clientY - tooltipDrag.offsetY;
    newLeft = Math.max(0, Math.min(newLeft, window.innerWidth - w));
    newTop = Math.max(0, Math.min(newTop, window.innerHeight - h));
    el.style.left = `${newLeft}px`;
    el.style.top = `${newTop}px`;
});

document.addEventListener('mouseup', () => {
    if (!tooltipDrag.id) return;
    tooltipDrag.id = null;
});
