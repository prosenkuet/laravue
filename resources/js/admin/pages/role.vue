<template>
    <div>
        <div class="table-responsive text-nowrap keycontent">
            <p class="m-1">Role Managment <Button @click="addModal=true"><Icon type="md-add"/>Add Row</Button></p>
            <div class="tabKeyContent">
                <table class="table table-bordered">
                    <thead>
                    <tr class="">
                        <th scope="col">Id</th>
                        <th scope="col">Role</th>
                        <th scope="col">created_at</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(role,i) in roles" :key="i" @click="showDetailsKeyContent(role,i)">
                        <th scope="row">{{role.id}}</th>
                        <td class="">{{role.roleName}}</td>
                        <td class="">{{role.created_at}}</td>
                        <td class="" v-on:click.stop="">
                            <Button type="info" @click="showEditUser(role,i)">Edit</Button>
                            <Button type="error" @click="showDeletingModal(role,i)">Delete</Button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="detailsKeyContent" v-if="closeDetailsKeyContentVar">
                    <div style="position: absolute;top:0px;right:0px"><i @click="closeDetailsKeyContent" class="fa fa-window-close fa-2x" aria-hidden="true"></i></div>
                    <table>
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>Prosenjit</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>Prosenjit</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>Prosenjit</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>Prosenjit</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>Prosenjit</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>Prosenjit</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>Prosenjit</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!--Tag adding modal-->
        <Modal
            v-model="addModal"
            :mask-closable="false"
            :closable="false"
            title="Add Roles">
            <div class="mt-1">
                <Input type="text" v-model="data.roleName" placeholder="Name"/>
            </div>


            <div slot="footer">
                <Button type="default" @click="addModal=false">Close</Button>
                <Button type="primary" @click="addAdmin">Add Role</Button>
            </div>
        </Modal>
        <!--Tag editing modal-->
        <Modal
            v-model="editModal"
            :mask-closable="false"
            :closable="false"
            title="Edit User">
            <div class="mt-1">
                <Input type="text" v-model="editData.fullName" placeholder="Name"/>
            </div>
            <div class="mt-1">
                <Input type="email" v-model="editData.email" placeholder="Email"/>
            </div>
            <div class="mt-1">
                <Input v-model="editData.password" type="password" password placeholder="Password" style="min-width: 200px" />
            </div>
            <div class="mt-1">
                <Select v-model="editData.userType" placeholder="Select Admin type">
                    <Option value="Admin">Admin</Option>
                    <Option value="Editor">Editor</Option>
                    <Option value="User">User</Option>
                </Select>
            </div>

            <div slot="footer">
                <Button type="default" @click="editModal=false">Close</Button>
                <Button type="primary" @click="editUser" >Edit User</Button>
            </div>
        </Modal>

        <delModal></delModal>
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
    import delModal from '../components/deleteModal.vue'
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {
                data:{
                    roleName:'',

                },
                addModal:false,
                isAdding:false,
                roles:[],
                editModal:false,
                editData:{
                    'roleName':'',
                },
                index:-1,
                deleteModal:false,
                delTag:[],
                delIndex:'',
                detailsKeyContents: 'none',
                closeDetailsKeyContentVar : false
            }
        },
        methods:{
            async addAdmin(){
                if(this.data.roleName.trim() == "") return this.e('Empty Role is not acceptable');
                const res = await this.callApi('post','app/create_role',this.data);
                if(res.status === 201){
                    this.roles.unshift(res.data);
                    this.s('Role Added Successfully');
                    this.addModal = false;
                }else{
                    if(res.status===422){
                        console.log(res.data);
                        for(let err in res.data.errors){
                            this.e(res.data.errors[err][0])
                        }
                    }else{
                        this.swr();
                    }
                }
            },
            async editUser(){
                if(this.editData.roleName.trim() == "") return this.e('Empty Role is not acceptable');
                const res = await this.callApi('post','app/edit_user',this.editData);
                if(res.status === 200){
                    this.s('User Edited Successfully');
                    this.editModal = false;
                    this.rolse[this.index].roleName = this.editData.roleName;
                    console.log(this.data);
                }else{
                    if(res.status===422){
                        console.log(res.data);
                        for(let err in res.data.errors){
                            this.e(res.data.errors[err][0])
                        }
                    }else{
                        this.swr();
                    }
                }
            },
            showEditUser(user, index){
                let Obj = {
                    id:user.id,
                    fullName:user.fullName,
                    email:user.email,
                    userType:user.userType,
                }
                this.editData = Obj;
                this.editModal = true;
                this.index = index;
            },
            showDetailsKeyContent(user,index){
                // this.detailsKeyContents = 'block'
                this.closeDetailsKeyContentVar = true
            },
            closeDetailsKeyContent(){
                // this.detailsKeyContents= 'none'
                this.closeDetailsKeyContentVar = false
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
            const res = await this.callApi('get','app/get_roles');
            if(res.status === 200){
                this.roles = res.data;
            }else{
                this.swr();
            }
        },
        components:{
            delModal
        },
        computed:{
            ...mapGetters(['getDelModalObj']),

            styling: function() {
                return {
                    display: this.detailsKeyContents,
                }
            }

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
