<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    name: "Edit",
    components: {PrimaryButton, InputLabel, InputError, TextInput, Head, AuthenticatedLayout},

    props: ['sections', 'branch'],

    data() {
        return {
            title: this.branch.title,
            branches: null,
            section_id: this.branch.section_id,
            parent_id: null,
            errors: null,
        }
    },

    mounted() {
        this.getBranches().then(() => {
            this.parent_id = this.branch.parent_id;
        });
    },

    methods: {
        update() {
            this.$inertia.patch(route('branches.update', this.branch.id), {
                title: this.title,
                section_id: this.section_id,
                parent_id: this.parent_id,
            })
        },

        async getBranches() {
            await axios.get(`/sections/${this.section_id}/branches_except/${this.branch.id}`)
                .then(res => {
                    this.parent_id = null;
                    this.branches = res.data;
                })
        }
    },
}
</script>

<template>
    <Head title="Edit branch"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Edit branch
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <InputLabel for="section" value="Section"/>
                        <select @change="getBranches" v-model="section_id" id="section"
                                class="mb-4 rounded-md border-gray-300 shadow-sm">
                            <option :value="null" disabled selected>Select section</option>
                            <option v-for="section in sections" :value="section.id">{{ section.title }}</option>
                        </select>
                        <InputError class="mb-2" :message="this.$page.props.errors.section_id"/>

                        <InputLabel v-if="branches && branches.length > 0" for="branch" value="Branch"/>
                        <select v-if="branches && branches.length > 0" v-model="parent_id" id="branch"
                                class="mb-4 rounded-md border-gray-300 shadow-sm">
                            <option :value="null" disabled selected>Select branch</option>
                            <option v-for="branch in branches" :value="branch.id">{{ branch.title }}</option>
                        </select>
                        <InputError class="mb-2" :message="this.$page.props.errors.parent_id"/>

                        <InputLabel for="title" value="Title"/>
                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-1/4"
                            v-model="title"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="this.$page.props.errors.title"/>
                        <PrimaryButton @click="update" class="mt-4">Update</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
