<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    name: "Show",
    components: {PrimaryButton, InputLabel, InputError, TextInput, Head, AuthenticatedLayout},

    props: ['theme'],

    methods: {
        store() {
            axios.post(route('messages.store'), {
                theme_id: this.theme.id,
                content: this.$refs.editor.innerHTML,
            }).then(res => {
                this.$refs.editor.innerHTML = ''
                console.log(res.data);
            })
        },
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
                    <div v-if="theme.messages.length" v-for="message in theme.messages" class="p-6 flex border-b border-b-gray-200">
                        <div class="w-1/6 pr-6 text-center border-r border-r-gray-200">
                            <div class="rounded-full bg-gray-500 size-24 mx-auto"></div>
                            <h3 class="mt-3">{{ message.user.name }}</h3>
                        </div>
                        <div class="w-5/6 pl-6">
                            <p class="text-sm italic text-gray-500">{{ message.time }}</p>
                            <p>{{ message.content }}</p>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <InputLabel class="mt-2" for="content" value="Message" />
                        <div ref="editor" contenteditable="true" class="mt-1 p-2 w-1/2 rounded-md border border-gray-400 shadow-sm"></div>
                        <InputError class="mt-2" :message="this.$page.props.errors.content" />

                        <PrimaryButton @click="store" class="mt-4">Send message</PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
