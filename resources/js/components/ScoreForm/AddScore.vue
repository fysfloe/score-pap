<template>
    <div class="add-score">
        <h1>Noten erstellen</h1>
        <score-form @submit="submit" />
    </div>
</template>

<script>
import ScoreForm from './ScoreForm';

export default {
    name: 'AddScore',
    components: {ScoreForm},
    data () {
        return {
            file: {
                name: null,
                data: null
            },
            title: null,
            author: null,
            lineup: null,
            type: null,
            era: null,
            genre: null,
            severity: null
        }
    },
    methods: {
        submit (score) {
            this.$store.dispatch('score/add', score)
                .then(() => this.$router.push('/'))
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>

