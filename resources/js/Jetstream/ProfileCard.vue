<script setup>
import JetApplicationLogo from "@/Jetstream/ApplicationLogo.vue";
</script>

<template>
    <div class="p-6 sm:px-20 bg-secondary text-secondary-content justify-center items-center flex flex-col rounded-xl">
        <img class="h-32 w-32 rounded-full object-cover" :src="$page.props.user.profile_photo_url"
            :alt="$page.props.user.name" />

        <div class="mt-4">
            <div class="rating">
                <template v-for="i in 5" :key="i">
                    <template v-if="i <= 5">
                        <input type="radio" name="rating-2" class="mask mask-star-2 bg-accent" checked disabled />
                    </template>
                    <template v-else>
                        <input type="radio" name="rating-2" class="mask mask-star-2 bg-accent" disabled />
                    </template>
                </template>
            </div>
        </div>
        <div class="mt-4 flex gap-4">
            <div>
                <div class="mt-4 text-2xl">{{ $page.props.user.name }}</div>
                <div class="text-base">{{ $page.props.user.email }}</div>
            </div>
            <div class="avatar">
                <div class="w-24 mask mask-hexagon bg-accent text-accent-content font-bold">
                    <h1 class="flex items-center justify-center h-full">
                        TIER
                        {{ $page.props.user.tier ? $page.props.user.tier : 0 }}
                    </h1>
                </div>
            </div>
        </div>



    </div>
</template>
