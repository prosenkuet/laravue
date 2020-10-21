<template>
    <div>
        <div class="table-responsive text-nowrap keycontent">
            <div class="row m-2">
                <div class="col-md-6">
                    Role
                    <Select v-model="data.id" placeholder="Select Admin type" class="col-md-6" @on-change="changeAdmin">
                        <Option v-for="(role,i) in roles" :key="i" :value="role.id">{{role.roleName}}</Option>
                    </Select>
                    <Button type="primary" @click="assignRole">Assign</Button>
                </div>
                <div class="col-md-6">
                    Resources
                    <Select v-model="data.resourceid" filterable placeholder="Select Resource Name" class="col-md-6">
                        <Option v-for="(resource,i) in dbResources" :key="i" :value="resource.id">{{resource.resourceName}}</Option>
                    </Select>
                    <Button type="primary" @click="addResource"><Icon type="md-add"/>Add Resources</Button>
                </div>
            </div>
            <div class="tabKeyContent">
                <table class="table table-striped">
                    <thead>
                    <tr class="">
                        <th scope="col">Resource</th>
                        <th scope="col">Create</th>
                        <th scope="col">Read</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(role,i) in resources" :key="i" >
                        <td class="">{{role.resourceName}}</td>
                        <td class=""><Checkbox v-model="role.create" :true-value="1" :false-value="''"></Checkbox></td>
                        <td class=""><Checkbox v-model="role.read" :true-value="1" :false-value="''"></Checkbox></td>
                        <td class=""><Checkbox v-model="role.update" :true-value="1" :false-value="''"></Checkbox></td>
                        <td class=""><Checkbox v-model="role.delete" :true-value="1" :false-value="''"></Checkbox></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <!--Tag editing modal-->
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
                    id:null
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
                resources:[
                    {resourceName:'Tags',create:true,read:true,update:false,delete:false,name:'tags'},
                    {resourceName:'Category',create:false,read:false,update:false,delete:false,name:'category'},
                    {resourceName:'Admin User',create:false,read:false,update:false,delete:false,name:'adminusers'},
                    {resourceName:'Role Management',create:false,read:false,update:false,delete:false,name:'role'},
                    {resourceName:'Role Assign',create:false,read:false,update:false,delete:false,name:'assignrole'},
                    {resourceName:'Home',create:false,read:false,update:false,delete:false,name:'/'},
                ],
                defResource:[
                    {resourceName:'Tags',create:1,read:1,update:0,delete:0,name:'tags'},
                    // {resourceName:'Category',create:false,read:false,update:false,delete:false,name:'category'},
                    // {resourceName:'Admin User',create:false,read:false,update:false,delete:false,name:'adminusers'},
                    // {resourceName:'Role Management',create:false,read:false,update:false,delete:false,name:'role'},
                    // {resourceName:'Role Assign',create:false,read:false,update:false,delete:false,name:'assignrole'},
                    // {resourceName:'Home',create:false,read:false,update:false,delete:false,name:'/'},
                    // {resourceName:'LDC Services',create:false,read:false,update:false,delete:false,name:'ldcservices'},
                    // {resourceName:'ItemCode',create:false,read:false,update:false,delete:false,name:'itemcode'},
                    // {resourceName:'Eloquent ORM',create:false,read:false,update:false,delete:false,name:'eloquentorm'},
                    // {resourceName:'Sys Route',create:false,read:false,update:false,delete:false,name:'sysroutepermission'},
                ],
                dbResources:[],
                resourceid:'',
            }
        },
        methods:{
            async assignRole(){
                let data = JSON.stringify(this.resources)
                const res = await this.callApi('post','app/assign_roles',{permission:data,id:this.data.id});
                if(res.status===200){
                    this.i("Permission assign successfully");
                    let index = this.roles.findIndex(role1=>role1.id == this.data.id);
                    this.roles[index].permission = data;
                }else{
                    this.swr();
                }
            },
            changeAdmin(){
                let id = this.data.id;
                let index = this.roles.findIndex(role1=>role1.id == id);
                let permission = this.roles[index].permission;
                if(!permission){
                    this.resources = this.defResource;
                }else{
                    this.resources = JSON.parse(permission);
                }
            },
            addResource(){
                let rid = this.data.resourceid;
                let index = this.dbResources.findIndex(role1=>role1.id == rid);
                let resource = this.dbResources[index];
                if(!resource){

                }else{
                    this.resources.push(resource);
                }
                console.log(this.resources);
            }
        },


        async created() {
            const [res,resResource] = await Promise.all([
                this.callApi('get','app/get_roles'),
                this.callApi('get','app/get_resources'),
            ]);
            if(res.status === 200){
                this.roles = res.data;
                if(res.data.length){
                    this.data.id = res.data[0].id
                    if(res.data[0].permission){
                        this.resources = JSON.parse(res.data[0].permission);
                    }
                }
            }else{
                this.swr();
            }
            if(resResource.status === 200){
                this.dbResources = resResource.data;
                console.log(this.dbResources);
            }else{
                this.swr();
            }

        },

    }
</script>
