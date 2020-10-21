<template>
    <div>
        <div class="table-responsive text-nowrap keycontent">
            <p class="m-1">Table <Button @click="addModal=true"><Icon type="md-add"/>Create Full Item</Button></p>
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
            title="Create Full Item">
            <div class="mt-1">
                <label>Item Type</label>
                <Select v-model="data.itemtypecode" filterable  placeholder="Select Item Type" @on-change="dynamicForm">
<!--                    <Option value=""></Option>-->
                    <Option value="RAM">RAM</Option>
                    <Option value="HDD">HDD</Option>
                    <Option value="Keyboard">Keyboard</Option>
                    <Option value="Mouse">Mouse</Option>
                    <Option value="Lan_adapter">Lan_adapter</Option>
                    <Option value="Wireless_adapter">Wireless_adapter</Option>
                    <Option value="Monitor_adapter">Monitor_adapter</Option>
                    <Option value="Laptop_adapter">Laptop_adapter</Option>
                    <Option value="MiniPC_adapter">MiniPC_adapter</Option>
                    <Option value="Laptop_battery">Laptop_battery</Option>
                    <Option value="Laptop_keyboard">Laptop_keyboard</Option>
                    <Option value="Power_supply">Power_supply</Option>
                    <Option value="Pendrive">Pendrive</Option>
                    <Option value="Attendence_machine_battery">Attendence_machine_battery</Option>
                    <Option value="Connector">Connector</Option>
                    <Option value="Multi_plug">Multi_plug</Option>
                </Select>
            </div>
            <div v-if="data.itemtypecode==='RAM'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Capacity<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode05" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Stick Type</label>
                    <Input type="text" v-model="data.subcode02" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Cell Type</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Clock Frequency</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='HDD'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Type<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode02" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Capacity</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Mouse'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Type<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode02" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Keyboard'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Type<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode02" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Keyboard'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Type<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode02" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Lan_adapter'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Type<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode02" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Wireless_adapter'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Type<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode02" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Monitor_adapter'">
                <div class="mt-1">
                    <label>Brand</label>
                    <Input type="text" v-model="data.subcode02" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='MiniPC_adapter'">
                <div class="mt-1">
                    <label>Brand</label>
                    <Input type="text" v-model="data.subcode02" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Laptop_adapter'">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label>Laptop Model<span class="required"> *</span></label>
                        <Input type="text" v-model="data.subcode01"  placeholder=""/>
                    </div>
                    <div class="col-md-6">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode02" placeholder=""/>
                    </div>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Laptop_battery'">
                <div class="mt-1">
                    <label>Brand</label>
                    <Input type="text" v-model="data.subcode01" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode04" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Laptop_keyboard'">
                <div class="mt-1">
                    <label>Brand</label>
                    <Input type="text" v-model="data.subcode01" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode02" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Power_supply'">
                <div class="mt-1">
                    <label>Brand</label>
                    <Input type="text" v-model="data.subcode01" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode02" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Pendrive'">
                <div class="mt-1">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode01" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Size</label>
                    <Input type="text" v-model="data.subcode02" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Attendence_machine_battery'">
                <div class="mt-1">
                        <label>Brand</label>
                        <Input type="text" v-model="data.subcode01" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Serial No</label>
                    <Input type="text" v-model="data.subcode02" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Connector'">
                <div class="mt-1">
                    <label>Brand</label>
                    <Input type="text" v-model="data.subcode01" placeholder=""/>
                </div>
                <div class="mt-1">
                    <label>Model</label>
                    <Input type="text" v-model="data.subcode03" placeholder=""/>
                </div>
            </div>
            <div v-if="data.itemtypecode==='Multi_plug'">
                <div class="mt-1">
                    <label>Product Name</label>
                    <Input type="text" v-model="data.subcode01" placeholder=""/>
                </div>
            </div>

            <div slot="footer">
                <Button type="default" @click="addModal=false">Close</Button>
                <Button type="primary" @click="addService">Create</Button>
            </div>
        </Modal>
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
                    'itemtypecode':'',
                    'subcode01':'',
                    'subcode02':'',
                    'subcode03':'',
                    'subcode04':'',
                    'subcode05':'',
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
                field:{
                  type: {
                      'RAM':[
                          {
                              'dbname': 'subcode1',
                              'uiname': 'Capacity',
                              'inputtype': 'text',
                              'placeholder': ''
                          },
                          {
                              'dbname': 'subcode2',
                              'uiname': 'Type',
                              'inputtype': 'text',
                              'placeholder': ''
                          },
                      ],
                      'HDD':[
                          {
                              'dbname': 'subcode1',
                              'uiname': 'Capacity',
                              'inputtype': 'text',
                              'placeholder': ''
                          },
                          {
                              'dbname': 'subcode2',
                              'uiname': 'Brand',
                              'inputtype': 'text',
                              'placeholder': ''
                          },
                      ],
                  }
                },
                addModal:false,
                isAdding:false,
                services:[],
                editModal:false,
                index:-1,
                deleteModal:false,
                delTag:[],
                delIndex:'',
                detailsKeyContents: 'none',
                roles:[],
                HtmlField:''
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
            dynamicForm(){
                let itemtypecode = this.data.itemtypecode;
                let fieldsArray;
                for(var key in this.field.type){
                    if(key == itemtypecode){
                        fieldsArray = this.field.type[key];
                    }
                }
                this.HtmlField = '';
                for(var k in fieldsArray){
                    if(fieldsArray[k]['inputtype']=='text'){
                       this.HtmlField += '<div class="mt-1"><label>'+fieldsArray[k]['uiname']+'</label><Input type="text" v-model="data.'+fieldsArray[k]['dbname']+'" placeholder=""/></div>';
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
            console.log(this.field.type['RAM']['subcode1']);

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
