<script>
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Index",
    components: {AdminLayout, SecondaryButton, PrimaryButton, Head, Link},

    props: ['roles', 'users'],

    methods: {
        toggleRole(user, roleId) {
            axios.patch(route('admin.users.toggleRoles', user.id), {
                role_id: roleId,
            }).then(res => {
                user.roles = res.data.roles
            })
        },

        changeRoles(user){
            user.is_change_roles = !user.is_change_roles
            this.users.filter(filteredUsers => filteredUsers.id !== user.id)
                .forEach(el => {
                    el.is_change_roles = false
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
                <h3 class="font-bold text-lg mr-4">Users</h3>
            </div>
            <div class="rounded-lg border border-gray-200">
                <table class="text-center  w-full">
                    <thead class="w-full bg-gray-100 font-bold">
                    <tr>
                        <td class="p-4 text-gray-700">Id</td>
                        <td class="p-4 text-gray-700">Name</td>
                        <td class="p-4 text-gray-700">Roles</td>
                        <td class="p-4 text-gray-700">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" class="text-gray-500">
                        <td class="p-4">{{ user.id }}</td>
                        <td class="p-4">{{ user.name }}</td>
                        <td class="p-4">
                            <p v-for="role in user.roles">{{ role.code }}</p>
                        </td>
                        <td class="p-4 relative">
                            <SecondaryButton @click="changeRoles(user)">Change roles</SecondaryButton>
                            <div v-if="user.is_change_roles" class="absolute top-5/6 left-1/2 -translate-x-1/2 bg-white border border-gray-300 rounded-lg p-3 z-40">
                                <p v-for="role in roles" class="text-left mt-1 flex items-center">
                                    <input @change="toggleRole(user, role.id)" class="cursor-pointer" type="checkbox"
                                           :id="user.id.toString() +'.'+ role.id" :value="role.id"
                                           :checked="user.roles.some(userRoles => userRoles.id === role.id)">
                                    <label class="select-none pl-2 cursor-pointer"
                                           :for="user.id.toString() +'.'+ role.id">{{
                                            role.code
                                        }}
                                    </label>
                                </p>
                            </div>
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
