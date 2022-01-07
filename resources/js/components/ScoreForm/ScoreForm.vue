<template>
    <div class="score-form">
        <h1>Noten erstellen</h1>

        <div class="form-group">
            <label for="file">Datei</label>
            <input type="file" name="file" id="file" />
        </div>
        <div class="form-group">
            <label for="title">Titel</label>
            <input type="text" name="title" id="title" v-model="title" />
        </div>
        <div class="form-group">
            <label for="author">Komponist / Autor</label>
            <input type="text" name="author" id="author" v-model="author" />
        </div>
        <div class="form-group">
            <label for="lineup">Besetzung</label>
            <input type="text" name="lineup" id="lineup" v-model="lineup" />
        </div>
        <div class="form-group">
            <label for="type">Typ</label>
            <input type="text" name="type" id="type" v-model="type" />
        </div>
        <div class="form-group">
            <label for="era">Epoche</label>
            <input type="text" name="era" id="era" v-model="era" />
        </div>
        <div class="form-group">
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" v-model="genre" />
        </div>
        <div class="form-group">
            <label for="severity">Schwierigkeitsgrad</label>
            <input type="text" name="severity" id="severity" v-model="severity" />
        </div>
        <button type="submit" class="button-primary" @click="submit">Absenden</button>
    </div>
</template>

<script>
export default {
    name: 'ScoreForm',
    data () {
        return {
            //file: null,
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
        submit () {
            this.$store.dispatch('score/add', this.$data)
        }
    }
}
</script>

<style scoped>

</style>
