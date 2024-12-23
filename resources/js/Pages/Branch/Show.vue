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
            <div class="flex items-center">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 mr-3"
                >
                    {{ branch.title }}
                </h2>
                <template v-if="this.$page.props.auth.roles.some(role => {
                                    return [
                                        'editor',
                                        `editor.${branch.section_id}`,
                                        `editor.${branch.section_id}.${branch.id}`,
                                        `editor.${branch.section_id}.${branch.parent_id}`,
                                    ].includes(role);
                                })">
                    <Link :href="route('branches.themes.create', branch.id)">
                        <SecondaryButton class="mr-2 !p-1 !px-2">+Theme</SecondaryButton>
                    </Link>
                </template>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div v-if="branch.children && branch.children.length">
                    <h3 class="section__title rounded-t-3xl px-6 py-2 text-lg text-white">{{ branch.title }}</h3>
                    <div class="bg-white p-6 py-3 rounded-b-3xl border border-gray-300">
                        <div v-for="branch in branch.children"
                             class="flex items-center py-2 border-b border-b-gray-400 last:border-b-0">
                            <div class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z"/>
                                </svg>
                            </div>
                            <Link :href="route('branches.show', branch.id)" class="block w-full">{{
                                    branch.title
                                }}
                            </Link>
                            <template v-if="this.$page.props.auth.roles.some(role => {
                                    return [
                                        'editor',
                                        `editor.${branch.section_id}`,
                                        `editor.${branch.section_id}.${branch.id}`,
                                        `editor.${branch.section_id}.${branch.parent_id}`,
                                    ].includes(role);
                                })">
                                <Link :href="route('branches.edit', branch.id)" class="mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                    </svg>
                                </Link>
                                <Link :href="route('branches.destroy', branch.id)" method="delete" as="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>

                <div v-if="branch.themes && branch.themes.length">
                    <h3 class="section__title rounded-t-3xl px-6 py-2 text-lg text-white">Themes</h3>
                    <div class="bg-gray-50 p-6 py-3 rounded-b-3xl border border-gray-300">
                        <div v-for="theme in branch.themes"
                             class="flex items-center py-2 border-b border-b-gray-400 last:border-b-0">
                            <Link :href="route('themes.show', theme.id)" class="block w-full">
                                {{ theme.title }}
                                <p class="text-sm">{{ theme.description }}</p>
                            </Link>
                            <template v-if="this.$page.props.auth.roles.some(role => {
                                    return [
                                        'editor',
                                        `editor.${branch.section_id}`,
                                        `editor.${branch.section_id}.${branch.id}`,
                                        `editor.${branch.section_id}.${branch.parent_id}`,
                                    ].includes(role);
                                })">
                                <Link :href="route('themes.edit', theme.id)" class="mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                    </svg>
                                </Link>
                                <Link :href="route('themes.destroy', theme.id)" method="delete" as="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.section__title {
    background: linear-gradient(to right, #fb6a00, #ffba00);
}
</style>
