<template>
    <div>
        <div class="text-xs-center">
            <v-menu
                v-model="menu"
                :close-on-content-click="false"
                :nudge-bottom="10"
                offset-y
            >
                <v-btn icon dark slot="activator">
                    <v-badge overlap color="orange">
                        <span slot="badge">2</span>
                        <v-icon dark>
                            message
                        </v-icon>
                    </v-badge>
                </v-btn>
                <v-card>
                    <v-layout row wrap>
                        <v-list two-line>
                            <template v-for="(item, index) in items">
                                <v-list-tile
                                    :key="item.title"
                                    avatar
                                    ripple
                                    @click="toggle(index)"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                        <v-list-tile-sub-title class="text--primary">{{ item.headline }}
                                        </v-list-tile-sub-title>
                                        <v-list-tile-sub-title>{{ item.subtitle }}</v-list-tile-sub-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-list-tile-action-text>{{ item.action }}</v-list-tile-action-text>
                                        <v-icon
                                            v-if="selected.indexOf(index) < 0"
                                            color="grey lighten-1"
                                        >
                                            star_border
                                        </v-icon>
                                        <v-icon v-else color="yellow darken-2">star</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                                <v-divider
                                    v-if="index + 1 < items.length"
                                    :key="index"
                                ></v-divider>
                            </template>
                        </v-list>
                    </v-layout>
                    <v-divider light></v-divider>
                    <v-card-actions class="text-md-center">
                        <v-layout row justify-center>
                            <v-btn small>Ver todas solicitações</v-btn>
                        </v-layout>
                    </v-card-actions>
                </v-card>
            </v-menu>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            menu: false,
            selected: [2],
            items: [
                {
                    action: '15 min',
                    headline: 'Brunch this weekend?',
                    title: 'Ali Connors',
                    subtitle: "I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
                },
                {
                    action: '2 hr',
                    headline: 'Summer BBQ',
                    title: 'me, Scrott, Jennifer',
                    subtitle: "Wish I could come, but I'm out of town this weekend."
                },
                {
                    action: '6 hr',
                    headline: 'Oui oui',
                    title: 'Sandra Adams',
                    subtitle: 'Do you have Paris recommendations? Have you ever been?'
                },
                {
                    action: '12 hr',
                    headline: 'Birthday gift',
                    title: 'Trevor Hansen',
                    subtitle: 'Have any ideas about what we should get Heidi for her birthday?'
                },
                {
                    action: '18hr',
                    headline: 'Recipe to try',
                    title: 'Britta Holt',
                    subtitle: 'We should eat this: Grate, Squash, Corn, and tomatillo Tacos.'
                },
            ],
        }),
        methods: {
            toggle(index) {
                const i = this.selected.indexOf(index)

                if (i > -1) {
                    this.selected.splice(i, 1)
                } else {
                    this.selected.push(index)
                }
            },
        },
    };
</script>

<style scoped>

</style>
