<template>
    <div>
        <div class="table-responsive text-nowrap">
            <p class="m-1" v-if="isCreatePermitted">Table <Button @click="addModal=true"><Icon type="md-add"/>Add Row</Button></p>
            <table class="table table-bordered">
                <thead>
                <tr class="">
                    <th scope="col">Id</th>
                    <th scope="col">Tag</th>
                    <th scope="col">created_at</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr class="" v-for="(tag,i) in tags" :key="i">
                    <td class="">{{tag.id}}</td>
                    <td class="">{{tag.tagName}}</td>
                    <td class="">{{tag.created_at}}</td>
                    <td class="">
                        <Button v-if="isUpdatePermitted" type="info" @click="showEditTag(tag,i)">Edit</Button>
                        <Button v-if="isDeletePermitted" type="error" @click="showDeletingModal(tag,i)" :isloading="tag.isDeleting">Delete</Button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!--Tag adding modal-->
        <Modal
            v-model="addModal"
            :mask-closable="false"
            :closable="false"
            title="Add Tag">
            <Input v-model="data.tagName" placeholder="Add Tagname"/>

            <div slot="footer">
                <Button type="default" @click="addModal=false">Close</Button>
                <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding? 'Adding...':'Add Tag'}}</Button>
            </div>
        </Modal>
        <!--Tag editing modal-->
        <Modal
            v-model="editModal"
            :mask-closable="false"
            :closable="false"
            title="Edit Tag">
            <Input v-model="editData.tagName" placeholder="Add tagname"/>

            <div slot="footer">
                <Button type="default" @click="editModal=false">Close</Button>
                <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding? 'Editing...':'Edit Tag'}}</Button>
            </div>
        </Modal>

        <delModal></delModal>
    </div>
</template>
<!--<style>-->
<!--    td:nth-child(2) {-->
<!--        line-height: 2em;-->
<!--    }-->
<!--    td{-->
<!--        line-height: 2em !important;-->
<!--    }-->
<!--</style>-->
<script>
    import delModal from '../components/deleteModal.vue'
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {
                data:{
                    tagName:''
                },
                addModal:false,
                isAdding:false,
                tags:[],
                editModal:false,
                editData:{
                    'tagName':''
                },
                index:-1,
                deleteModal:false,
                delTag:[],
                delIndex:''
            }
        },
        methods:{
            async addTag(){
                // if(this.data.tagName.trim() == "") return this.e('Empty TagName not acceptable');
                const res = await this.callApi('post','app/create_tag',this.data);
                if(res.status === 201){
                    this.tags.unshift(res.data);
                    this.s('Tag Added Successfully');
                    this.addModal = false;
                    this.data.tagName = '';
                }else{
                    if(res.status===422){
                        if(res.data.errors.tagName){
                            this.i(res.data.errors.tagName[0]);
                        }
                    }else{
                        this.swr();
                    }
                }
            },
            async editTag(){
                // if(this.data.tagName.trim() == "") return this.e('Empty TagName not acceptable');
                const res = await this.callApi('post','app/edit_tag',this.editData);
                if(res.status === 200){
                    this.s('Tag Edited Successfully');
                    this.editModal = false;
                    this.tags[this.index].tagName = this.editData.tagName;
                }else{
                    if(res.status===422){
                        if(res.data.errors.tagName){
                            this.i(res.data.errors.tagName[0]);
                        }
                    }else{
                        this.swr();
                    }
                }
            },
            showEditTag(tag,index){
                let Obj = {
                    id:tag.id,
                    tagName:tag.tagName
                }
                this.editData = Obj;
                this.editModal = true;
                this.index = index;
            },
            showDeletingModal(tag,index){
                const delModalObj = {
                    showDeleteModal:true,
                    delUrl:'app/delete_tag',
                    data:tag,
                    delIndex:index,
                    isDeleted:false
                }
                this.$store.commit('setDeletingModalObj',delModalObj);
            }
        },


        async created() {
            const res = await this.callApi('get','app/get_tag');
            if(res.status === 200){
                this.tags = res.data;
            }else{
                this.swr();
            }
            console.log(this.getUser);
        },
        components:{
            delModal
        },
        computed:{
            ...mapGetters(['getDelModalObj','getUser'])
        },
        watch:{
            getDelModalObj(Obj){
                console.log(Obj)
                if(Obj.isDeleted){
                    console.log(Obj.delIndex);
                    this.tags.splice(Obj.delIndex,1);
                }
            }
        }

    }
</script>
