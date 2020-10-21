import {mapGetters} from 'vuex'
export default {
    data(){
        return {

        }
    },
    methods:{
        async callApi(method,url,dataObj){
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            }catch (e) {
                return e.response
            }
        },
        i (desc,title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s (desc,title="Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w (desc,title="Opps!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e (desc,title="Danger") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr (desc,title="Opps!") {
            this.$Notice.error({
                title: title,
                desc: 'Something went wrong'
            });
        },
        checkForPermission(key){
            for(let d of this.userPermission){
                if(d.name == this.$route.name){
                    return d[key];
                }
            }
        }
    },
    computed:{
        ...mapGetters({
            'userPermission':'getUserPermission'
        }),
        isReadPermitted(){
            return this.checkForPermission('read');
        },
        isCreatePermitted(){
            return this.checkForPermission('create');
        },
        isUpdatePermitted(){
            return this.checkForPermission('update');
        },
        isDeletePermitted(){
            return this.checkForPermission('delete');
        }
    }
}
