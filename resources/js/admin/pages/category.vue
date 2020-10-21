<template>
    <div>
        <div class="table-responsive text-nowrap">
            <p class="m-1">Table <Button @click="addModal=true"><Icon type="md-add"/>Add Row</Button></p>
            <table class="table table-striped col-md-12">
                <thead>
                <tr class="row m-0">
                    <th class="col-md-2">Id</th>
                    <th class="col-md-3">Category Name</th>
                    <th class="col-md-3">Image</th>
                    <th class="col-md-2">created_at</th>
                    <th class="col-md-2">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr class="row m-0" v-for="(category,i) in categoryList" :key="i">
                    <td class="col-md-2">{{category.id}}</td>
                    <td class="col-md-3">{{category.categoryName}}</td>
                    <td class="col-md-3 table-image"><img v-bind:src="category.iconImage"/></td>
                    <td class="col-md-2">{{category.created_at}}</td>
                    <td class="col-md-2">
                        <Button type="info" @click="showEditTag(category,i)">Edit</Button>
                        <Button type="error" @click="showDeletingModal(category,i)" >Delete</Button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--Tag Deleting Modal-->
        <delModal></delModal>
        <!--Tag adding modal-->
        <Modal
            v-model="addModal"
            :mask-closable="false"
            :closable="false"
            title="Add Category">
            <Input v-model="data.categoryName" placeholder="Add Category Name"/>
            <div class="mt-2"></div>
            <Upload
                multiple
                type="drag"
                :on-success="handleSuccess"
                :on-error="handleError"
                :format="['jpg','jpeg','png']"
                :max-size="2048"
                :on-format-error="handleFormatError"
                :on-exceeded-size="handleMaxSize"
                :headers="{'x-csrf-token': token,'X-Requested-With': 'XMLHttpRequest'}"
                action="app/upload">
                <div style="padding: 20px 0">
                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                    <p>Click or drag files here to upload</p>
                </div>
            </Upload>

            <div class="demo-upload-list" v-if="data.iconImage">
                <img :src="`/uploads/${data.iconImage}`">
                <div class="demo-upload-list-cover">
                    <Icon type="ios-trash-outline" @click="deleteImage(data.iconImage)"></Icon>
                </div>
            </div>
            <div slot="footer">
                <Button type="default" @click="addModal=false">Close</Button>
                <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding? 'Adding...':'Add Category'}}</Button>
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
    </div>
</template>
<style>
    td:nth-child(2) {
        line-height: 2em;
    }
    td{
        line-height: 2em !important;
    }
</style>
<script>
    import {mapGetters} from "vuex";
    import delModal from '../components/deleteModal.vue'
    export default {
        data(){
            return {
                data:{
                    categoryName:'',
                    iconImage:''
                },
                addModal:false,
                isAdding:false,
                categoryList:[],
                editModal:false,
                editData:{
                    'tagName':''
                },
                index:-1,
                token:''
            }
        },
        methods:{
            async addCategory(){
                if(this.data.categoryName.trim() == "") return this.e('Empty Category is not acceptable');
                if(this.data.iconImage.trim() == "") return this.e('Image attachment is required');

                const res = await this.callApi('post','app/create_category',this.data);
                if(res.status === 201){
                    this.tags.unshift(res.data);
                    this.s('Category Added Successfully');
                    this.addModal = false;
                    this.data.categoryName = '';
                }else{
                    if(res.status===422){
                        if(res.data.errors.categoryName){
                            this.i(res.data.errors.categoryName[0]);
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
            // async deleteTag(tag,index){
            //     if(!confirm('Are you sure to delete this line?')) return;
            //     this.$set(tag,'isDeleting',true);
            //     const res = await this.callApi('post','app/delete_tag',tag);
            //     if(res.status === 200){
            //         this.tags.splice(index,1);
            //     }
            // },
            async deleteImage(item){
                const res = await this.callApi('post','app/delete_image',{'imgName':item});
                if(res.status === 200){
                    this.data.iconImage='';
                }
            },
            handleSuccess (res, file) {
                this.data.iconImage = res;
            },
            handleError (res, file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: file.errors.file[0]
                });
            },
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File ' + file.name + ' is too large, no more than 2M.'
                });
            },
            showDeletingModal(category,index){
                const delModalObj = {
                    showDeleteModal:true,
                    delUrl:'app/delete_category',
                    data:category,
                    delIndex:index,
                    isDeleted:false
                }
                this.$store.commit('setDeletingModalObj',delModalObj);
            }
        },


        async created() {
            this.token = window.Laravel.csrfToken
            const res = await this.callApi('get','app/get_category');
            if(res.status === 200){
                this.categoryList = res.data;
            }else{
                this.swr();
            }
        },
        components:{
            delModal
        },
        computed:{
            ...mapGetters(['getDelModalObj'])
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
<style>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
</style>
