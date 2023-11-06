<!-- Teams Dropdown -->
<jet-dropdown
    align="right"
    width="60"
    v-if="$page.props.jetstream.hasTeamFeatures"
>
                                                <template #trigger>
                                                    <span
                                                        class="inline-flex rounded-md"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-mainone focus:outline-none transition"
                                                        >
                                                            {{
                                                                $page.props.user
                                                                    .current_team
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
                                                                    d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </template>

                                                <template #content>
                                                    <div class="w-60">
                                                        <!-- Team Management -->
                                                        <template
                                                            v-if="
                                                                $page.props
                                                                    .jetstream
                                                                    .hasTeamFeatures
                                                            "
                                                        >
                                                            <div
                                                                class="block px-4 py-2 text-xs text-gray-400"
                                                            >
                                                                Gérer les
                                                                équipes
                                                            </div>

                                                            <!-- Team Settings -->
                                                            <jet-dropdown-link
                                                                :href="
                                                                    route(
                                                                        'teams.show',
                                                                        $page
                                                                            .props
                                                                            .user
                                                                            .current_team
                                                                    )
                                                                "
                                                            >
                                                                Paramètres de
                                                                l'équipe
                                                            </jet-dropdown-link>

                                                            <jet-dropdown-link
                                                                :href="
                                                                    route(
                                                                        'teams.create'
                                                                    )
                                                                "
                                                                v-if="
                                                                    $page.props
                                                                        .jetstream
                                                                        .canCreateTeams
                                                                "
                                                            >
                                                                Créer une
                                                                nouvelle équipe
                                                            </jet-dropdown-link>

                                                            <div
                                                                class="border-t border-gray-100"
                                                            ></div>

                                                            <!-- Team Switcher -->
                                                            <div
                                                                class="block px-4 py-2 text-xs text-gray-400"
                                                            >
                                                                Shanger d'équipe
                                                            </div>

                                                            <template
                                                                v-for="team in $page
                                                                    .props.user
                                                                    .all_teams"
                                                                :key="team.id"
                                                            >
                                                                <form
                                                                    @submit.prevent="
                                                                        switchToTeam(
                                                                            team
                                                                        )
                                                                    "
                                                                >
                                                                    <jet-dropdown-link
                                                                        as="button"
                                                                    >
                                                                        <div
                                                                            class="flex items-center"
                                                                        >
                                                                            <svg
                                                                                v-if="
                                                                                    team.id ==
                                                                                    $page
                                                                                        .props
                                                                                        .user
                                                                                        .current_team_id
                                                                                "
                                                                                class="mr-2 h-5 w-5 text-green-400"
                                                                                fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                stroke="currentColor"
                                                                                viewBox="0 0 24 24"
                                                                            >
                                                                                <path
                                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                                ></path>
                                                                            </svg>
                                                                            <div>
                                                                                {{
                                                                                    team.name
                                                                                }}
                                                                            </div>
                                                                        </div>
                                                                    </jet-dropdown-link>
                                                                </form>
                                                            </template>
                                                        </template>
                                                    </div>
                                                </template>
                                            </jet-dropdown>

<!-- MOBILE -->

<!-- Team Management -->
<template v-if="$page.props.jetstream.hasTeamFeatures">
    <div class="border-t border-gray-200"></div>

    <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>

    <!-- Team Settings -->
    <jet-responsive-nav-link
        :href="route('teams.show', $page.props.user.current_team)"
        :active="route().current('teams.show')"
    >
        Team Settings
    </jet-responsive-nav-link>

    <jet-responsive-nav-link
        :href="route('teams.create')"
        :active="route().current('teams.create')"
        v-if="$page.props.jetstream.canCreateTeams"
    >
        Create New Team
    </jet-responsive-nav-link>

    <div class="border-t border-gray-200"></div>

    <!-- Team Switcher -->
    <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>

    <template v-for="team in $page.props.user.all_teams" :key="team.id">
        <form @submit.prevent="switchToTeam(team)">
            <jet-responsive-nav-link as="button">
                <div class="flex items-center">
                    <svg
                        v-if="team.id == $page.props.user.current_team_id"
                        class="mr-2 h-5 w-5 text-green-400"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                    </svg>
                    <div>
                        {{ team.name }}
                    </div>
                </div>
            </jet-responsive-nav-link>
        </form>
    </template>
</template>
