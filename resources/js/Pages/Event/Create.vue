<template>
    <div>
        <BreezeAuthenticatedLayout>
            <Head title="Create Event"/>

            <form @submit.prevent="submit">
                <div class="mb-2">
                    <div class="pb-1 mx-auto sm:mx-24 md:mx-30 lg:mx-48 xl:mx-60 2xl:mx-80">


                        <div class="my-5 max-2 overflow-hidden rounded-xl font-bold">
                            <h1 class="text-4xl p-2" style="font-family: 'Poppins', sans-serif;">
                                <!--                        DASHBOARD-->
                                Create an Event
                            </h1>

                            <inertia-link :href="route('event.show')"
                                          class="px-4 font-medium">
                                SEE ALL
                            </inertia-link>

                        </div>


                        <BreezeInput id="title" type="text" class="mt-1 block w-full bg-gray-100 "
                                     style="border: none !important;"
                                     v-model="form.title"
                                     placeholder="Name"
                                     required autofocus autocomplete="title"/>

                        <BreezeInput id="description" type="text" class="mt-4 pb-10 block w-full bg-gray-100 "
                                     style="border: none !important;"
                                     v-model="form.description"
                                     placeholder="Description"
                                     required autofocus autocomplete="description"/>
                    </div>
                </div>
                <div class="pb-1 mx-auto sm:mx-24 md:mx-30 lg:mx-72 xl:mx-60 2xl:mx-80">

                    <input
                        type="file"
                        @change="previewAvatar"
                        ref="photo"
                        class="
                                        w-full
                                        px-4
                                        py-2
                                        mt-2
                                        rounded-md
                                        focus:outline-none
                                        focus:ring-1
                                        focus:ring-blue-600
                                    "
                    />

                    <div class="flex flex-col justify-center items-center">
                        <img
                            v-if="url"
                            :src="url"
                            class="w-1/2 mt-4"
                        />
                    </div>
                </div>

                <div class="pb-1 mx-auto sm:mx-24 md:mx-30 lg:mx-72 xl:mx-60 2xl:mx-80">

                    <p class="mx-4 my-2 text-lg" style="font-family: 'Poppins', sans-serif;">Select date</p>

                    <DatePicker
                        v-model="form.date"
                        is-expanded
                        is24hr
                        format="YYYY-MM-DD"
                        :masks="{ L: 'YYYY-MM-DD' }"
                        mode="dateTime"
                        :min-date='new Date()'

                    >
                    </DatePicker>


                    <div class="flex mx-2 mt-4 lg:mx-4 ">

                        <img :src="location2" width="40" alt="plus">

                        <BreezeInput id="location" type="text" class=" ml-2 block w-full bg-gray-100 "
                                     style="border: none !important;"
                                     v-model="form.location"
                                     placeholder="Location*"
                                     required autofocus autocomplete="location"/>
                    </div>

                    <!--                    PUBLIC OR PRIVATE SWITCH        -->
                </div>


                <div class="my-8 grid justify-items-center">
                    <loading-button :loading="form.processing"
                                    class="button px-8 py-2 " type="submit">
                        ADD EVENT
                    </loading-button>
                </div>
            </form>

            <!--            ADD TAB     -->
            <div class="pb-1 mx-2 sm:mx-24 md:mx-30 lg:mx-72 xl:mx-60 2xl:mx-80">

                <div class=" grid grid-cols-3 gap-4 content-center ...">
                    <div class="bg-white rounded-2xl hover:bg-gray-300">
                        <a :href="route('posts.create', $page.props.auth.user.username )"
                           class="w-full justify-center inline-block text-center pt-2 pb-1"
                        >
                            <img :src="post" width="40" height="40" class="inline-block" alt="plus">
                        </a>
                    </div>
                    <div class="bg-white rounded-2xl hover:bg-gray-300">

                        <a :href="route('party.create', $page.props.auth.user.username )"
                           class="w-full  justify-center inline-block text-center pt-2 pb-1"
                        >
                            <img :src="party" width="40" height="40" class="inline-block" alt="plus">
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl bg-gray-300">
                        <a :href="route('event.create', $page.props.auth.user.username )"
                           class="w-full justify-center inline-block text-center pt-2 pb-1"
                        >
                            <img :src="event" width="40" height="40" class="inline-block" alt="plus">
                        </a>
                    </div>
                </div>
            </div>

        </BreezeAuthenticatedLayout>
    </div>
</template>

<script>
import FileInput from "@/Components/FileInput";
import TextInput from "@/Components/TextInput";
import LoadingButton from "@/Components/LoadingButton";
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import post from "/img/Posts/post.png";
import party from "/img/Posts/party.png";
import event from "/img/Posts/event.png";
import {Calendar, DatePicker} from 'v-calendar';
import Pagination from '@/Components/Pagination';
import {InertiaLink} from "@inertiajs/inertia-vue3";
import location2 from "/img/Party/location2.png";
import {Head} from '@inertiajs/inertia-vue3';


export default {
    name: "Create",
    components: {
        BreezeAuthenticatedLayout,
        FileInput,
        TextInput,
        LoadingButton,
        BreezeInput,
        BreezeLabel,
        Calendar,
        DatePicker,
        Pagination,
        InertiaLink,
        Head,
    },
    props: {
        // users: Object,
        followers: Object,
    },

    data() {
        return {
            modelConfig: {
                type: 'string',
                masks: {

                    L: 'YYYY-MM-DD HH:MM', // Uses 'iso' if missing
                }
            },
            // avatar: avatar,
            post: post,
            party: party,
            event: event,
            location2: location2,
            url: null,
            userPosts: this.posts,
            form: this.$inertia.form({
                description: null,
                title: null,
                date: null,
                eventImg: null,
                location: null,

            }),
            date: new Date(),
            checked: null,
            items: [
                {name: 'Public'},
                {name: 'Private'},
            ],
            typeOfTask: null, // 1 = recurring, 2 = scheduled
        }
    },


    methods: {


        submit() {
            if (this.$refs.photo) {
                this.form.eventImg = this.$refs.photo.files[0];
            }

            this.form.post(this.route('event.store'))
        },

        previewAvatar(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        check_one: function () {
            this.additional = [];
        },

    },


    // created() {
    //     debugger
    // },
}


</script>

<style scoped>
.button {
    border-radius: 25px;
    color: ghostwhite;
    background-color: black;
    /*width: 100%;*/
    /*display: inline;*/
    text-align: center;
    font-size: 12px;
    font-family: 'Nunito', sans-serif;
}

</style>
