export default {
    FETCH(state, scores) {
        state.items = scores;
    },
    SHOW(state, score) {
        state.score = score;
    }
}
