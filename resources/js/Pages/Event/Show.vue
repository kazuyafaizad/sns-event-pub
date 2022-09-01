<script>
import Layout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Layout,
        Link,
    },



    props: {
        event: Object,
        canLogin: Boolean,
        canRegister: Boolean,
    },

    data() {
        return {
            ticketForm: this.$inertia.form({
                type: "",
                quantity: 1,
                total: 0,
                price: 0,
            }),
        };
    },

    methods: {
        total() {
            this.ticketForm.total =
                this.ticketForm.quantity * this.ticketForm.price;
        },
        changePrice() {
            this.ticketForm.price =
                this.event.tickets[this.$refs.ticket.value].price;
            this.total();
        },
        source(src) {
            if (src == null) return;
            let path = src.split("/");
            path[0] = "storage";

            return "/" + path.join("/");
        },
    },
};
</script>

<template>
    <Layout>
        <div class="flex flex-col lg:flex-row gap-2 w-full justify-space">
            <div class="hero bg-base-200">
                <div class="hero-content flex-col lg:flex-row">
                    <img :src="source(event.image_reference)" class="max-w-sm rounded-lg shadow-2xl w-full" />
                    <div>
                        <h1 class="text-5xl font-bold">{{ event.title }}</h1>
                        <div class="my-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="text-xl text-left">
                                            Start Date
                                        </th>
                                        <td class="text-2xl">
                                            {{ event.start_time }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-xl text-left">Venue</th>
                                        <td class="text-2xl">{{ event.venue }}</td>
                                    </tr>

                                    <tr>
                                        <th class="text-xl text-left">
                                            Organize By
                                        </th>
                                        <td class="text-2xl">
                                            {{ event.user.name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="py-6">{{ event.content }}</p>
                    </div>
                </div>
            </div>
            <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
                <div class="card-body" v-if="event.tickets.length > 0">
                    <h3>Buy Tickets</h3>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Type</span>
                        </label>
                        <select v-model="ticketForm.type" class="input input-bordered" ref="ticket"
                            @change="changePrice()">
                            <option v-for="(ticket, i) in event.tickets" :key="ticket.id" :value="i">
                                {{ ticket.title }}
                            </option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Quantity</span>
                        </label>
                        <input type="text" class="input input-bordered" v-model="ticketForm.quantity"
                            @change="changePrice()" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Price</span>
                        </label>
                        MYR{{ ticketForm.price }}
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Total</span>
                        </label>
                        MYR{{ ticketForm.total }}
                    </div>
                    <div class="form-control mt-6">
                        <button class="btn btn-primary">Buy</button>
                    </div>
                </div>

                <div class="card-body" v-else>
                    <div class="alert alert-warning">
                        We're sorry, but there are no tickets available
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
