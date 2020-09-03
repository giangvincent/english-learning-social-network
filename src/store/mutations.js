export default {
    CHANGE_TAB: function (state, payload) {
        state.currentTab = payload
    },
    SET_PAGE: function (state, payload) {
        state.currentPage = payload
    }
}