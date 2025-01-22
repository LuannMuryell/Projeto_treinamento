<template>
    <div v-if="links.length > 0">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, linkIndex) in links">
                <div
                    v-if="link.url === null"
                    :key="'null-' + linkIndex"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                >
                </div>
                <Link
                    v-else
                    :key="'link-' + linkIndex"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-gray-200 hover:text-gray-700
                    focus:border-blue-300 inline-block focus:text-blue-300"
                    :class="{ 'bg-blue-700 text-white': link.active }"
                    :href="link.url"
                >
                    <span v-html="link.label"></span>
                </Link>
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: Array,
});
</script>
