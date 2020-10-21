<template>
    <div style="height: 80%;display: flex;">
        <div id="loginForm1" class="col-md-3">
            <div class="form-group"><h1 class="topText">Login Dashboard</h1></div>
            <div class="form-group">
                <input type="email" class="form-control" v-model="data.email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" v-model="data.password" placeholder="Password">
            </div>
            <div class="form-group">
                <Button type="info" long @click="login">Log In</Button>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                data:{
                    'email':'',
                    'password':''
                },
                isLogging : false
            }
        },
        methods:{
            async login(){
                if(this.data.email.trim() == "") return this.e('Email is required');
                if(this.data.password.trim() == "") return this.e('Password is required');
                if(this.data.password.length < 6) return this.e('Incorrect Login details.');
                const res = await this.callApi('post','app/admin_login',this.data);
                if(res.status === 200){
                    window.location = "/";
                    this.i(res.data.msg);
                }else if(res.status === 422){
                    for(let err in res.data.errors){
                        this.e(res.data.errors[err][0])
                    }
                }else{
                    if(res.status===401){
                        this.e(res.data.msg);
                    }else{
                        this.swr();
                    }
                }
            }
        }
    }
</script>
<style scoped>
    #loginForm1 {
        margin: auto auto;
        background-color: white;
        border-radius: 10px;
        padding: 15px;
    }
    .topText{
        padding: 5px;
    }
</style>
