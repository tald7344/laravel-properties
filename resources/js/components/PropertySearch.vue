<script setup>
import { onBeforeUnmount, onMounted, reactive, ref } from 'vue';

const props = defineProps({
    endpoint: { type: String, required: true },
    listingUrl: { type: String, required: true },
    cities: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({}) },
    initial: { type: Object, default: () => ({ data: [], total: 0, current_page: 1, last_page: 1 }) },
    translations: { type: Object, default: () => ({}) },
    locale: { type: String, default: 'en' },
});

const form = reactive({
    neighborhood: '', purpose: '', city: '', category: '', min_price: '', max_price: '',
    min_area: '', max_area: '', bedrooms: '', bathrooms: '', floor: '', furnished: false,
    reward: false, sort: 'latest',
    ...props.filters,
    furnished: props.filters.furnished === '1' || props.filters.furnished === true,
    reward: props.filters.reward === '1' || props.filters.reward === true,
});
const results = ref(props.initial.data || []);
const total = ref(props.initial.total || 0);
const page = ref(props.initial.current_page || 1);
const lastPage = ref(props.initial.last_page || 1);
const loading = ref(false);
const error = ref('');
let debounceTimer;
let controller;
let requestId = 0;

const queryParams = (targetPage = 1) => {
    const params = new URLSearchParams();
    Object.entries(form).forEach(([key, value]) => {
        if (value !== '' && value !== null && value !== false && value !== undefined) params.set(key, value);
    });
    if (targetPage > 1) params.set('page', targetPage);
    return params;
};

async function search(targetPage = 1, { updateUrl = true } = {}) {
    const currentRequest = ++requestId;
    controller?.abort();
    controller = new AbortController();
    loading.value = true;
    error.value = '';
    const params = queryParams(targetPage);

    try {
        const response = await fetch(`${props.endpoint}?${params.toString()}`, {
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            signal: controller.signal,
        });
        if (!response.ok) throw new Error(props.translations.load_error || 'Could not load properties. Please try again.');
        const payload = await response.json();
        if (currentRequest !== requestId) return;
        results.value = payload.data;
        total.value = payload.total;
        page.value = payload.current_page;
        lastPage.value = payload.last_page;
        if (updateUrl) {
            const query = params.toString();
            window.history.replaceState({}, '', `${props.listingUrl}${query ? `?${query}` : ''}`);
        }
    } catch (fetchError) {
        if (fetchError.name !== 'AbortError' && currentRequest === requestId) error.value = fetchError.message;
    } finally {
        if (currentRequest === requestId) loading.value = false;
    }
}

function applyFilters() {
    search(1);
}

function searchNeighborhood() {
    window.clearTimeout(debounceTimer);
    debounceTimer = window.setTimeout(applyFilters, 350);
}

function clearFilters() {
    Object.assign(form, {
        neighborhood: '', purpose: '', city: '', category: '', min_price: '', max_price: '',
        min_area: '', max_area: '', bedrooms: '', bathrooms: '', floor: '', furnished: false,
        reward: false, sort: 'latest',
    });
    applyFilters();
}

function restoreFromUrl() {
    const params = new URLSearchParams(window.location.search);
    Object.keys(form).forEach((key) => {
        form[key] = ['furnished', 'reward'].includes(key) ? params.get(key) === '1' : params.get(key) || (key === 'sort' ? 'latest' : '');
    });
    search(Number(params.get('page') || 1), { updateUrl: false });
}

function formatPrice(price) {
    return new Intl.NumberFormat(props.locale).format(price || 0);
}

function text(key, replacements = {}) {
    return Object.entries(replacements).reduce(
        (value, [name, replacement]) => value.replace(`:${name}`, replacement),
        props.translations[key] || key,
    );
}

