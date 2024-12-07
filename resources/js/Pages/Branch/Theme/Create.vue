<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    name: "Create",
    components: {PrimaryButton, InputLabel, InputError, TextInput, Head, AuthenticatedLayout},

    props: ['branch'],

    data(){
        return {
            errors: null,
            title: '',
            description: null,
        }
    },

    methods: {
        store(){
            this.$inertia.post(route('themes.store'), {
                title: this.title,
                description: this.description,
                branch_id: this.branch.id,
            })
        },
    },
}
</script>

<template>
    <Head title="Create theme"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Create theme
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <InputLabel for="title" value="Title" />
                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-1/2"
                            v-model="title"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="this.$page.props.errors.title" />

                        <InputLabel class="mt-2" for="description" value="Description" />
                        <textarea
                            id="description"
                            class="mt-1 block w-1/2 resize-none rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            v-model="description"
                        ></textarea>
                        <InputError class="mt-2" :message="this.$page.props.errors.description" />

                        <PrimaryButton @click="store" class="mt-4">Create</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
