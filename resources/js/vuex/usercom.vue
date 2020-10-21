<template>
    <div>
        <h1>This is user com.</h1>
        <h5>the counter is:{{counter}}</h5>
        <div>
            <comA></comA>
        </div>
        <div>
            <comB></comB>
        </div>
        <div>
            <comC></comC>
        </div>
        <Button type="primary" @click="changeTheCounter">Change Counter</Button>
    </div>
</template>
<script>
    import comA from './comA'
    import comB from './comB'
    import comC from './comC'
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {

            }
        },
        computed:{
            ...mapGetters({
                'counter': 'getCounter'
            })
        },
        methods:{
            changeTheCounter(){
                this.$store.dispatch('changeCounterAction',1);
                // return this.$store.commit('changeCounter',1);
            }
        },
        components:{
            comA,
            comB,
            comC,
        }
    }
</script>
