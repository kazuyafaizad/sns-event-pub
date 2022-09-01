<script setup>
import Layout from "@/Layouts/AppLayout.vue";
import ProfileCard from "@/Jetstream/ProfileCard.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination";
</script>

<template>
    <Layout title="Home">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Home</h2>
        </template>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-4 ">
                <ProfileCard />
                <div class="card rounded-none w-full bg-base-100 lg:col-span-2 max-h-96">
                    <div class="card-body">
                        <h2 class="card-title">Upgrade next tier</h2>
                        <ul class="steps steps-vertical">
                            <li class="step step-primary">Register</li>
                            <li class="step">Coming Soon..</li>
                            <li class="step">Coming Soon...</li>
                            <li class="step">Coming Soon...</li>
                            <li class="step">Coming Soon...</li>
                        </ul>
                    </div>
                </div>
            </div>

            <ul
                class="menu menu-vertical lg:menu-horizontal bg-neutral text-neutral-content mt-2 lg:mt-8 mb-4 mx-auto text-center shadow rounded-box p-2 lg:justify-center lg:items-center ">
                <li><a href="https://web.whatsapp.com/"><i class="bi bi-whatsapp mr-2"></i>Whatsapp</a></li>
                <li>

                    <Link :href="route('event.create')"><i class="bi bi-plus-lg mr-2"></i>New Event</Link>
                </li>
                <li>

                    <Link :href="route('users.index')"><i class="bi bi-people-fill mr-2"></i>Users</Link>
                </li>
            </ul>

            <div class="overflow-x-auto" v-if="$page.props.events.data.length > 0">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th></th>
                            <th>Event Name</th>
                            <th>Venue</th>
                            <th>Date/Time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        <tr v-for="(event, i) in $page.props.events.data" :key="event.id">
                            <td>{{ i + 1 }}</td>
                            <td>{{ event.title }}</td>
                            <td>{{ event.venue }}</td>
                            <td>{{ event.start_time }}</td>
                            <td>
                                <Link class="btn btn-primary btn-sm" :href="route('event.edit', event)">Manage Event
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <Pagination class="mt-6" :links="$page.props.events.links" />
            </div>
        </div>
    </Layout>
</template>
