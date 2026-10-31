<script setup>
import { onBeforeUnmount, onMounted, reactive, ref } from 'vue';

const props = defineProps({
    endpoint: { type: String, required: true },
    listingUrl: { type: String, required: true },
    favoriteUrl: { type: String, required: true },
    csrfToken: { type: String, required: true },
    cities: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({}) },
    initial: { type: Object, default: () => ({ data: [], total: 0, current_page: 1, last_page: 1 }) },
    translations: { type: Object, default: () => ({}) },
    locale: { type: String, default: 'en' },
    isAuthenticated: { type: Boolean, default: false },
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
const favoriteIds = ref(new Set((props.initial.data || [])
    .filter((property) => property.is_favorite)
    .map((property) => property.id)));
const pendingFavoriteIds = ref(new Set());
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
        const updatedFavorites = new Set(favoriteIds.value);
        payload.data.forEach((property) => {
            if (property.is_favorite) updatedFavorites.add(property.id);
            else updatedFavorites.delete(property.id);
        });
        favoriteIds.value = updatedFavorites;
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

function isFavorite(propertyId) {
    return favoriteIds.value.has(propertyId);
}

async function toggleFavorite(propertyId) {
    if (!props.isAuthenticated) {
        window.alert(text('favorite_register_prompt'));
        return;
    }

    if (pendingFavoriteIds.value.has(propertyId)) return;

    const wasFavorite = isFavorite(propertyId);
    const pendingIds = new Set(pendingFavoriteIds.value);
    pendingIds.add(propertyId);
    pendingFavoriteIds.value = pendingIds;

    try {
        const response = await fetch(`${props.favoriteUrl}/${encodeURIComponent(propertyId)}/favorite`, {
            method: wasFavorite ? 'DELETE' : 'PUT',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': props.csrfToken,
            },
        });
        if (!response.ok) throw new Error('Could not update favorite.');

        const updatedFavorites = new Set(favoriteIds.value);
        if (wasFavorite) updatedFavorites.delete(propertyId);
        else updatedFavorites.add(propertyId);
        favoriteIds.value = updatedFavorites;
    } catch {
        window.alert(text('favorite_error'));
    } finally {
        const currentPendingIds = new Set(pendingFavoriteIds.value);
        currentPendingIds.delete(propertyId);
        pendingFavoriteIds.value = currentPendingIds;
    }
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
    <div class="mx-auto min-h-[60vh] w-full max-w-[1160px] px-[22px]">
        <div class="mb-[26px] flex items-end justify-between max-[800px]:block">
            <div><span
                    class="inline-block rounded-full bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{
                    text('brand') }}</span>
                <h1 class="mb-1 mt-[8px] text-[34px]">{{ text('title') }}</h1>
                <p class="m-0 text-[var(--muted)]">{{ text('total', { count: formatPrice(total) }) }}</p>
            </div><a
                class="max-[800px]:mt-4 inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white"
                href="/auth">{{ text('list_free') }}</a>
        </div>

        <form
            class="mb-7 grid grid-cols-[minmax(260px,1.6fr)_170px_170px_auto] gap-[10px] rounded-[14px] border border-[#e0ebe5] bg-white p-3 shadow-[0_8px_24px_rgba(23,78,56,0.07)] max-[900px]:grid-cols-2 max-[560px]:grid-cols-1"
            @submit.prevent="applyFilters">
            <div
                class="flex items-center gap-2 rounded-[10px] border border-[#dbe7e1] px-3 text-[var(--green)] max-[900px]:col-span-full max-[560px]:col-auto">
                <span aria-hidden="true">⌕</span><input class="w-full border-0 p-3 font-[inherit] outline-0"
                    v-model="form.neighborhood" name="neighborhood" :placeholder="text('search_placeholder')"
                    @input="searchNeighborhood"></div>
            <select class="w-full rounded-[10px] border border-[#dbe7e1] bg-white px-3 py-2 font-[inherit]"
                v-model="form.purpose" name="purpose" :aria-label="text('transaction_type')" @change="applyFilters">
                <option value="">{{ text('all_transactions') }}</option>
                <option value="rent">{{ text('rent') }}</option>
                <option value="sale">{{ text('sale') }}</option>
            </select>
            <select class="w-full rounded-[10px] border border-[#dbe7e1] bg-white px-3 py-2 font-[inherit]"
                v-model="form.city" name="city" :aria-label="text('city')" @change="applyFilters">
                <option value="">{{ text('all_cities') }}</option>
                <option v-for="city in cities" :key="city" :value="city">{{ text(`city_${city.toLowerCase()}`) }}
                </option>
            </select>
            <button
                class="whitespace-nowrap inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white"
                type="submit">{{ text('search') }}</button>
        </form>

        <div class="grid grid-cols-[280px_minmax(0,1fr)] items-start gap-[26px] max-[900px]:grid-cols-1">
            <aside class="sticky top-5 rounded-[15px] border border-[#e0ebe5] bg-white p-5 max-[900px]:static">
                <div class="mb-1 flex items-center justify-between border-b border-[#edf2ef] pb-4">
                    <h2 class="m-0 text-[17px]">{{ text('filters') }}</h2><button
                        class="cursor-pointer border-0 bg-transparent p-0 font-[inherit] text-[11px] text-[var(--green)]"
                        type="button" @click="clearFilters">{{ text('clear') }}</button>
                </div>
                <div class="border-b border-[#edf2ef] py-4"><label class="mb-[9px] block text-xs font-bold"
                        for="filter-category">{{ text('property_type') }}</label><select
                        class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                        id="filter-category" v-model="form.category" @change="applyFilters">
                        <option value="">{{ text('all') }}</option>
                        <option value="residential">{{ text('residential') }}</option>
                        <option value="commercial">{{ text('commercial') }}</option>
                    </select></div>
                <div class="border-b border-[#edf2ef] py-4"><label class="mb-[9px] block text-xs font-bold">{{
                        text('price_range') }}</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input
                            class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                            v-model="form.min_price" type="number" min="0" :placeholder="text('from')"
                            :aria-label="text('minimum_price')" @change="applyFilters">
                        <input
                            class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                            v-model="form.max_price" type="number" min="0" :placeholder="text('to')"
                            :aria-label="text('maximum_price')" @change="applyFilters">
                    </div>
                </div>
                <div class="border-b border-[#edf2ef] py-4"><label class="mb-[9px] block text-xs font-bold">{{
                        text('area_range') }}</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input
                            class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                            v-model="form.min_area" type="number" min="0" :placeholder="text('from')"
                            :aria-label="text('minimum_area')" @change="applyFilters">
                        <input
                            class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                            v-model="form.max_area" type="number" min="0" :placeholder="text('to')"
                            :aria-label="text('maximum_area')" @change="applyFilters">
                    </div>
                </div>
                <div class="border-b border-[#edf2ef] py-4"><label class="mb-[9px] block text-xs font-bold"
                        for="filter-bedrooms">{{ text('bedrooms') }}</label><select
                        class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                        id="filter-bedrooms" v-model="form.bedrooms" @change="applyFilters">
                        <option value="">{{ text('any_number') }}</option>
                        <option v-for="n in [1, 2, 3, 4, 5]" :key="n" :value="n">{{ text('bedroom_count', {
                            count: `${n}${n
                            === 5 ? '+' : ''}` }) }}</option>
                    </select></div>
                <div class="border-b border-[#edf2ef] py-4"><label class="mb-[9px] block text-xs font-bold"
                        for="filter-bathrooms">{{ text('bathrooms') }}</label><select
                        class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                        id="filter-bathrooms" v-model="form.bathrooms" @change="applyFilters">
                        <option value="">{{ text('any_number') }}</option>
                        <option v-for="n in [1, 2, 3, 4]" :key="n" :value="n">{{ n }}{{ n === 4 ? '+' : '' }}</option>
                    </select></div>
                <div class="border-b border-[#edf2ef] py-4"><label class="mb-[9px] block text-xs font-bold"
                        for="filter-floor">{{ text('floor') }}</label><input
                        class="w-full rounded-lg border border-[#dbe7e1] bg-white p-[10px] text-xs font-[inherit]"
                        id="filter-floor" v-model="form.floor" type="number" :placeholder="text('any_floor')"
                        @change="applyFilters"></div>
                <div class="border-b border-[#edf2ef] py-4"><label class="mb-[9px] block text-xs font-bold">{{
                        text('condition') }}</label>
                    <label class="my-[11px] block text-xs font-normal"><input class="ml-[7px] accent-[var(--green)]"
                            v-model="form.furnished" type="checkbox" @change="applyFilters"> {{ text('furnished')
                        }}</label>
                    <label class="my-[11px] block text-xs font-normal"><input class="ml-[7px] accent-[var(--green)]"
                            v-model="form.reward" type="checkbox" @change="applyFilters"> {{ text('reward') }}</label>
                </div>
                <button
                    class="mt-[17px] w-full inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white"
                    type="button" @click="applyFilters">{{ text('apply_filters') }}</button>
            </aside>

            <main class="property-results" :aria-busy="loading">
                <div class="mb-[14px] flex items-center gap-3 text-[13px] text-[var(--muted)] max-[560px]:flex-wrap">
                    <strong class="me-auto text-[var(--ink)]">{{ text('results', { count: formatPrice(total) })
                        }}</strong><label class="text-[11px]" for="property-sort">{{ text('sort_by') }}</label>
                    <select class="w-[150px] rounded-lg border border-[#dbe7e1] bg-white p-[9px] text-xs"
                        id="property-sort" v-model="form.sort" @change="applyFilters">
                        <option value="latest">{{ text('latest') }}</option>
                        <option value="price_low">{{ text('price_low') }}</option>
                        <option value="price_high">{{ text('price_high') }}</option>
                    </select>
                </div>
                <p v-if="error" class="rounded-[9px] bg-[#fff1f0] p-3 text-[#9b2c25]" role="alert">{{ error }} <button
                        class="cursor-pointer border-0 bg-transparent font-[inherit] text-inherit underline"
                        type="button" @click="applyFilters">{{ text('retry') }}</button></p>
                <div class="flex flex-col gap-[14px] transition-opacity duration-200"
                    :class="{ 'pointer-events-none opacity-50': loading }" aria-live="polite">
                    <article v-for="property in results" :key="property.id" dir="ltr"
                        class="relative grid min-h-[190px] grid-cols-[250px_minmax(0,1fr)] overflow-hidden rounded-[14px] border border-[#e0ebe5] bg-white transition-[transform,box-shadow] duration-200 hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(23,78,56,0.08)] max-[900px]:grid-cols-[190px_1fr] max-[560px]:grid-cols-1">
                        <a :href="property.url"
                            class="absolute inset-0 z-10 rounded-[14px] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--green)]">
                            <span class="sr-only">{{ property.title }}</span>
                        </a>
                        <div
                            class="pointer-events-none relative grid min-h-[190px] place-items-center overflow-hidden bg-[linear-gradient(135deg,#c5e4d5,#edf7f1)] text-[#54816e] max-[560px]:min-h-[165px]">
                            <img class="h-full w-full object-cover" v-if="property.image" :src="property.image"
                                :alt="property.title" loading="lazy" decoding="async"><span v-else>{{
                                text('property_image') }}</span>
                            <span
                                class="absolute right-3 top-3 rounded-[7px] bg-white px-[9px] py-[5px] text-[11px] font-bold text-[var(--green)]">{{
                                    property.purpose === 'rent' ? text('rent') : text('sale') }}</span>
                        </div>
                        <div dir="rtl" class="pointer-events-none flex flex-col p-[18px_20px] text-right">
                            <div class="flex items-start justify-between gap-2 text-[11px]">
                                <span class="text-[var(--muted)]">{{ text(`city_${property.city.toLowerCase()}`) }} ·
                                    {{ property.neighborhood }}</span>
                                <button
                                    class="property-favorite pointer-events-auto relative z-20 cursor-pointer border-0 bg-transparent p-0 text-[22px] leading-none text-[#8fa89d] disabled:cursor-wait disabled:opacity-60"
                                    :class="{ 'text-[#c45c63]': isFavorite(property.id) }" type="button"
                                    :disabled="pendingFavoriteIds.has(property.id)"
                                    :aria-label="text(isFavorite(property.id) ? 'favorite_remove' : 'favorite_add', { property: property.title })"
                                    :aria-pressed="isFavorite(property.id)" @click="toggleFavorite(property.id)">
                                    {{ isFavorite(property.id) ? '♥' : '♡' }}
                                </button>
                            </div>
                            <h2 class="my-[13px] mb-3 text-lg">{{ property.title }}</h2>
                            <div class="flex flex-wrap gap-4 text-[11px] text-[var(--muted)] max-[560px]:gap-2"><span>⌂
                                    {{ property.bedrooms ?? '—' }} {{ text('bedroom_unit') }}</span><span>▣ {{
                                    property.area ?? '—' }} {{ text('area_unit') }}</span><span>♧ {{ property.furnished
                                        ? text('furnished') : text('unfurnished') }}</span></div>
                            <div class="mt-auto flex items-end justify-between pt-[18px]"><strong
                                    class="text-[19px] text-[var(--green)]">{{ formatPrice(property.price) }} {{
                                    property.currency }}</strong><small class="text-[11px] text-[var(--muted)]">{{
                                    text('owner_prefix') }} {{ property.owner || text('owner') }}</small></div>
                        </div>
                    </article>
                </div>
                <div v-if="!loading && !results.length"
                    class="rounded-[17px] border border-[#e5ece8] bg-white p-[45px] text-center">
                    <h3>{{ text('no_results') }}</h3>
                    <p class="text-[var(--muted)]">{{ text('empty_hint') }}</p>
                </div>
                <nav v-if="lastPage > 1" class="mt-6 flex items-center justify-center gap-[14px]"
                    :aria-label="text('results_pages')">
                    <button
                        class="cursor-pointer rounded-lg border border-[#dbe7e1] bg-white px-4 py-2 text-[var(--green)] disabled:cursor-not-allowed disabled:opacity-45"
                        type="button" :disabled="page <= 1 || loading" @click="goToPage(page - 1)">{{ text('previous')
                        }}</button>
                    <span>{{ text('page_of', { page, last: lastPage }) }}</span>
                    <button
                        class="cursor-pointer rounded-lg border border-[#dbe7e1] bg-white px-4 py-2 text-[var(--green)] disabled:cursor-not-allowed disabled:opacity-45"
                        type="button" :disabled="page >= lastPage || loading" @click="goToPage(page + 1)">{{
                        text('next') }}</button>
                </nav>
            </main>
        </div>
    </div>
</template>
