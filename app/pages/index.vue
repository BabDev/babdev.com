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
                        <div class="h-8 w-8 rounded-full bg-brand-orange flex items-center justify-center">
                            <Icon name="fa7-regular:user" class="h-5 w-5 text-white fill-current" />
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 font-bpscript">Who I Am</h2>
                    </div>
                    <div class="prose prose-lg text-gray-600">
                        <p>I am <a href="https://michaels.website" rel="nofollow noopener" class="text-brand-orange hover:text-orange-700 font-medium">Michael Babker</a>, a long tenured contributor to the Open Source software community and Lead Engineer for <a href="https://happydog.digital" rel="nofollow noopener" class="text-brand-orange hover:text-orange-700 font-medium">Happy Dog</a>.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-full bg-brand-orange flex items-center justify-center">
                            <Icon name="fa7-solid:code" class="h-5 w-5 text-white fill-current" />
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 font-bpscript">What I Do</h2>
                    </div>
                    <div class="prose prose-lg text-gray-600">
                        <p>As an open source contributor and developer, I create solutions to help others fulfill their own requirements for PHP projects (primarily with the Symfony and Laravel frameworks). As the Lead Engineer of Happy Dog, I work closely with clients to create solutions tailored to their business needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl font-bpscript">Open Source Commitment</h2>
                <p class="mt-4 text-lg leading-6 text-gray-600">Building quality software that developers can rely on</p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-orange">
                        <Icon name="fa7-solid:code-merge" class="h-8 w-8 text-white fill-current" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Quality Code</h3>
                    <p class="mt-4 text-gray-600">All packages are built with modern PHP practices, comprehensive testing, and thorough documentation.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-orange">
                        <Icon name="fa7-solid:people-group" class="h-8 w-8 text-white fill-current" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Community Focused</h3>
                    <p class="mt-4 text-gray-600">Actively involved in the PHP community with contributions to popular frameworks and libraries.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-orange">
                        <Icon name="fa7-solid:bolt" class="h-8 w-8 text-white fill-current" />
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Performance Driven</h3>
                    <p class="mt-4 text-gray-600">Solutions designed for performance and scalability to meet demanding application requirements.</p>
                </div>
            </div>

            <div class="mt-16 text-center">
                <NuxtLink class="inline-flex items-center rounded-md bg-brand-orange px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition-colors duration-200" to="/open-source/packages">
                    Explore Open Source Packages <Icon name="fa7-solid:arrow-right" class="ml-2 h-5 w-5 fill-current" />
                </NuxtLink>
            </div>
        </div>
    </section>
</template>
