<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Index",
    components: {SecondaryButton, PrimaryButton, Head, AuthenticatedLayout, Link}
}
</script>

<template>
    <Head title="Sections"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 mr-3"
                >
                    Sections
                </h2>
                <Link :href="route('sections.create')">
                    <SecondaryButton class="mr-2 !p-1 !px-2">+Section</SecondaryButton>
                </Link>
                <Link :href="route('branches.create')">
                    <SecondaryButton class="!p-1 !px-2">+Branch</SecondaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                123
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
