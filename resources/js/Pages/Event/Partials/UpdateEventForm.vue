<script setup>
import { ref } from "vue";
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

const event_img = () => {
    if (props.event.image_reference == null) return;
    let path = props.event.image_reference.split("/");
    path[0] = "storage";

    return "/" + path.join("/");
};
const form = useForm({
    title: props.event.title,
    type: props.event.type,
    content: props.event.content,
    start_time: props.event.start_time,
    end_time: props.event.end_time,
    venue: props.event.venue,
    image: event_img(),
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateEvent = (event) => {
    if (photoInput.value) {
        form.image = photoInput.value.files[0];
    }
    form.put(route("event.update", { event: event }), {
        errorBag: "updateEvent",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    Inertia.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <JetFormSection @submitted="updateEvent(props.event)">
        <template #title> Event Information </template>

        <template #description> Detail about your event/funding </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview" />

                <JetLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="!photoPreview" class="mt-2">
                    <img :src="
                        form.image
                            ? form.image
                            : `https://via.placeholder.com/150`
                    " :alt="form.title" class="w-full h-80 object-cover" />
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span class="block w-full h-80 bg-cover bg-no-repeat bg-center" :style="
                        'background-image: url(\'' + photoPreview + '\');'
                    " />
                </div>

                <JetSecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Select Promotional Photo
                </JetSecondaryButton>

                <!-- <JetSecondaryButton
                    v-if="form.image"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                >
                    Remove Photo
                </JetSecondaryButton> -->

                <JetInputError :message="form.errors.photo" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="title" value="Title" />
                <JetInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" autocomplete="title" />
                <JetInputError :message="form.errors.title" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="content" value="Content" />
                <textarea id="content" v-model="form.content" type="text"
                    class="mt-1 block w-full textarea textarea-bordered" autocomplete="content" />
                <JetInputError :message="form.errors.content" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="start_time" value="Start Time" />
                <Datepicker v-model="form.start_time" />
                <JetInputError :message="form.errors.start_time" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="venue" value="Venue" />
                <JetInput id="venue" v-model="form.venue" type="text" class="mt-1 block w-full" />
                <JetInputError :message="form.errors.venue" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </JetActionMessage>

            <JetButton :class="{ 'loading mr-2': form.processing }" :disabled="form.processing" class="btn-block">
                Save
            </JetButton>
        </template>
    </JetFormSection>
</template>
