<template>
<div class="filters">
    <div v-for="(filterGroup, key) in filterOptions">
        <strong>{{ filterGroup.name }}</strong>
        <ul>
            <li v-for="filterValue in filterGroup.values">
                <label>
                    <input type="checkbox" :value="filterValue" @change="toggleFilterValue($event, key, filterValue)" />
                    {{ filterValue }}
                </label>
            </li>
        </ul>
    </div>
</div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'Filters',
    computed: {
        ...mapState({
            filterOptions: state => state.filters.filters
        })
    },
    data () {
        return {
            filters: {}
        }
    },
    mounted () {
        this.$store.dispatch('filters/fetch');
    },
    methods: {
        toggleFilterValue (event, key, filterValue) {
            if (!this.filters.hasOwnProperty(key)) {
                this.filters[key] = [];
            }

            let existingKey = this.filters[key].indexOf(filterValue);

            if (event.target.checked && -1 === existingKey) {
                this.filters[key].push(filterValue);
            } else if (!event.target.checked && -1 !== existingKey) {
                this.filters[key].splice(existingKey, 1);
            }

            this.$store.commit('filters/UPDATE', this.filters);

            this.$emit('filter-update');
        }
    }
}
</script>

<style scoped lang="scss">
.filters {
    ul {
        list-style: none;

        li {
            margin-bottom: 0;
        }

        label {
            font-weight: normal;
            margin-bottom: 0;
        }
    }
}
</style>
