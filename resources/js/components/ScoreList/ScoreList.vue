<template>
    <div class="score-list">
        <h1>Notenliste</h1>

        <div class="form-group">
            <label for="search">Suche</label>
            <input type="text" name="search" id="search" v-model="search" placeholder="Suche..." />
        </div>
        <button type="submit" class="button-primary" @click="submitSearch">Suchen</button>

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
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'ScoreList',
    computed: {
        ...mapState({
            scores: state => state.score.items
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
            this.$store.dispatch('score/fetch', {
                search: this.search
            })
        }
    }
}
</script>

<style scoped lang="scss">
.score-list {
    ul {
        margin-top: 1rem;
        list-style: none;

        li {
            h2 {
                font-size: 2rem;
                font-weight: bold;
                margin-bottom: 0;
            }
        }
    }
}
</style>
