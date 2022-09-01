<script>

export default {
    props: {
        event: Object,
        canLogin: Boolean,
        canRegister: Boolean,
    },
}
</script>
<template>
    <div class="navbar bg-base-100">
        <div class="navbar-start"></div>
        <div class="navbar-center"></div>
        <div class="navbar-end">
            <div v-if="canLogin" class="fixed top-0 right-0 px-6 py-4 sm:block lg:flex">
                <Link v-if="$page.props.user" :href="route('home')" class="text-sm underline">
                Home
                </Link>

                <template v-else>
                    <Link :href="route('login')" class="text-sm underline">
                    Log in
                    </Link>

                    <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm underline">
                    Register
                    </Link>
                </template>
            </div>
        </div>
    </div>
    <slot></slot>
</template>
