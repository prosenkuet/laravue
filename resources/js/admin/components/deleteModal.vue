<template>
    <div>
        <Modal :value="getDelModalObj.showDeleteModal" width="360" :mask-closable="false">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align:center">
                <p>Are you sure to delete this line?</p>
            </div>
            <div slot="footer">
                <Button type="default" @click="closeModal">Close</Button>
                <Button type="error" size="large"  @click="deleteLine">Delete</Button>
            </div>
        </Modal>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        computed:{
            ...mapGetters(['getDelModalObj'])
        },
        methods:{
            async deleteLine(){
                // this.$set(tag,'isDeleting',true);
                const res = await this.callApi('post',this.getDelModalObj.delUrl,this.getDelModalObj.data);
                // this.deleteModal = false;
                if(res.status === 200){
                    this.$store.commit('setDeleteModal',true)
                    // this.tags.splice(this.delIndex,1);
                }else{
                    this.$store.commit('setDeleteModal',false)
                }
            },
            closeModal(){
                this.$store.commit('setDeleteModal',false)
            }
        }
    }
</script>
