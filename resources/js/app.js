document.addEventListener("DOMContentLoaded", () => {

    const navbar = document.getElementById("navbar");
    const sections = document.querySelectorAll("[data-theme]");

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                const theme = entry.target.dataset.theme;

                navbar.classList.remove("dark-mode", "light-mode");
                navbar.classList.add(`${theme}-mode`);

                const loginBtn = document.getElementById("loginBtn");
                if (loginBtn) {
                    loginBtn.classList.remove("dark-mode", "light-mode");
                    loginBtn.classList.add(`${theme}-mode`);
                }

            }

        });

    }, {
        rootMargin: "-10% 0px -80% 0px",
        threshold: 0
    });

    sections.forEach(section => observer.observe(section));

});

document.addEventListener('alpine:init', () => {
    Alpine.data('explorePage', (items = [], fallbackImage = '') => ({
        items: Array.isArray(items) ? items : [],
        fallbackImage,
        query: '',
        activeFilter: 'all',
        visibleCount: 4,
        expandedItems: {},
        filters: [
            { label: 'All tours', value: 'all' },
            { label: 'Asia', value: 'asia' },
            { label: 'Europe', value: 'europe' },
            { label: 'USA', value: 'usa' },
            { label: 'Adventure', value: 'adventure' },
            { label: 'Beach', value: 'beach' },
            { label: 'Culture', value: 'culture' },
            { label: 'Nature', value: 'nature' },
        ],

        init() {
            this.$watch('query', () => {
                this.visibleCount = 4;
            });

            this.$watch('activeFilter', () => {
                this.visibleCount = 4;
            });
        },

        setFilter(value) {
            this.activeFilter = value;
        },

        toggleReadMore(key) {
            const itemKey = String(key ?? '');
            this.expandedItems[itemKey] = !this.expandedItems[itemKey];
        },

        isExpanded(key) {
            return Boolean(this.expandedItems[String(key ?? '')]);
        },

        loadMore() {
            this.visibleCount = Math.min(this.visibleCount + 4, this.filteredItems.length);
        },

        normalized(value) {
            return (value ?? '').toString().toLowerCase();
        },

        matchesFilter(item) {
            const filter = this.normalized(this.activeFilter);

            if (filter === 'all') {
                return true;
            }

            const category = this.normalized(item.category);
            const region = this.normalized(item.region);
            const country = this.normalized(item.country);

            if (['asia', 'europe', 'usa'].includes(filter)) {
                return region === filter;
            }

            if (filter === 'adventure') {
                return category.includes('adventure') || category.includes('safari');
            }

            if (filter === 'beach') {
                return category.includes('beach') || category.includes('island');
            }

            if (filter === 'culture') {
                return category.includes('culture') || category.includes('heritage') || category.includes('romantic');
            }

            if (filter === 'nature') {
                return category.includes('nature') || category.includes('wildlife') || category.includes('mountain');
            }

            return category.includes(filter) || country.includes(filter);
        },

        matchesQuery(item) {
            const query = this.normalized(this.query);

            if (!query) {
                return true;
            }

            return this.normalized(item.search_text).includes(query);
        },

        imageFor(item, variant = 0) {
            if (!item) {
                return this.fallbackImage;
            }

            if (variant === 0) {
                return item.resolved_image || item.image || this.fallbackImage;
            }

            if (Array.isArray(item.gallery_images) && item.gallery_images[variant - 1]) {
                return item.gallery_images[variant - 1];
            }

            return item.resolved_image || item.image || this.fallbackImage;
        },

        formatPrice(value) {
            const raw = (value ?? '').toString().trim();

            if (!raw) {
                return '₹0';
            }

            if (raw.includes('₹')) {
                return raw;
            }

            const normalized = raw.replace(/^[$€£]/, '').trim();

            return `₹${normalized}`;
        },

        handleImageError(event) {
            const image = event.target;

            if (image.dataset.fallback && image.src !== image.dataset.fallback) {
                image.src = image.dataset.fallback;
            }
        },

        truncate(value, limit = 120) {
            const text = (value ?? '').toString().trim();

            if (text.length <= limit) {
                return text;
            }

            return `${text.slice(0, limit).trim()}...`;
        },

        get filteredItems() {
            return this.items.filter((item) => this.matchesFilter(item) && this.matchesQuery(item));
        },

        get visibleItems() {
            return this.filteredItems.slice(0, this.visibleCount);
        },

        get stackedItems() {
            const items = this.filteredItems.slice(4, 6);

            return items.length ? items : this.filteredItems.slice(0, 2);
        },

        get featuredItem() {
            return this.filteredItems.find((item) => item.featured) || this.filteredItems[0] || null;
        },

        get canSeeMore() {
            return this.filteredItems.length > this.visibleCount;
        },

        get resultSummary() {
            if (!this.query && this.activeFilter === 'all') {
                return 'Discover our handpicked selection of tours, carefully chosen for your perfect getaway.';
            }

            if (!this.filteredItems.length) {
                return 'No destinations matched your search.';
            }

            const queryLabel = this.query ? ` for "${this.query}"` : '';
            const filterLabel = this.activeFilter !== 'all' ? ` in ${this.activeFilter}` : '';

            return `Showing ${Math.min(this.visibleCount, this.filteredItems.length)} of ${this.filteredItems.length} destinations${filterLabel}${queryLabel}.`;
        },
    }));
});