<template>
    <div>
        <Head :title="title" />

        <jet-banner />

        <main class="w-full">
            <div id="menu" class="bg-white" :class="{ collapsed: isCollapsed }">
                <div class="text-gray-700">
                    <div
                        class="flex-shrink-0 px-8 py-2 flex flex-row items-center justify-between gradientBlack-static border border-t-0 border-x-0 border-b-1 border-grayone"
                    >
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('dashboard')">
                                <jet-application-mark
                                    class="block h-8 w-auto"
                                />
                            </Link>
                        </div>
                    </div>

                    <div
                        v-if="
                            $page.props.user.all_teams[0].membership.role ==
                            'manager'
                        "
                    >
                        <!-- Menu Manager -->
                        <nav class="mt-4 mb-4">
                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider tracking-wider"
                                >
                                    Gestionnaire</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('dashboard.manager')"
                                    :active="
                                        route().current('dashboard.manager')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-chart-bar"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Dashboard</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('inventories.index')"
                                    :active="
                                        route().current('inventories.index')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-building"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">États des lieux</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray pl-16 sub-menu"
                                    :href="route('inventories.create')"
                                    :active="
                                        route().current('inventories.create')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-angle-right"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Créer</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray pl-16 sub-menu"
                                    :href="route('list.draft.inventories')"
                                    :active="
                                        route().current(
                                            'list.draft.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-angle-right"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Brouillons</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.ordered.inventories')"
                                    :active="
                                        route().current(
                                            'list.ordered.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-check-circle"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Confirmer un EDL</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.confirmed.inventories')"
                                    :active="
                                        route().current(
                                            'list.confirmed.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-link"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Affecter un EDL</span>
                                </jet-nav-link>
                            </div>
                        </nav>
                    </div>
                    <div
                        v-if="
                            $page.props.user.all_teams[0].membership.role ==
                            'assistant'
                        "
                    >
                        <!-- Menu Assistant -->
                        <nav class="mt-4 mb-4">
                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider tracking-wider"
                                >
                                    Assistant</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('dashboard.manager')"
                                    :active="
                                        route().current('dashboard.manager')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-chart-bar"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Dashboard</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('inventories.index')"
                                    :active="
                                        route().current('inventories.index')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-building"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">États des lieux</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray pl-16 sub-menu"
                                    :href="route('inventories.create')"
                                    :active="
                                        route().current('inventories.create')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-angle-right"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Créer</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray pl-16 sub-menu"
                                    :href="route('list.draft.inventories')"
                                    :active="
                                        route().current(
                                            'list.draft.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-angle-right"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Brouillons</span>
                                </jet-nav-link>
                            </div>
                        </nav>
                    </div>
                    <div
                        v-else-if="
                            $page.props.user.all_teams[0].membership.role ==
                            'expert-senior'
                        "
                    >
                        <!-- Menu Expert -->
                        <nav class="mt-4 mb-4">
                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider"
                                >
                                    {{ $page.props.user.name }}</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('dashboard.expert')"
                                    :active="
                                        route().current('dashboard.expert')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Dashboard</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.expert.assigned')"
                                    :active="
                                        route().current('list.expert.assigned')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Rendez-vous à fixer</span
                                    >
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.expert.todo')"
                                    :active="
                                        route().current('list.expert.todo')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">EDL à réaliser</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.expert.finished')"
                                    :active="
                                        route().current('list.expert.finished')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Historique</span>
                                </jet-nav-link>
                            </div>
                        </nav>
                    </div>

                    <div
                        v-else-if="
                            $page.props.user.all_teams[0].membership.role ==
                            'consultant'
                        "
                    >
                        <!-- Menu Consultant -->
                        <nav class="mt-4 mb-4">
                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider"
                                >
                                    Consultant</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('inventories.index')"
                                    :active="
                                        route().current('inventories.index')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-building"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">États des lieux</span>
                                </jet-nav-link>
                            </div>
                        </nav>
                    </div>

                    <div v-else>
                        <!-- Menu Admin -->
                        <nav class="mt-4 mb-4">
                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider"
                                >
                                    Admin</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-chart-bar"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Dashboard</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('users.create')"
                                    :active="route().current('users.create')"
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-plus-circle"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Créer un utilisateur</span
                                    >
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('users.index')"
                                    :active="route().current('users.index')"
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-plus-circle"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Tous les utilisateurs</span
                                    >
                                </jet-nav-link>
                                <jet-nav-link class="text-gray" href="/teams/1">
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-plus-circle"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Gérer l'équipe</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.property_types')"
                                    :active="
                                        route().current('list.property_types')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-euro"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Grille tarifaire</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.orders')"
                                    :active="route().current('list.orders')"
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-credit-card"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Gestion des commandes</span
                                    >
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.cancellations')"
                                    :active="
                                        route().current('list.cancellations')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-credit-card"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Liste des annulations</span
                                    >
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.archived.inventories')"
                                    :active="
                                        route().current(
                                            'list.archived.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-credit-card"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Liste des archives</span
                                    >
                                </jet-nav-link>
                            </div>

                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider tracking-wider"
                                >
                                    Gestionnaire</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('dashboard.manager')"
                                    :active="
                                        route().current('dashboard.manager')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-chart-bar"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Dashboard</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('inventories.index')"
                                    :active="
                                        route().current('inventories.index')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-building"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">États des lieux</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray pl-16 sub-menu"
                                    :href="route('inventories.create')"
                                    :active="
                                        route().current('inventories.create')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-angle-right"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Créer</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray pl-16 sub-menu"
                                    :href="route('list.draft.inventories')"
                                    :active="
                                        route().current(
                                            'list.draft.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-angle-right"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Brouillons</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.ordered.inventories')"
                                    :active="
                                        route().current(
                                            'list.ordered.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-check-circle"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Confirmer un EDL</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.confirmed.inventories')"
                                    :active="
                                        route().current(
                                            'list.confirmed.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-link"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Affecter un EDL</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.cancelled.inventories')"
                                    :active="
                                        route().current(
                                            'list.cancelled.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi pi-minus-circle"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Gérer les annulés</span>
                                </jet-nav-link>
                            </div>
                            <!-- 
                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider"
                                >
                                    Gestion des Experts</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('dashboard.expert')"
                                    :active="
                                        route().current('dashboard.expert')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Dashboard</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.assigned.inventories')"
                                    :active="
                                        route().current(
                                            'list.assigned.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Rendez-vous à fixer</span
                                    >
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.todo.inventories')"
                                    :active="
                                        route().current('list.todo.inventories')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">EDL à réaliser</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.finished.inventories')"
                                    :active="
                                        route().current(
                                            'list.finished.inventories'
                                        )
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Historique</span>
                                </jet-nav-link>
                            </div> -->

                            <div class="mb-8 mt-2">
                                <span
                                    class="heading flex justify-content align-center px-6 mb-2 uppercase text-xs text-grey-600 font-bold tracking-wider"
                                >
                                    {{ $page.props.user.name }} - Expert</span
                                >
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('dashboard.expert')"
                                    :active="
                                        route().current('dashboard.expert')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Dashboard</span>
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.expert.assigned')"
                                    :active="
                                        route().current('list.expert.assigned')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title"
                                        >Rendez-vous à fixer</span
                                    >
                                </jet-nav-link>

                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.expert.todo')"
                                    :active="
                                        route().current('list.expert.todo')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">EDL à réaliser</span>
                                </jet-nav-link>
                                <jet-nav-link
                                    class="text-gray"
                                    :href="route('list.expert.finished')"
                                    :active="
                                        route().current('list.expert.finished')
                                    "
                                >
                                    <span class="mr-4 flex content-center">
                                        <i
                                            class="pi pi-calendar-plus"
                                            style="font-size: 0.875rem"
                                        ></i>
                                    </span>
                                    <span class="title">Historique</span>
                                </jet-nav-link>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div id="content" :class="{ collapsed: isCollapsed }">
                <!-- Content nav -->
                <div id="contentNav" class="flex">
                    <!-- Header -->
                    <div class="w-full">
                        <nav class="bg-white">
                            <!-- Primary Navigation Menu -->
                            <div class="">
                                <div
                                    class="flex justify-between h-12 pr-0 md:pr-8 gradientBlack-static border border-t-0 border-x-0 border-b-1 border-darkone"
                                >
                                    <div
                                        id="menu-trigger"
                                        class="flex p-4"
                                        @click="isCollapsed = !isCollapsed"
                                        :class="{ collapsed: isCollapsed }"
                                    >
                                        <i class="pi pi-bars text-white"></i>
                                    </div>

                                    <div
                                        class="hidden sm:flex sm:items-center sm:ml-6"
                                    >
                                        <div class="ml-3 relative">
                                            <!-- Teams Dropdown -->
                                        </div>

                                        <!-- Settings Dropdown -->
                                        <div class="ml-3 relative">
                                            <jet-dropdown
                                                align="right"
                                                width="48"
                                            >
                                                <template #trigger>
                                                    <button
                                                        v-if="
                                                            $page.props
                                                                .jetstream
                                                                .managesProfilePhotos
                                                        "
                                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                                                    >
                                                        <img
                                                            class="h-8 w-8 rounded-full object-cover"
                                                            :src="
                                                                $page.props.user
                                                                    .profile_photo_url
                                                            "
                                                            :alt="
                                                                $page.props.user
                                                                    .name
                                                            "
                                                        />
                                                    </button>

                                                    <span
                                                        v-else
                                                        class="inline-flex rounded-md"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-mainone focus:outline-none transition"
                                                        >
                                                            {{
                                                                $page.props.user
                                                                    .name
                                                            }}

                                                            <svg
                                                                class="ml-2 -mr-0.5 h-4 w-4"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                            >
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </template>

                                                <template #content>
                                                    <!-- Account Management -->
                                                    <div
                                                        class="block px-4 py-2 text-xs text-gray-400"
                                                    >
                                                        Mon compte
                                                    </div>

                                                    <jet-dropdown-link
                                                        :href="
                                                            route(
                                                                'profile.show'
                                                            )
                                                        "
                                                    >
                                                        Modifier mes
                                                        informations
                                                    </jet-dropdown-link>

                                                    <jet-dropdown-link
                                                        :href="
                                                            route(
                                                                'api-tokens.index'
                                                            )
                                                        "
                                                        v-if="
                                                            $page.props
                                                                .jetstream
                                                                .hasApiFeatures
                                                        "
                                                    >
                                                        API Tokens
                                                    </jet-dropdown-link>

                                                    <div
                                                        class="border-t border-gray-100"
                                                    ></div>

                                                    <!-- Authentication -->
                                                    <form
                                                        @submit.prevent="logout"
                                                    >
                                                        <jet-dropdown-link
                                                            as="button"
                                                        >
                                                            Déconnexion
                                                        </jet-dropdown-link>
                                                    </form>
                                                </template>
                                            </jet-dropdown>
                                        </div>
                                    </div>

                                    <div class="logo-mobile block md:hidden">
                                        <a href="/dashboard"
                                            ><img
                                                src="/img/logo-bl.svg"
                                                alt="Logexpert"
                                        /></a>
                                    </div>

                                    <!-- Hamburger -->
                                    <div class="flex items-center sm:hidden">
                                        <button
                                            @click="
                                                showingNavigationDropdown =
                                                    !showingNavigationDropdown
                                            "
                                            class="flex p-4 items-center justify-center rounded-md text-gray-400 transition"
                                        >
                                            <i
                                                class="pi pi-user text-white"
                                            ></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Responsive Navigation Menu -->
                            <div
                                :class="{
                                    block: showingNavigationDropdown,
                                    hidden: !showingNavigationDropdown,
                                }"
                                class="sm:hidden"
                            >
                                <!-- Responsive Settings Options -->
                                <div class="pt-4 pb-1 border-t border-gray-200">
                                    <div class="flex items-center px-4">
                                        <div
                                            v-if="
                                                $page.props.jetstream
                                                    .managesProfilePhotos
                                            "
                                            class="shrink-0 mr-3"
                                        >
                                            <img
                                                class="h-10 w-10 rounded-full object-cover"
                                                :src="
                                                    $page.props.user
                                                        .profile_photo_url
                                                "
                                                :alt="$page.props.user.name"
                                            />
                                        </div>

                                        <div>
                                            <div
                                                class="font-medium text-base text-gray-800"
                                            >
                                                {{ $page.props.user.name }}
                                            </div>
                                            <div
                                                class="font-medium text-sm text-gray-500"
                                            >
                                                {{ $page.props.user.email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 space-y-1">
                                        <jet-responsive-nav-link
                                            :href="route('profile.show')"
                                            :active="
                                                route().current('profile.show')
                                            "
                                        >
                                            Profile
                                        </jet-responsive-nav-link>

                                        <jet-responsive-nav-link
                                            :href="route('api-tokens.index')"
                                            :active="
                                                route().current(
                                                    'api-tokens.index'
                                                )
                                            "
                                            v-if="
                                                $page.props.jetstream
                                                    .hasApiFeatures
                                            "
                                        >
                                            API Tokens
                                        </jet-responsive-nav-link>

                                        <!-- Authentication -->
                                        <form
                                            method="POST"
                                            @submit.prevent="logout"
                                        >
                                            <jet-responsive-nav-link
                                                as="button"
                                            >
                                                Déconnexion
                                            </jet-responsive-nav-link>
                                        </form>

                                        <!-- Team Management -->
                                    </div>
                                </div>
                            </div>
                        </nav>

                        <!-- Page Heading -->
                        <header
                            class="bg-gradient-to-l from-grayone"
                            v-if="$slots.header"
                        >
                            <div class="mx-auto py-3 px-3">
                                <h2
                                    class="font-bold text-xs uppercase text-gray-800 leading-tight"
                                >
                                    <slot name="header"></slot>
                                </h2>
                            </div>
                        </header>
                    </div>
                </div>

                <!-- Main content -->
                <div id="contentMain" class="gradientGray">
                    <!-- Page Content -->

                    <main class="w-full p-0 md:p-6">
                        <!-- <transition-group
                            name="fade"
                            enter-active-class="duration-400 transition-all ease"
                            leave-active-class="duration-400 transition-all ease"
                            :enter-class="'opacity'"
                        >
                            <slot v-if="loaded"></slot>
                        </transition-group> -->
                        <slot v-if="loaded"></slot>
                    </main>
                </div>
            </div>
            <!-- <div class="flex bg-mainone">
                <p>Footer</p>
            </div> -->
        </main>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";

export default defineComponent({
    props: {
        title: String,
    },

    components: {
        reactive,
        Head,
        JetApplicationMark,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
            loaded: false,
            isCollapsed: false,

            menu: [
                {
                    header: "Main Navigation",
                    hiddenOnCollapse: true,
                },
                {
                    href: "/",
                    title: "Dashboard",
                    icon: "fa fa-user",
                },
                {
                    href: "/charts",
                    title: "Charts",
                    icon: "fa fa-chart-area",
                    child: [
                        {
                            href: "/charts/sublink",
                            title: "Sub Link",
                        },
                    ],
                },
            ],
        };
    },

    mounted() {
        this.loaded = true;
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            );
        },

        logout() {
            this.$inertia.post(route("logout"));
        },
    },

    setup() {
        return {};
    },
});
</script>
