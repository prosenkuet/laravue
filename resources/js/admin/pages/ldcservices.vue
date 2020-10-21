<template>
    <div>
        <div class="table-responsive text-nowrap keycontent">
            <p class="m-1">Table <Button @click="addModal=true"><Icon type="md-add"/>Add Service</Button></p>
            <div class="tabKeyContent">
                <table class="table table-bordered">
                    <thead>
                    <tr class="">
                        <th scope="col">Id</th>
                        <th scope="col">Cost Center</th>
                        <th scope="col">Service Type</th>
                        <th scope="col">Serial No</th>
                        <th scope="col">Provider Name</th>
                        <th scope="col">Contact Person</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Last Renew Date</th>
                        <th scope="col">Next Renew Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Currency</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(service,i) in services" :key="i">
                        <th scope="row">{{service.id}}</th>
                        <td class="">{{service.costcenter}}</td>
                        <td class="">{{service.servicetype}}</td>
                        <td class="">{{service.serialno}}</td>
                        <td class="">{{service.providername}}</td>
                        <td class="">{{service.contactperson}}</td>
                        <td class="">{{service.email}}</td>
                        <td class="">{{service.phone}}</td>
                        <td class="">{{service.lastrenew}}</td>
                        <td class="">{{service.nextrenew}}</td>
                        <td class="">{{service.amount}}</td>
                        <td class="">{{service.currency}}</td>
                        <td class="">{{service.remarks}}</td>
                        <td class="" v-on:click.stop="">
                            <Button type="info" @click="showEditService(service,i)">Edit</Button>
