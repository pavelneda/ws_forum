<script>
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Index",
    components: {AdminLayout, SecondaryButton, PrimaryButton, Head, Link},

    props: ['complaints'],

    methods:{
        updateStatus(complaint){
            axios.patch(route('admin.complaints.update', complaint.id))
                .then(res => {
                    complaint.status = res.data.status;
                })
        },
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
            <div class="rounded-lg border border-gray-200">
                <table class="text-center  w-full">
                    <thead class="w-full bg-gray-100 font-bold">
                    <tr>
                        <td class="p-4 text-gray-700">Id</td>
                        <td class="p-4 text-gray-700">Body</td>
                        <td class="p-4 text-gray-700">User</td>
                        <td class="p-4 text-gray-700">Message</td>
                        <td class="p-4 text-gray-700">Status</td>
                        <td class="p-4 text-gray-700">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="complaint in complaints" class="text-gray-500">
                        <td class="p-4">{{ complaint.id }}</td>
                        <td class="p-4">{{ complaint.body }}</td>
                        <td class="p-4">{{ complaint.user_name }}</td>
                        <td class="p-4">
                            <Link :href="route('themes.show', complaint.theme_id) + `#${complaint.message_id}`">Link
                            </Link>
                        </td>
                        <td class="p-4">{{ complaint.status ? 'Solved' : 'Not solved' }}</td>
                        <td class="p-4">
                            <a @click.prevent="updateStatus(complaint)" href="" class="inline-block text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor"
                                     :class="['size-6', complaint.status ? 'stroke-green-500' : 'stroke-red-500']">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
</style>
