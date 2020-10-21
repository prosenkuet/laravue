import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state:{
        counter:1000,
        delModalObj:{
            showDeleteModal:false,
            delUrl:'',
            data:null,
            delIndex:-1,
            isDeleted:false
        },
        user:false,
        permission:null
    },
    getters: {
        getCounter(state){
            return state.counter;
        },
        getDelModalObj(state){
            return state.delModalObj;
        },
        getUser(state){
            return state.user;
        },
        getUserPermission(state){
            return state.permission;
        }
    },
    mutations:{
        changeCounter(state,data) {
            state.counter +=data;
        },
        setDeleteModal(state,data){
            const delModalObj = {
                showDeleteModal:false,
                delUrl:'',
                data:null,
                delIndex:-1,
                isDeleted:data
            };
            state.delModalObj = delModalObj;
        },
        setDeletingModalObj(state,data){
            state.delModalObj = data;
        },
        setUpdateUser(state,data){
            state.user = data;
        },
        setUserPermission(state,data){
            state.permission = data;
        }
    },
    actions:{
        changeCounterAction({commit},data){
            commit('changeCounter',data);
        }
    }
})

