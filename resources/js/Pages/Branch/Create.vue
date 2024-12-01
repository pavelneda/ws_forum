<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    name: "Index",
    components: {PrimaryButton, InputLabel, InputError, TextInput, Head, AuthenticatedLayout},

    props: ['sections'],

    data(){
        return {
            title: '',
            section_id: null,
            errors: null,
        }
    },

    methods: {
        store(){
            this.$inertia.post(route('branches.store'), {
                title: this.title,
                section_id: this.section_id,
            })
        }
    },
}
</script>

<template>
    <Head title="Create branch"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Create branch
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <InputLabel for="section" value="Section" />
                        <select v-model="section_id" id="section" class="mb-4 rounded-md border-gray-300 shadow-sm">
                            <option :value="null" disabled selected>Select section</option>
                            <option v-for="section in sections" :value="section.id">{{ section.title }}</option>
                        </select>

                        <InputLabel for="title" value="Title" />
                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-1/4"
                            v-model="title"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="errors" />
                        <PrimaryButton @click="store" class="mt-4">Create</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
