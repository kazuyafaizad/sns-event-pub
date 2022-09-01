<script>
import Layout from "@/Layouts/AppLayout.vue";
import moment from "moment";
import FAB from '@/Components/FAB.vue';

export default {
    props: {
        events: Object,
    },

    components: { Layout, FAB },

    data() {
        return {
            showEventLoader: false,
            showNoMoreEvents: false,
            allEvents: this.events.data,
            initialUrl: this.$page.url,
        };
    },

    created: function () {
        this.moment = moment;
    },

    mounted() {
        const observer = new IntersectionObserver((entries) =>
            entries.forEach(
                (entry) => entry.isIntersecting && this.loadMoreEvents(),
                {
                    rootMargin: "-300px 0px 0px 0px",
                }
            )
        );

        observer.observe(this.$refs.loadMoreIntersect);
    },

    methods: {
        loadMoreEvents() {
            if (this.events.next_page_url !== null) {
                this.showEventLoader = true;
                this.$inertia.get(
                    this.events.next_page_url,
                    {},
                    {
                        preserveState: true,
                        preserveScroll: true,
                        only: ["events"],
                        onSuccess: () => {
                            this.allEvents = [
                                ...this.allEvents,
                                ...this.events.data,
                            ];
                            window.history.replaceState(
                                {},
                                this.$page.title,
                                this.initialUrl
                            );
                        },
                    }
                );
            } else {
                this.showEventLoader = false;
                this.showNoMoreEvents = true;
                // this.events = [];
            }
        },

        source(src) {
            let path = src.split("/");
            path[0] = "storage";

            return "/" + path.join("/");
        },

        goToViewPage(data) {
            // window.open(
            //     route("public.event.show", { event: data.slug }),
            //     "_blank"
            // );
            this.$inertia.get(route("public.event.show", { event: data.slug }))
        },

        share(data) {
            let url = route("public.event.show", { event: data.slug });

            navigator.clipboard.writeText(url).then(function () {
                alert('URL Copied!');
            }, function () {
                alert('Copy error')
            });
        }
    },
};
</script>

<template>
    <Layout title="Event / Donate happening">

        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Event Happening</h2>
            <div class="form-control ml-4">
                <input type="text" placeholder="Search" class="input input-sm input-bordered" />
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-full ">

            <div v-for="event in allEvents" :key="event.id" class="hero bg-neutral">
                <div class="hero-content flex-col lg:flex-row text-neutral-content w-full justify-center">
                    <img v-if="event.image_reference" :src="source(event.image_reference)" class="w-full max-w-sm " />
                    <div v-else class="w-full max-w-sm "></div>

                    <div class="w-full text-center">
                        <h1 class="text-5xl  font-bold">{{ event.title }}</h1>

                        <div class="py-6 text-xl text-center flex justify-center">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                            </svg>
                                        </th>
                                        <th>
                                            {{ event.venue }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                                                <path
                                                    d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z" />
                                                <path
                                                    d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z" />
                                            </svg>
                                        </th>
                                        <th>
                                            {{ event.start_time }}
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                        <div class="btn-group w-full justify-center">
                            <button class="btn btn-primary" @click="goToViewPage(event)">
                                {{ event.type == 1 ? "Event" : "Donation" }}
                            </button>
                            <button class="btn btn-secondary" @click="share(event)">SHARE</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="relative py-3 mx-auto">
                <div v-show="showEventLoader">
                    <div class="text-center text-neutral-content animate-pulse">
                        <div class="flex-1 space-y-6 py-1 h-96">
                            <div class="h-2 bg-slate-700 rounded"></div>
                            <div class="space-y-3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                                    <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                                </div>
                                <div class="h-2 bg-slate-700 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-3  p-4 flex justify-center" v-show="showNoMoreEvents">
                    <p class="">End of event.</p>
                </div>
            </div>
        </div>
        <span ref="loadMoreIntersect"></span>
        <FAB />
    </Layout>
</template>
