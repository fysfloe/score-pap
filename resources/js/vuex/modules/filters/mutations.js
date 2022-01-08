export default {
    FETCH(state, filters) {
        state.filters = filters;
    },
    UPDATE(state, selectedFilters) {
        state.selectedFilters = selectedFilters;
    }
}
