<script setup lang="ts">
useSeoMeta({
    title: 'BabDev - Open Source Solutions for PHP Applications',
    titleTemplate: null,
})
</script>

<template>
    <AppHero>
        <template #title>Creating Open Source Solutions Since 2010</template>
    </AppHero>

    <section class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16">
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-brand-orange flex h-8 w-8 items-center justify-center rounded-full">
                            <Icon name="fa7-regular:user" class="h-5 w-5 fill-current text-white" />
                        </div>
                        <h2 class="font-bpscript text-3xl font-bold text-gray-900">Who I Am</h2>
                    </div>
                    <div class="prose prose-lg text-gray-600">
                        <p>
                            I am
                            <a
                                href="https://michaels.website"
                                rel="nofollow noopener"
                                class="text-brand-orange font-medium hover:text-orange-700"
                                >Michael Babker</a
                            >, a long tenured contributor to the Open Source software community and Lead Engineer for
                            <a
                                href="https://happydog.digital"
                                rel="nofollow noopener"
                                class="text-brand-orange font-medium hover:text-orange-700"
                                >Happy Dog</a
                            >.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-brand-orange flex h-8 w-8 items-center justify-center rounded-full">
                            <Icon name="fa7-solid:code" class="h-5 w-5 fill-current text-white" />
                        </div>
                        <h2 class="font-bpscript text-3xl font-bold text-gray-900">What I Do</h2>
                    </div>
                    <div class="prose prose-lg text-gray-600">
                        <p>
                            As an open source contributor and developer, I create solutions to help others fulfill their
                            own requirements for PHP projects (primarily with the Symfony and Laravel frameworks). As
                            the Lead Engineer of Happy Dog, I work closely with clients to create solutions tailored to
                            their business needs.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="font-bpscript text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Open Source Commitment
                </h2>
                <p class="mt-4 text-lg leading-6 text-gray-600">
                    Building quality software that developers can rely on
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="text-center">
                    <div class="bg-brand-orange mx-auto flex h-16 w-16 items-center justify-center rounded-full">
                        <Icon name="fa7-solid:code-merge" class="h-8 w-8 fill-current text-white" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Quality Code</h3>
                    <p class="mt-4 text-gray-600">
                        All packages are built with modern PHP practices, comprehensive testing, and thorough
                        documentation.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-brand-orange mx-auto flex h-16 w-16 items-center justify-center rounded-full">
                        <Icon name="fa7-solid:people-group" class="h-8 w-8 fill-current text-white" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Community Focused</h3>
                    <p class="mt-4 text-gray-600">
                        Actively involved in the PHP community with contributions to popular frameworks and libraries.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-brand-orange mx-auto flex h-16 w-16 items-center justify-center rounded-full">
                        <Icon name="fa7-solid:bolt" class="h-8 w-8 fill-current text-white" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Performance Driven</h3>
                    <p class="mt-4 text-gray-600">
                        Solutions designed for performance and scalability to meet demanding application requirements.
                    </p>
                </div>
            </div>

            <div class="mt-16 text-center">
                <NuxtLink
                    class="bg-brand-orange focus:ring-brand-orange inline-flex items-center rounded-md px-6 py-3 text-base font-medium text-white shadow-sm transition-colors duration-200 hover:bg-orange-600 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                    to="/open-source/packages"
                >
                    Explore Open Source Packages <Icon name="fa7-solid:arrow-right" class="ml-2 h-5 w-5 fill-current" />
                </NuxtLink>
            </div>
        </div>
    </section>
</template>
