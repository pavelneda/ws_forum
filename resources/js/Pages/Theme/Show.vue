<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    name: "Show",
    components: {SecondaryButton, PrimaryButton, InputLabel, InputError, TextInput, Head, AuthenticatedLayout},

    props: ['theme'],

    created(){
        window.Echo.channel(`message.${this.theme.id}`)
            .listen('.store', res => {
                this.theme.messages.push(res.message);
            })

        window.Echo.channel(`message.like.${this.theme.id}`)
            .listen('.store', res => {
                this.theme.messages.filter(message => {
                    return message.id === res.message.id
                }).map(message => {
                    message.likes = res.message.likes
                })
            })
    },

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

        openComplaint(message) {
            message.is_complaint = !message.is_complaint;
            message.complaint_body = '';
        },

        storeComplaint(message) {
            axios.post(route('messages.compliant.store', message.id), {
                body: message.complaint_body,
                message_id: message.id,
            }).then(res => {
                message.complaint_body = '';
                message.is_not_solved_complaint = res.data.is_not_solved_complaint;
            })
        },

        storeImage(e) {
            let file = e.target.files[0];
            if(!file || file.type.indexOf('image/') === -1) return;

            const formData = new FormData();
            formData.append('file', file);

            axios.post(route('images.store'), formData)
                .then(res => {
                    const image = res.data;

                    const editor = this.$refs.editor;
                    const oldText = editor.innerHTML;

                    editor.innerHTML = `${oldText} <br><span hidden>img_id=${image.id}</span><img src="${image.url}"></br>`;
                })

            this.$refs.img_load.value = ''
        },

        formatTextBold(){
            if (!window.getSelection().toString()) return;

            const range = window.getSelection().getRangeAt(0);
            const strong = document.createElement('strong');
            range.surroundContents(strong);
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
                         class="p-6 flex border-b border-b-gray-200" :id="message.id">
                        <div class="w-1/6 pr-6 text-center border-r border-r-gray-200">
                            <div class="rounded-full bg-gray-500 size-24 mx-auto overflow-hidden">
                                <img v-if="message.user.avatar_url" :src="message.user.avatar_url"
                                     :alt="message.user.avatar_url"/>
                            </div>
                            <h3 class="mt-3">{{ message.user.name }}</h3>
                        </div>
                        <div class="w-5/6 pl-6 flex flex-col">
                            <p class="text-sm italic text-gray-500">{{ message.time }}</p>
                            <div v-if="message.is_not_solved_complaint">
                                <p class="bg-red-100 rounded-lg p-2 border border-1 mb-3">Your complaint is pending</p>
                            </div>
                            <p v-html="message.content"></p>
                            <div class="flex justify-end items-end flex-grow">
                                <div class="w-full flex items-center">
                                    <SecondaryButton @click="answer(message)"
                                                     class="mr-2 !bg-blue-500 !text-white">Answer
                                    </SecondaryButton>
                                    <SecondaryButton @click="openComplaint(message)"
                                                     class="mr-auto !bg-red-500 !text-white">Complaint
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
                                <TextInput v-model="message.complaint_body" class="w-5/6 rounded-r-none border-r-0"
                                           type="text" placeholder="Complaint"></TextInput>
                                <SecondaryButton @click="storeComplaint(message)"
                                                 class="rounded-l-none py-3 !bg-red-500 !text-white">Send
                                </SecondaryButton>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <InputLabel class="mt-2" for="content" value="Message"/>
                        <div
                            class="flex items-center mt-1 bg-gray-100 p-2 w-1/2 rounded-md border-gray-400 border rounded-b-none">
                            <a href="" class="block" @click.prevent="$refs.img_load.click()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                </svg>
                            </a>
                            <a href="" class="block text-xl ml-3 font-bold" @click.prevent="formatTextBold">B</a>
                            <input @change="storeImage" hidden type="file" accept="image/*" ref="img_load">
                        </div>
                        <div ref="editor" contenteditable="true"
                             class=" p-2 w-1/2 rounded-md border border-gray-400 shadow-sm rounded-t-none border-t-0"></div>
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
