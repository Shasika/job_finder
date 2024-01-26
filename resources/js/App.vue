<template>
    <div class="app">
<!--        <Nav/>-->
        <Header/>
        <PreLoader/>
        <router-view></router-view>
<!--        <div class="container-xl mh-100 p-3 my-3 bg-dark text-white -xl">-->
<!--            <h1>HOME</h1>-->
<!--        </div>-->
    </div>
</template>

<script>

// import Nav from './Nav'
import Header from "./Header";
import PreLoader from "./components/PreLoader";


export default {
    name: "App",

    components: {
        PreLoader,
        Header,
        // Nav
    },
}
</script>

<style  scoped>

</style>
