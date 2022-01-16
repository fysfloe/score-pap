<template>
    <div class="score-list">
        <h1>Notenliste</h1>

        <div class="row">
            <div class="four columns">
                <form @submit.prevent="submitSearch">
                    <div class="form-group">
                        <label for="search">Suche</label>
                        <input type="text" name="search" id="search" v-model="search" placeholder="Suche..." />
                    </div>
                    <button type="submit" class="button-primary" @click="submitSearch">Suchen</button>
                </form>

                <filters @filter-update="submitSearch" />
            </div>
            <div class="eight columns">
                <loader v-if="loading" />

                <div v-else class="list-results">
                    <ul v-if="scores.length > 0">
                        <li v-for="score in scores">
                            <router-link :to="`/edit/${score.id}`">
                                <div class="row">
                                    <div class="ten columns">
                                        <h2>{{ score.title }}</h2>
                                        <span>{{ score.author }}</span>

                                        <div class="tag-list">
                                            <div class="tag" v-if="score.lineup">
                                                <i class="gg-smile" />{{ score.lineup }}
                                            </div>
                                            <div class="tag" v-if="score.type">
                                                <i class="gg-play-list" />{{ score.type }}
                                            </div>
                                            <div class="tag" v-if="score.era">
                                                <i class="gg-time" />{{ score.era }}
                                            </div>
                                            <div class="tag" v-if="score.genre">
                                                <i class="gg-music" />{{ score.genre }}
                                            </div>
                                            <div class="tag" v-if="score.severity">
                                                <i class="gg-arrows-v" />{{ score.severity }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="two columns file-download">
                                        <a :href="`storage/${score.file_path}`" target="_blank">
                                            <i class="gg-file-document"></i>
                                        </a>
                                    </div>
                                </div>
                            </router-link>
                        </li>
                    </ul>

                    <div v-else class="empty-state">
                        Keine Noten gefunden.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import Filters from '../Search/Filters';
import Loader from '../Loader';

export default {
    name: 'ScoreList',
    components: {Loader, Filters},
    computed: {
        ...mapState({
            scores: state => state.score.items,
            selectedFilters: state => state.filters.selectedFilters
        })
    },
    data () {
        return {
            search: null,
            loading: false
        }
    },
    mounted () {
        this.loading = true;

        this.$store.dispatch('score/fetch')
            .then(() => this.loading = false);
    },
    methods: {
        submitSearch () {
            this.loading = true;

            this.$store.dispatch('score/filter', {
                search: this.search,
                filters: this.selectedFilters
            }).then(() => this.loading = false);
        }
    }
}
</script>

<style scoped lang="scss">
.score-list {
    .list-results {
        ul {
            margin-top: 1rem;
            list-style: none;

            li {
                border: 0.1rem solid lightgrey;
                border-radius: 1rem;
                padding: 1.5rem;
                margin-bottom: 1rem;

                &:hover {
                    border-color: #33C3F0;
                }

                > a {
                    text-decoration: none;
                    color: inherit;
                }

                h2 {
                    font-size: 2rem;
                    font-weight: bold;
                    margin-bottom: 0.5rem;
                }

                .row {
                    align-items: stretch;
                    display: flex;
                }

                .tag-list {
                    display: flex;
                    margin-top: 0.5rem;

                    .tag {
                        background: lighten(#33C3F0, 30);
                        font-weight: bold;
                        font-size: 0.8em;
                        padding: 0.25rem 0.75rem;
                        border-radius: 1rem;
                        margin-right: 0.5rem;
                        display: flex;
                        align-items: center;

                        i {
                            margin-right: 0.25em;
                            transform: scale(0.8);
                        }
                    }
                }

                .file-download {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            }
        }
    }
}
</style>
