<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Show",
    components: {SecondaryButton, PrimaryButton, Head, AuthenticatedLayout, Link},

    props: ['branch'],

}
</script>

<template>
    <Head :title="branch.title"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 mr-3"
            >
                {{ branch.title }}
            </h2>
        </template>

<!--        <div class="py-12">-->
<!--            <div v-if="sections" class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">-->
<!--                <template v-for="section in sections">-->
<!--                    <div v-if="section.branches.length">-->
<!--                        <h3 class="section__title rounded-t-3xl px-6 py-2 text-lg text-white">{{ section.title }}</h3>-->
<!--                        <div class="bg-white p-6 py-3 rounded-b-3xl border border-gray-300">-->
<!--                            <div v-for="branch in section.branches"-->
<!--                                 class="py-2 border-b border-b-gray-400 last:border-b-0">-->
<!--                                <Link :href="route('branches.show', branch.id)" class="block">{{ branch.title }}</Link>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </template>-->
<!--            </div>-->
<!--        </div>-->
    </AuthenticatedLayout>
</template>

<style scoped>
.section__title {
    background: linear-gradient(to right, #fb6a00, #ffba00);
}
</style>
