<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? "block pl-3 pr-4 py-2 border-l-4 border-primary text-base font-medium text-primary-content bg-primary focus:outline-none focus:bg-primary-focus transition"
        : "block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium transition";
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-left">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
