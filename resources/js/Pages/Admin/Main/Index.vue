<script>
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Index",
    components: {AdminLayout, SecondaryButton, PrimaryButton, Head, Link},

    props: ['stats'],

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
            <div v-if="stats" class="flex justify-between text-center">
                <div v-for="stat in stats">
                    <h3>{{ stat.title }}</h3>
                    <p>{{ stat.count }}</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
