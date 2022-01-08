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
                            <h2>{{ score.title }}</h2>
                            <span>{{ score.author }}</span>

                            <div class="tag-list">
                                <div class="tag" v-if="score.lineup">{{ score.lineup }}</div>
                                <div class="tag" v-if="score.type">{{ score.type }}</div>
                                <div class="tag" v-if="score.era">{{ score.era }}</div>
                                <div class="tag" v-if="score.genre">{{ score.genre }}</div>
                                <div class="tag" v-if="score.severity">{{ score.severity }}</div>
                            </div>
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
                &:first-child {
                    border-top: 0.1rem solid lightgray;
                }

                border-bottom: 0.1rem solid lightgray;
                padding: 1.5rem 0;
                margin-bottom: 0;

                h2 {
                    font-size: 2rem;
                    font-weight: bold;
                    margin-bottom: 0.5rem;
                }

                .tag-list {
                    display: flex;
                    margin-top: 0.5rem;

                    .tag {
                        //color: white;
                        background: lightgray;
                        font-weight: bold;
                        font-size: 0.8em;
                        border: 0.2rem solid lightgray;
                        padding: 0.25rem;
                        border-radius: 1rem;
                        margin-right: 0.5rem;
                    }
                }
            }
        }
    }
}
</style>
