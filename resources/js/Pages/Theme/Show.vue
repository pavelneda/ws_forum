<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    name: "Show",
    components: {SecondaryButton, PrimaryButton, InputLabel, InputError, TextInput, Head, AuthenticatedLayout},

    props: ['theme'],

    methods: {
        store() {
            axios.post(route('messages.store'), {
                theme_id: this.theme.id,
                content: this.$refs.editor.innerHTML,
            }).then(res => {
                this.$refs.editor.innerHTML = ''
                this.theme.messages.push(res.data);
            })
        },

        toggleLike(message) {
            axios.post(route('messages.toggleLike', message.id))
                .then(res => {
                    message.is_liked ? message.likes-- : message.likes++;
                    message.is_liked = !message.is_liked;
                })
        },

        answer(message) {
            const title = `<div class="w-full bg-gray-200 border border-gray-300 p-2">Answer for user @${message.user.id} ${message.user.name} ${message.time}</div>`;
            const editor = this.$refs.editor;
            const oldText = editor.innerHTML;

            editor.innerHTML = `${oldText} ${title}<blockquote> ${message.content}</blockquote><br>`;
        },

        openComplaint(message){
            message.is_complaint = !message.is_complaint;
            message.complaint_body = '';
        },

        storeComplaint(message){
            axios.post(route('messages.compliant.store', message.id), {
                body: message.complaint_body,
                message_id: message.id,
            }).then(res => {
                message.complaint_body = '';
            })
        }
    },
}
</script>

<template>
    <Head :title="this.theme.title"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                {{ this.theme.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="theme.messages.length" v-for="message in theme.messages"
                         class="p-6 flex border-b border-b-gray-200">
                        <div class="w-1/6 pr-6 text-center border-r border-r-gray-200">
                            <div class="rounded-full bg-gray-500 size-24 mx-auto overflow-hidden">
                                <img v-if="message.user.avatar_url" :src="message.user.avatar_url"
                                     :alt="message.user.avatar_url"/>
                            </div>
                            <h3 class="mt-3">{{ message.user.name }}</h3>
                        </div>
                        <div class="w-5/6 pl-6 flex flex-col">
                            <p class="text-sm italic text-gray-500">{{ message.time }}</p>
                            <p v-html="message.content"></p>
                            <div class="flex justify-end items-end flex-grow">
                                <div class="w-full flex items-center">
                                    <SecondaryButton @click="answer(message)"
                                                     class="mr-2 bg-blue-500 text-white hover:text-black">Answer
                                    </SecondaryButton>
                                    <SecondaryButton @click="openComplaint(message)"
                                                     class="mr-auto bg-red-500 text-white hover:text-black">Complaint
                                    </SecondaryButton>
                                    <div v-if="message.likes" class="mr-2">{{ message.likes }}</div>
                                    <svg @click="toggleLike(message)" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor"
                                         :class="['size-7 cursor-pointer', message.is_liked ? 'fill-red-700' : '']">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                    </svg>
                                </div>
                            </div>
                            <div v-if="message.is_complaint" class="mt-4 w-3/4">
                                <TextInput v-model="message.complaint_body" class="w-5/6 rounded-r-none border-r-0" type="text" placeholder="Complaint"></TextInput>
                                <SecondaryButton @click="storeComplaint(message)"
                                                 class="rounded-l-none py-3 bg-red-500 text-white hover:text-black">Send
                                </SecondaryButton>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <InputLabel class="mt-2" for="content" value="Message"/>
                        <div ref="editor" contenteditable="true"
                             class="mt-1 p-2 w-1/2 rounded-md border border-gray-400 shadow-sm"></div>
                        <InputError class="mt-2" :message="this.$page.props.errors.content"/>

                        <PrimaryButton @click="store" class="mt-4">Send message</PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
blockquote {
    display: block;
    padding: 4px;
    padding-left: 6px;
    border-left: 4px solid #a0aec0;
    background-color: #f6f6f6;
}
</style>
