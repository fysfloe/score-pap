<template>
    <div class="score-form">
        <form @submit.prevent="submit">
            <div class="form-group">
                <label for="file">Datei *</label>
                <input type="file" name="file" id="file" @change="uploadFile" :required="!score || !score.file_path" />

                <a v-if="score && file" :href="`/storage/${file.name}`" target="_blank">
                    <i class="gg-file-document"></i>
                </a>
            </div>

            <div class="row">
                <div class="six columns">
                    <div class="form-group">
                        <label for="title">Titel *</label>
                        <input type="text" name="title" id="title" v-model="title" required />
                    </div>
                    <div class="form-group">
                        <label for="author">Komponist / Autor *</label>
                        <input type="text" name="author" id="author" v-model="author" required />
                    </div>
                    <div class="form-group">
                        <label for="lineup">Besetzung</label>
                        <input type="text" name="lineup" id="lineup" v-model="lineup" />
                    </div>
                    <div class="form-group">
                        <label for="type">Typ</label>
                        <input type="text" name="type" id="type" v-model="type" />
                    </div>
                </div>
                <div class="six columns">
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
                </div>
            </div>

            <button type="submit" class="button-primary">Absenden</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'ScoreForm',
    props: {
        score: {
            type: Object
        }
    },
    data () {
        return {
            id: null,
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
    watch: {
        score () {
            this.id = this.score.id;
            this.title = this.score.title;
            this.author = this.score.author;
            this.lineup = this.score.lineup;
            this.type = this.score.type;
            this.era = this.score.era;
            this.genre = this.score.genre;
            this.severity = this.score.severity;
            this.file.name = this.score.file_path;
        }
    },
    methods: {
        submit () {
            this.$emit('submit', this.$data);
        },
        uploadFile (event) {
            const file = event.target.files[0];
            this.file.name = file.name;

            const reader = new FileReader();

            reader.onload = e => this.file.data = e.target.result;
            reader.readAsDataURL(file);

            if (!this.title) {
                this.title = this.file.name;
            }
        }
    }
}
</script>

<style scoped>
input {
    width: 100%;
}
</style>
