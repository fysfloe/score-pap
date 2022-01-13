<template>
    <div class="edit-score">
        <h1>Noten bearbeiten</h1>
        <score-form :score="score" @submit="submit" />
    </div>
</template>

<script>
import ScoreForm from './ScoreForm';
import {mapState} from 'vuex';

export default {
    name: 'EditScore',
    components: {ScoreForm},
    computed: {
        ...mapState({
            score: state => state.score.score
        })
    },
    mounted () {
        this.$store.dispatch('score/show', this.$route.params.id);
    },
    methods: {
        submit (score) {
            this.$store.dispatch('score/edit', score)
                .then(() => this.$router.push('/'))
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
