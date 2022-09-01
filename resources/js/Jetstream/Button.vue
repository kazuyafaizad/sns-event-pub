<script setup>
defineProps({
    type: {
        type: String,
        default: "submit",
    },
});
</script>

<template>
    <button :type="type" class="btn btn-sm btn-accent disabled:opacity-25">
        <slot />
    </button>
</template>
