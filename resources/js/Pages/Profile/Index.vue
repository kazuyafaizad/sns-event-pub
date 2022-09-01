<script setup>
import Layout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

const switchToTeam = (team) => {
    Inertia.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    Inertia.post(route("logout"));
};
</script>

<template>
    <Layout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Profile</h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex items-center px-4 justify-center items-center">
                <div v-if="
                    $page.props.jetstream.managesProfilePhotos
                " class="shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name" />
                </div>

                <div>
                    <div class="font-medium text-base">
                        {{ $page.props.user.name }}
                    </div>
                    <div class="font-medium text-sm ">
                        {{ $page.props.user.email }}
                    </div>
                </div>
            </div>

            <ul class="mt-4 menu bg-neutral rounded-box">
                <li>
                    <Link :href="route('profile.show')" :active="route().current('profile.show')">
                    Profile
                    </Link>
                </li>

                <li v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                    <Link :active="route().current('api-tokens.index')">
                    API Tokens
                    </Link>
                </li>
                <form method="POST" @submit.prevent="logout">
                    <li>
                        <!-- Authentication -->

                        <button>
                            Log Out
                        </button>

                    </li>
                </form>

                <!-- Team Management -->
                <template v-if="$page.props.jetstream.hasTeamFeatures">

                    <div class="block px-4 py-2 text-xs">
                        Manage Team
                    </div>

                    <!-- Team Settings -->
                    <li>
                        <Link :href="
                            route(
                                'teams.show',
                                $page.props.user.current_team
                            )
                        " :active="route().current('teams.show')">
                        Team Settings
                        </Link>
                    </li>


                    <li v-if="$page.props.jetstream.canCreateTeams">
                        <Link :href="route('teams.create')" :active="route().current('teams.create')">
                        Create New Team
                        </Link>
                    </li>


                    <div class="border-t border-gray-200" />

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs">
                        Switch Teams
                    </div>

                    <template v-for="team in $page.props.user.all_teams" :key="team.id">
                        <li>
                            <form @submit.prevent="switchToTeam(team)">
                                <button>
                                    <div class="flex items-center">
                                        <svg v-if="
                                            team.id ==
                                            $page.props.user
                                                .current_team_id
                                        " class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>{{ team.name }}</div>
                                    </div>
                                </button>
                            </form>
                        </li>

                    </template>
                </template>
            </ul>
        </div>
    </Layout>
</template>
