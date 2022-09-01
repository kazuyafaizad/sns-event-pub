<script setup>
import Layout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import UpdateEventForm from "./Partials/UpdateEventForm.vue";
import CreateTicketForm from "./Partials/CreateTicketForm.vue";
import UpdateTicketForm from "./Partials/UpdateTicketForm.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";

defineProps({
    event: Object,
    tickets: Object,
});
</script>

<template>
    <Layout title="Update Event">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Update Event</h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div>
                <UpdateEventForm :event="event" />
                <JetSectionBorder />
            </div>
            <div>
                <template v-if="$page.props.tickets.length > 0">
                    <UpdateTicketForm v-for="ticket in $page.props.tickets" :key="ticket.id" :event="event"
                        :ticket="ticket" />
                </template><template v-else>
                    <CreateTicketForm :event="event" />
                </template>
                <JetSectionBorder />
            </div>
        </div>
    </Layout>
</template>
