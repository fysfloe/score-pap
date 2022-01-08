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
                <div class="list-results">
                    <ul v-if="scores.length > 0">
                        <li v-for="score in scores">
                            <h2>{{ score.title }}</h2>
                            <span>{{ score.author }}</span>
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

export default {
    name: 'ScoreList',
    components: {Filters},
    computed: {
        ...mapState({
            scores: state => state.score.items,
            selectedFilters: state => state.filters.selectedFilters
        })
    },
    data () {
        return {
            search: null
        }
    },
    mounted () {
        this.$store.dispatch('score/fetch')
    },
    methods: {
        submitSearch () {
            this.$store.dispatch('score/filter', {
                search: this.search,
                filters: this.selectedFilters
            })
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
            }
        }
    }
}
</style>
