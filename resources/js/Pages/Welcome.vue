
<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Link,
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
});
</script>

<style scoped>
.background {
    background: #fff url("/img/splash.jpg") no-repeat right top;
    background-size: cover;
}
</style>


<template>
    <div class="justify-center items-center flex background min-h-screen">
        <div class="flex flex-col justify-center items-center">
            <h1 class="text-7xl font-semibold drop-shadow-xl mx-3 text-white">
                SNS EVENT
            </h1>
            <div v-if="canLogin" class="px-6 py-4 block">
                <Link v-if="$page.props.user" :href="route('home')" class="btn btn-primary btn-lg"> Start </Link>
                <template v-else>
                    <div class="btn-group">
                        <Link :href="route('login')" class="btn btn-primary">Login</Link>
                        <Link v-if="canRegister" :href="route('register')" class="btn btn-secondary">Register</Link>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