<!--                            <Button type="error" @click="showDeletingModal(user,i)">Delete</Button>-->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Tag adding modal-->
        <Modal
            v-model="addModal"
            :mask-closable="false"
            :closable="false"
            title="Add New Service">
            <div class="mt-1">
                <Input type="text" v-model="data.costcenter" placeholder="Cost Center"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="data.servicetype" placeholder="Service Type"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="data.serialno" placeholder="Serial No"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="data.providername" placeholder="Provider Name"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="data.contactperson" placeholder="Contact Person"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="data.email" placeholder="Email"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="data.phone" placeholder="Phone"/>
            </div>
            <div class="mt-1">
                <date-picker v-model="data.lastrenew" :config="{format: 'YYYY-MM-DD'}" placeholder="Last Renew Date"></date-picker>
            </div>
            <div class="mt-1">
                <date-picker v-model="data.nextrenew" :config="{format: 'YYYY-MM-DD'}" placeholder="Next Renew Date"></date-picker>
            </div>
            <div class="mt-1">
                <Input type="number" v-model="data.amount" placeholder="Amount"/>
            </div>
            <div class="mt-1">
                <Select v-model="data.currency" placeholder="Select Currency">
                    <Option value="BDT">BDT</Option>
                    <Option value="USD">USD</Option>
                    <Option value="EURO">EURO</Option>
                    <Option value="RMB">RMB</Option>
                    <Option value="GBP">GBP</Option>
                    <Option value="HKD">HKD</Option>
                </Select>
            </div>
            <div class="mt-1">
                <Input type="textarea" v-model="data.remarks" placeholder="remarks"/>
            </div>


            <div slot="footer">
                <Button type="default" @click="addModal=false">Close</Button>
                <Button type="primary" @click="addService">Add Service</Button>
            </div>
        </Modal>
        <!--Tag editing modal-->
        <Modal
            v-model="editModal"
            :mask-closable="false"
            :closable="false"
            title="Edit Service">
            <div class="mt-1">
                <Input type="text" v-model="editData.costcenter" placeholder="Cost Center"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="editData.servicetype" placeholder="Service Type"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="editData.serialno" placeholder="Serial No"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="editData.providername" placeholder="Provider Name"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="editData.contactperson" placeholder="Contact Person"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="editData.email" placeholder="Email"/>
            </div>
            <div class="mt-1">
                <Input type="text" v-model="editData.phone" placeholder="Phone"/>
            </div>
            <div class="mt-1">
                <date-picker v-model="editData.lastrenew" :config="{format: 'YYYY-MM-DD'}" placeholder="Last Renew Date"></date-picker>
            </div>
            <div class="mt-1">
                <date-picker v-model="editData.nextrenew" :config="{format: 'YYYY-MM-DD'}" placeholder="Next Renew Date"></date-picker>
            </div>
            <div class="mt-1">
                <Input type="number" v-model="editData.amount" placeholder="Amount"/>
            </div>
            <div class="mt-1">
                <Select v-model="editData.currency" placeholder="Select Currency">
                    <Option value="BDT">BDT</Option>
                    <Option value="USD">USD</Option>
                    <Option value="EURO">EURO</Option>
                    <Option value="RMB">RMB</Option>
                    <Option value="GBP">GBP</Option>
                    <Option value="HKD">HKD</Option>
                </Select>
            </div>
            <div class="mt-1">
                <Input type="textarea" v-model="editData.remarks" placeholder="remarks"/>
            </div>

            <div slot="footer">
                <Button type="default" @click="editModal=false">Close</Button>
                <Button type="primary" @click="editService" >Save</Button>
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
    import delModal from '../components/deleteModal.vue'
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {
                data:{
                    'costcenter':'',
                    'servicetype':'',
                    'serialno':'',
                    'providername':'',
                    'contactperson':'',
                    'email':'',
                    'phone':'',
                    'lastrenew':'',
                    'nextrenew':'',
                    'amount':'',
                    'currency':'',
                    'remarks':''
                },
                addModal:false,
                isAdding:false,
                services:[],
                editModal:false,
                editData:{
                    'costcenter':'',
                    'servicetype':'',
                    'serialno':'',
                    'providername':'',
                    'contactperson':'',
                    'email':'',
                    'phone':'',
                    'lastrenew':'',
                    'nextrenew':'',
                    'amount':'',
                    'currency':'',
                    'remarks':''
                },
                index:-1,
                deleteModal:false,
                delTag:[],
                delIndex:'',
                detailsKeyContents: 'none',
                roles:[]
            }
        },
        methods:{
            async addService(){
                if(this.data.lastrenew.trim() == "") return this.e('Last Renew Date is required');
                if(this.data.nextrenew.trim() == "") return this.e('Next Renew Date is required');
                const res = await this.callApi('post','app/ldcservices',this.data);
                if(res.status === 201){
                    this.services.unshift(res.data);
                    this.s('Service Added Successfully');
                    this.addModal = false;
                    for(var key in this.data){
                        this.data[key]='';
                    }
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
            async editService(){
                if(this.editData.lastrenew.trim() == "") return this.e('Last Renew Date is required');
                if(this.editData.nextrenew.trim() == "") return this.e('Next Renew Date is required');
                const res = await this.callApi('post','app/edit_service',this.editData);
                if(res.status === 200){
                    this.s('Service Edited Successfully');
                    this.editModal = false;
                    this.services[this.index].costcenter = this.editData.costcenter;
                    this.services[this.index].servicetype = this.editData.servicetype;
                    this.services[this.index].serialno = this.editData.serialno;
                    this.services[this.index].providername = this.editData.providername;
                    this.services[this.index].contactperson = this.editData.contactperson;
                    this.services[this.index].email = this.editData.email;
                    this.services[this.index].phone = this.editData.phone;
                    this.services[this.index].lastrenew = this.editData.lastrenew;
                    this.services[this.index].nextrenew = this.editData.nextrenew;
                    this.services[this.index].amount = this.editData.amount;
                    this.services[this.index].currency = this.editData.currency;
                    this.services[this.index].remarks = this.editData.remarks;
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
            showEditService(service, index){
                let Obj = {
                    id:service.id,
                    costcenter:service.costcenter,
                    servicetype:service.servicetype,
                    serialno:service.serialno,
                    providername:service.providername,
                    contactperson:service.contactperson,
                    email:service.email,
                    phone:service.phone,
                    lastrenew:service.lastrenew,
                    nextrenew:service.nextrenew,
                    amount:service.amount,
                    currency:service.currency,
                    remarks:service.remarks
                }
                this.editData = Obj;
                this.editModal = true;
                this.index = index;
            },
        },


        async created() {
            const [res] = await Promise.all([
                this.callApi('get','app/ldcservices'),
            ]);
            console.log(res);
            if(res.status === 200){
                this.services = res.data;
            }else{
                this.swr();
            }
        },

    }
</script>
