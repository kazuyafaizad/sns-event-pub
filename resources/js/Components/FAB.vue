<script setup>

import { Head, Link } from "@inertiajs/inertia-vue3";

</script>
<template>
    <Link :href="route('event.create')"
        class="fixed z-30 inset-x-1/2  bottom-16 bg-secondary  w-12 h-12 rounded-full drop-shadow-lg flex justify-center items-center text-white text-4xl -translate-x-1/2">
    <i class="bi bi-plus-lg text-white"></i>
    </Link>

</template>
