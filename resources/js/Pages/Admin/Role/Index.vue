<script>
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Index",
    components: {AdminLayout, SecondaryButton, PrimaryButton, Head, Link},

    props: ['roles'],


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
                <h3 class="font-bold text-lg mr-4">Roles</h3>
                <Link :href="route('admin.roles.create')">
                    <SecondaryButton class="mr-2 !p-1 !px-2">+Role</SecondaryButton>
                </Link>
            </div>
            <div class="rounded-lg border border-gray-200">
                <table class="text-center  w-full">
                    <thead class="w-full bg-gray-100 font-bold">
                    <tr>
                        <td class="p-4 text-gray-700">Id</td>
                        <td class="p-4 text-gray-700">Title</td>
                        <td class="p-4 text-gray-700">Code</td>
                        <td class="p-4 text-gray-700">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="role in roles" class="text-gray-500">
                        <td class="p-4">{{ role.id }}</td>
                        <td class="p-4">{{ role.title }}</td>
                        <td class="p-4">{{ role.code }}</td>
                        <td class="p-4">
                            +
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
