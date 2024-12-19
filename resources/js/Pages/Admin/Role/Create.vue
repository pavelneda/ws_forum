<script>
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";

export default {
    name: "Create",
    components: {InputLabel, InputError, TextInput, AdminLayout, SecondaryButton, PrimaryButton, Head, Link},

    props: ['sections'],

    data(){
        return {
            title: '',
            branches: null,
            section_id: null,
            branch_id: null,
            errors: null,
        }
    },

    methods: {
        store(){
            this.$inertia.post(route('admin.roles.store'), {
                title: this.title,
                section_id: this.section_id,
                branch_id: this.branch_id,
            })
        },

        getBranches(){
            axios.get(`/sections/${this.section_id}/branches`)
                .then(res => {
                    this.branch_id = null;
                    this.branches = res.data;
                })
        }
    },
}
</script>

<template>
    <Head title="Admin panel"/>

    <AdminLayout>
        <template #header>
            <div class="flex items-center">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 mr-3"
                >
                    Admin panel
                </h2>
            </div>
        </template>

        <div class="bg-white rounded-lg p-6">
            <div class="flex items-center mb-2">
                <h3 class="font-bold text-lg mr-4">Create role</h3>
            </div>
            <div class="text-gray-900">
                <InputLabel for="section" value="Section" />
                <select @change="getBranches" v-model="section_id" id="section" class="mb-4 rounded-md border-gray-300 shadow-sm">
                    <option :value="null" disabled selected>Select section</option>
                    <option v-for="section in sections" :value="section.id">{{ section.title }}</option>
                </select>
                <InputError class="mb-2" :message="this.$page.props.errors.section_id" />

                <InputLabel v-if="branches && branches.length > 0" for="branch" value="Branch" />
                <select v-if="branches && branches.length > 0" v-model="branch_id" id="branch" class="mb-4 rounded-md border-gray-300 shadow-sm">
                    <option :value="null" disabled selected>Select branch</option>
                    <option v-for="branch in branches" :value="branch.id">{{ branch.title }}</option>
                </select>
                <InputError class="mb-2" :message="this.$page.props.errors.branch_id" />

                <InputLabel for="title" value="Title" />
                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-1/4"
                    v-model="title"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="this.$page.props.errors.title" />
                <PrimaryButton @click="store" class="mt-4">Create</PrimaryButton>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
</style>
