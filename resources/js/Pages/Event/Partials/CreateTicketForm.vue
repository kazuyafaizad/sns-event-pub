<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const props = defineProps({
    event: Object,
});
const form = useForm({
    event_id: props.event.id,
    title: "",
    amount: "",
    available_from: null,
    available_to: null,
    price: "",
});

const createTicket = () => {
    form.post(route("ticket.store"), {
        errorBag: "createTicket",
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="createTicket">
        <template #title> Ticket Information </template>

        <template #description> Add ticket selection here </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="title" value="Title" />
                <JetInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" autocomplete="title" />
                <JetInputError :message="form.errors.title" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="amount" value="Available Seat" />
                <JetInput id="amount" v-model="form.amount" type="number" class="mt-1 block w-full"
                    autocomplete="amount" />
                <JetInputError :message="form.errors.amount" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="available_from" value="Available From" />
                <Datepicker :enableTimePicker="false" id="available_from" v-model="form.available_from" type="date"
                    class="mt-1 block w-full" autocomplete="available_from" />
                <JetInputError :message="form.errors.available_from" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="available_to" value="Available To" />
                <Datepicker :enableTimePicker="false" id="available_to" v-model="form.available_to" type="date"
                    class="mt-1 block w-full" autocomplete="available_to" />
                <JetInputError :message="form.errors.available_to" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="price" value="Price" />
                <JetInput id="price" v-model="form.price" type="text" class="mt-1 block w-full" />
                <JetInputError :message="form.errors.price" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Created.
            </JetActionMessage>

            <JetButton :class="{ 'loading mr-2': form.processing }" :disabled="form.processing" class="btn-block">
                Create
            </JetButton>
        </template>
    </JetFormSection>
</template>
