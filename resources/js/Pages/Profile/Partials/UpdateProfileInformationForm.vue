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

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    phone_number: props.user.profile.mobile_number,
    address1: props.user.profile.address1,
    address2: props.user.profile.address2,
    postcode: props.user.profile.postcode,
    city: props.user.profile.city,
    state: props.user.profile.state,
    country: props.user.profile.country,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
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
    <JetFormSection @submitted="updateProfileInformation">
        <template #title> Profile Information </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview" />

                <JetLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="!photoPreview" class="mt-2">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover" />
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" :style="
                        'background-image: url(\'' + photoPreview + '\');'
                    " />
                </div>

                <JetSecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </JetSecondaryButton>

                <JetSecondaryButton v-if="user.profile_photo_path" type="button" class="mt-2"
                    @click.prevent="deletePhoto">
                    Remove Photo
                </JetSecondaryButton>

                <JetInputError :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Name" />
                <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" autocomplete="name" />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="email" value="Email" />
                <JetInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" />
                <JetInputError :message="form.errors.email" class="mt-2" />

                <div v-if="
                    $page.props.jetstream.hasEmailVerification &&
                    user.email_verified_at === null
                ">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link :href="route('verification.send')" method="post" as="button" class="underline  hover:"
                            @click.prevent="sendEmailVerification">
                        Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email
                        address.
                    </div>
                </div>
            </div>

            <!-- Mobile Number -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="phone_number" value="Mobile Number" />
                <JetInput id="phone_number" v-model="form.phone_number" type="text" class="mt-1 block w-full"
                    autocomplete="phone_number" />
                <JetInputError :message="form.errors.phone_number" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="address1" value="Address 1" />
                <JetInput id="address1" v-model="form.address1" type="text" class="mt-1 block w-full"
                    autocomplete="address1" />
                <JetInputError :message="form.errors.address1" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="address2" value="Address 2" />
                <JetInput id="address2" v-model="form.address2" type="text" class="mt-1 block w-full"
                    autocomplete="address2" />
                <JetInputError :message="form.errors.address2" class="mt-2" />
            </div>

            <div class="col-span-2"></div>

            <div class="col-span-6 sm:col-span-2">
                <JetLabel for="postcode" value="Postcode" />
                <JetInput id="postcode" v-model="form.postcode" type="text" class="mt-1 block w-full"
                    autocomplete="postcode" />
                <JetInputError :message="form.errors.postcode" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-2">
                <JetLabel for="city" value="City" />
                <JetInput id="city" v-model="form.city" type="text" class="mt-1 block w-full" autocomplete="city" />
                <JetInputError :message="form.errors.city" class="mt-2" />
            </div>


            <div class="col-span-2"></div>

            <div class="col-span-6 sm:col-span-2">
                <JetLabel for="state" value="State" />
                <JetInput id="state" v-model="form.state" type="text" class="mt-1 block w-full" autocomplete="state" />
                <JetInputError :message="form.errors.state" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-2">
                <JetLabel for="country" value="Country" />
                <JetInput id="country" v-model="form.country" type="text" class="mt-1 block w-full"
                    autocomplete="country" />
                <JetInputError :message="form.errors.country" class="mt-2" />
            </div>
            <div class="col-span-2"></div>



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
