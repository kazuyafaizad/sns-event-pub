<script>
import Layout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import EventForm from "./Partials/CreateEventForm.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";

export default {
    components: {
        Layout,
        Link,
        EventForm,
        JetSectionBorder,
    },

    props: {
        event: Object,
        canLogin: Boolean,
        canRegister: Boolean,
    },
};
</script>

<template>
    <Layout title="New Event">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">New</h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div>
                <EventForm />
                <JetSectionBorder />
            </div>
        </div>
    </Layout>
</template>
