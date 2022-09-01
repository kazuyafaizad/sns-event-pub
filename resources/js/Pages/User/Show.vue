<script setup>
import Layout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination";
</script>

<template>
    <Layout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Registered Users
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        <tr v-for="(user, i) in $page.props.users.data" :key="user.id">
                            <td>{{ i + 1 }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <Pagination class="mt-6" :links="$page.props.users.links" />
            </div>
        </div>
    </Layout>
</template>