function goToPage(nextPage) {
    if (nextPage >= 1 && nextPage <= lastPage.value) {
        search(nextPage);
        document.querySelector('.property-results')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

onMounted(() => window.addEventListener('popstate', restoreFromUrl));
onBeforeUnmount(() => {
    window.clearTimeout(debounceTimer);
    controller?.abort();
    window.removeEventListener('popstate', restoreFromUrl);
});
</script>

<template>
    <div class="wrap">
        <div class="properties-heading">
            <div><span class="tag">{{ text('brand') }}</span>
                <h1>{{ text('title') }}</h1>
                <p class="muted">{{ text('total', { count: formatPrice(total) }) }}</p>
            </div><a class="btn" href="/auth">{{ text('list_free') }}</a>
        </div>

        <form class="property-searchbar" @submit.prevent="applyFilters">
            <div class="search-main"><span aria-hidden="true">⌕</span><input v-model="form.neighborhood" name="neighborhood"
                :placeholder="text('search_placeholder')" @input="searchNeighborhood"></div>
            <select v-model="form.purpose" name="purpose" :aria-label="text('transaction_type')" @change="applyFilters">
                <option value="">{{ text('all_transactions') }}</option><option value="rent">{{ text('rent') }}</option><option value="sale">{{ text('sale') }}</option>
            </select>
            <select v-model="form.city" name="city" :aria-label="text('city')" @change="applyFilters">
                <option value="">{{ text('all_cities') }}</option><option v-for="city in cities" :key="city" :value="city">{{ text(`city_${city.toLowerCase()}`) }}</option>
            </select>
            <button class="btn" type="submit">{{ text('search') }}</button>
        </form>

        <div class="properties-layout">
            <aside class="property-filters">
                <div class="filter-heading"><h2>{{ text('filters') }}</h2><button class="filter-reset" type="button" @click="clearFilters">{{ text('clear') }}</button></div>
                <div class="filter-group"><label for="filter-category">{{ text('property_type') }}</label><select id="filter-category" v-model="form.category" @change="applyFilters">
                    <option value="">{{ text('all') }}</option><option value="residential">{{ text('residential') }}</option><option value="commercial">{{ text('commercial') }}</option>
                </select></div>
                <div class="filter-group"><label>{{ text('price_range') }}</label><div class="filter-row">
                    <input v-model="form.min_price" type="number" min="0" :placeholder="text('from')" :aria-label="text('minimum_price')" @change="applyFilters">
                    <input v-model="form.max_price" type="number" min="0" :placeholder="text('to')" :aria-label="text('maximum_price')" @change="applyFilters">
                </div></div>
                <div class="filter-group"><label>{{ text('area_range') }}</label><div class="filter-row">
                    <input v-model="form.min_area" type="number" min="0" :placeholder="text('from')" :aria-label="text('minimum_area')" @change="applyFilters">
                    <input v-model="form.max_area" type="number" min="0" :placeholder="text('to')" :aria-label="text('maximum_area')" @change="applyFilters">
                </div></div>
                <div class="filter-group"><label for="filter-bedrooms">{{ text('bedrooms') }}</label><select id="filter-bedrooms" v-model="form.bedrooms" @change="applyFilters">
                    <option value="">{{ text('any_number') }}</option><option v-for="n in [1,2,3,4,5]" :key="n" :value="n">{{ text('bedroom_count', { count: `${n}${n === 5 ? '+' : ''}` }) }}</option>
                </select></div>
                <div class="filter-group"><label for="filter-bathrooms">{{ text('bathrooms') }}</label><select id="filter-bathrooms" v-model="form.bathrooms" @change="applyFilters">
                    <option value="">{{ text('any_number') }}</option><option v-for="n in [1,2,3,4]" :key="n" :value="n">{{ n }}{{ n === 4 ? '+' : '' }}</option>
                </select></div>
                <div class="filter-group"><label for="filter-floor">{{ text('floor') }}</label><input id="filter-floor" v-model="form.floor" type="number" :placeholder="text('any_floor')" @change="applyFilters"></div>
                <div class="filter-group"><label>{{ text('condition') }}</label>
                    <label class="check"><input v-model="form.furnished" type="checkbox" @change="applyFilters"> {{ text('furnished') }}</label>
                    <label class="check"><input v-model="form.reward" type="checkbox" @change="applyFilters"> {{ text('reward') }}</label>
                </div>
                <button class="btn filter-submit" type="button" @click="applyFilters">{{ text('apply_filters') }}</button>
            </aside>

            <main class="property-results" :aria-busy="loading">
                <div class="results-toolbar"><strong>{{ text('results', { count: formatPrice(total) }) }}</strong><label class="sort-control" for="property-sort">{{ text('sort_by') }}</label>
                    <select id="property-sort" v-model="form.sort" @change="applyFilters">
                        <option value="latest">{{ text('latest') }}</option><option value="price_low">{{ text('price_low') }}</option><option value="price_high">{{ text('price_high') }}</option>
                    </select>
                </div>
                <p v-if="error" class="search-error" role="alert">{{ error }} <button type="button" @click="applyFilters">{{ text('retry') }}</button></p>
                <div class="property-list" :class="{ 'is-loading': loading }" aria-live="polite">
                    <a v-for="property in results" :key="property.id" class="property-result-card" :href="property.url">
                        <div class="property-thumb"><img v-if="property.image" :src="property.image" :alt="property.title" loading="lazy" decoding="async"><span v-else>{{ text('property_image') }}</span>
                            <span class="property-badge">{{ property.purpose === 'rent' ? text('rent') : text('sale') }}</span>
                        </div>
                        <div class="property-result-body"><div class="result-top"><span class="muted">{{ text(`city_${property.city.toLowerCase()}`) }} · {{ property.neighborhood }}</span><span class="save">♡</span></div>
                            <h2>{{ property.title }}</h2><div class="result-meta"><span>⌂ {{ property.bedrooms ?? '—' }} {{ text('bedroom_unit') }}</span><span>▣ {{ property.area ?? '—' }} {{ text('area_unit') }}</span><span>♧ {{ property.furnished ? text('furnished') : text('unfurnished') }}</span></div>
                            <div class="result-bottom"><strong>{{ formatPrice(property.price) }} {{ property.currency }}</strong><small>{{ text('owner_prefix') }} {{ property.owner || text('owner') }}</small></div>
                        </div>
                    </a>
                </div>
                <div v-if="!loading && !results.length" class="panel empty-properties"><h3>{{ text('no_results') }}</h3><p class="muted">{{ text('empty_hint') }}</p></div>
                <nav v-if="lastPage > 1" class="property-pagination" :aria-label="text('results_pages')">
                    <button type="button" :disabled="page <= 1 || loading" @click="goToPage(page - 1)">{{ text('previous') }}</button>
                    <span>{{ text('page_of', { page, last: lastPage }) }}</span>
                    <button type="button" :disabled="page >= lastPage || loading" @click="goToPage(page + 1)">{{ text('next') }}</button>
                </nav>
            </main>
        </div>
    </div>
</template>
