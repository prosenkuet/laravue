<template>
    <div>
            <div class="wrapper" >
                <!-- Sidebar -->

                <nav id="sidebar" v-if="$store.state.user">
                    <div class="sidebar-header">
                        <h3>Bootstrap Sidebar</h3>
                        <strong>BS</strong>
                    </div>

                    <ul class="list-unstyled components">
                        <li class="active">
                            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="fa fa-home"></i>
                                Home
                            </a>
                            <ul class="collapse list-unstyled" id="homeSubmenu">
                                <li>
                                    <a href="#">Home 1</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 3</a>
                                </li>
                                <li>
                                    <a href="#">Home 3</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a v-for="(per,i) in permission" :key="i" v-if="permission.length && per.read" :href="per.name">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                {{per.resourceName}}
                            </a>
                            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="fa fa-copy"></i>
                                Pages
                            </a>
                            <ul class="collapse list-unstyled" id="pageSubmenu">
                                <li>
                                    <a href="#">Page 1</a>
                                </li>
                                <li>
                                    <a href="#">Page 2</a>
                                </li>
                                <li>
                                    <a href="#">Page 3</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </nav>


                <!-- Page Content -->
                <div id="content" class="">

                    <div id="main-header" class="shadow bg-white" v-if="$store.state.user">

                        <nav class="navbar navbar-expand-md navbar-dark">
                            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active">
                                        <button type="button" id="sidebarCollapse" class="btn btn-light">
                                            <i class="fa fa-align-left"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="">Codeply</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Link</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Link</a>
                                    </li>
                                    <li class="nav-item">
                                        <div class="input-group">
                                            <input type="text" class="form-control" style="max-width: 130px" placeholder="Search this blog">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mx-auto order-0">
                                <a class="navbar-brand mx-auto" href="#">IT Managment</a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>
                            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">{{$store.state.user.fullName}}</a>
                                    </li>
                                    <li class="nav-item" v-if="$store.state.user">
                                        <div class="dropdown open dropdown-menu-right" id="userprofile">
                                            <img class="rounded-circle" alt="5x5" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg"
                                                 data-holder-rendered="true" style="max-width: 40px;max-height: 40px" id="dropdownMenu1" data-toggle="dropdown">
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                                <a class="dropdown-item" href="/logout"><i class="fa fa-lg fa-sign-out" aria-hidden="true"></i> Logout</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                            </div>
                                        </div>
                                    </li>

                                </ul>

                            </div>
                        </nav>

                    </div >
                    <div id="page-container" class="container-fluid" style="position: relative">

                        <router-view></router-view>
                    </div>


                </div>

            </div>
            <!--            <router-view></router-view>-->
        </div>

</template>
<script>
    export default {
        props:['user','permission'],
        data(){
            return {
                'isLoggedIn':false
            }
        },
        created() {
            this.$store.commit('setUpdateUser',this.user);
            this.$store.commit('setUserPermission',this.permission);
        }

    }
</script>
