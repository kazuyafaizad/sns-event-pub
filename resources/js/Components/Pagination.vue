<template>
    <div v-if="links.length > 3">
        <div class="btn-group">
            <template v-for="(link, p) in links" :key="p">
                <div
                    v-if="link.url === null"
                    class="btn btn-outline"
                    v-html="link.label"
                />
                <Link
                    preserve-scroll
                    v-else
                    class="btn btn-outline"
                    :class="{ 'btn btn-active btn-outline': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
export default {
    props: {
        links: Array
    },
    components: {
        Link
    }
}
</script>
