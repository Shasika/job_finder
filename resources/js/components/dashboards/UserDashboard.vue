<template>
    <div class="container mx-auto">
        <center>
            <div class="title d-block mx-auto text-center mt-3 mb-5" style="background: linear-gradient(to right, #3498db, #6c5b7b); color: #ffffff; padding: 20px; border: 2px solid #34495e; border-radius: 10px;">
                <h1 style="font-size: 0.5em; color: #f7f7f7; text-shadow: 2px 2px 4px #fb246a;">DASHBOARD</h1>
            </div>
        </center>
            <div class="card-list d-flex flex-row justify-content-start flex-wrap">
                <div v-if="user && user[0].role_id !== 3">
                    <router-link to="/manage-jobs" class="nav-link">
                        <button type="button" class="btn btn-light">
                            <div class="tile wide job">
                                <div class="header">
                                    <div class="count"></div>
                                    <div class="title"></div>
                                </div>
                                <div class="body">
                                    <div class="title">Manage Jobs</div>
                                </div>
                            </div>
                        </button>
                    </router-link>
                </div>
                <div v-if="user && user[0].role_id === 1">
                    <router-link to="/manage-users" class="nav-link">
                        <button type="button" class="btn btn-light">
                            <div class="tile wide quote">
                                <div class="header">
                                    <div class="count"></div>
                                    <div class="title"></div>
                                </div>
                                <div class="body">
                                    <div class="title">Manage Users</div>
                                </div>
                            </div>
                        </button>
                    </router-link>
                </div>

            </div>
        </div>
</template>

<script>


export default {
    data() {
        return {
            user: '',
        }
    },
    created() {
        this.user = JSON.parse(localStorage.getItem("user"));
        console.log('this.user-->', this.user);
    },
    methods: {

    }
}
</script>

<style scoped>
* {
    font-family: 'Open Sans', sans-serif;
    /*font-size:12px;*/
}

body {
    background-color: #ececec;
}

.container {
    margin: 50px 0 0 100px;
}

.tile {
    width: 160px;
    height: 180px;
    border-radius: 4px;
    box-shadow: 2px 2px 4px 0 rgba(0, 0, 0, 0.15);
    margin-top: 20px;
    margin-left: 20px;
    float: left;
}

.tile.wide {
    width: 340px;
}

.tile .header {
    height: 120px;
    background-color: #f4f4f4;
    border-radius: 4px 4px 0 0;
    color: white;
    font-weight: 300;
}

.tile.wide .header .left, .tile.wide .header .right {
    width: 160px;
    float: left;
}

.tile .header .count {
    font-size: 48px;
    text-align: center;
    padding: 10px 0 0;
}

.tile .header .title {
    font-size: 20px;
    text-align: center;
}

.tile .body {
    height: 60px;
    border-radius: 0 0 4px 4px;
    color: #333333;
    background-color: white;
}

.tile .body .title {
    text-align: center;
    font-size: 20px;
    padding-top: 2%;
}

.tile.wide .body .title {
    padding: 4%;
}

.tile.job .header {
    background: linear-gradient(to bottom right, #609931, #87bc27);
}

.tile.job .body {
    color: #609931;
}

.tile.resource .header {
    background: linear-gradient(to bottom right, #ef7f00, #f7b200);
}

.tile.resource .body {
    color: #ef7f00;
}

.tile.quote .header {
    background: linear-gradient(to bottom right, #1f6abb, #4f9cf2);
}

.tile.quote .body {
    color: #1f6abb;
}

.tile.invoice .header {
    background: linear-gradient(to bottom right, #0aa361, #1adc88);
}

.tile.invoice .body {
    color: #0aa361;
}
</style>
