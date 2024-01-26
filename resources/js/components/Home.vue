<template>
    <div>
        <main>
            <!-- Hero Area Start-->
            <div class="slider-area ">
                <div class="single-slider section-overly slider-height2 d-flex align-items-center"
                     data-background="/img/hero/about.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="hero-cap text-center">
                                    <h2>Get your job</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-listing-area pt-120 pb-120">
                <div class="container">
                    <div class="col-xl-10 col-lg-10 col-md-8 mx-auto">
                        <!-- Featured_job_start -->
                        <section class="featured-job-area">
                            <div class="container">
                                <div class="job-search col-md-8 mx-auto">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control input-search" placeholder="Search jobs here"
                                               aria-label="Recipient's username" aria-describedby="basic-addon2"
                                               v-model="search_text">
                                        <div class="input-group-append">
                                            <button class="head-btn2 btn-search"  type="button" @click="getJobList">
                                                Search
                                            </button>
                                            <button class="head-btn2 btn-reset" type="button" @click="getJobList(true)">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Count of Job list Start -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="count-job mb-35">
                                            <span>{{ allJobs.length + ' Jobs found' }}</span>
                                            <!-- Select job items start -->
                                            <div class="select-job-items">
                                            </div>
                                            <!--  Select job items End-->
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list-container" v-if="allJobs.length !== 0">
                                    <div v-for="job in allJobs">
                                        <router-link :to="'/job/'+job.id">
                                            <div class="single-job-items mb-30">
                                                <div class="job-items">
                                                    <div class="company-img">
                                                        <a href="#">
                                                            <img class="logo-image" :src="job.created_user && job.created_user.logo_path ? job.created_user.logo_path : 'company_logos/not-found.png'" alt="Company Logo">
                                                        </a>
                                                    </div>
                                                    <div class="job-tittle job-tittle2">
                                                        <a href="#">
                                                            <h4>{{ job.subject }}</h4>
                                                        </a>
                                                        <ul>
                                                            <li>{{  job.created_user.company_name }}</li>
                                                            <li><i
                                                                class="fas fa-map-marker-alt"></i>{{
                                                                    job.location
                                                                }}
                                                            </li>
                                                            <li>{{ job.salary_currency+ " " +job.salary }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="items-link items-link2 f-right">
                                                    <span>{{ job.job_type.job_type }}</span>
                                                    <span>{{ hoursFromNow(job.created_at)}} </span>
                                                </div>
                                            </div>
                                        </router-link>
                                    </div>
                                </div>
                                <div v-else>
                                    <span>No jobs found</span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
        <Footer/>
    </div>
</template>

<script>
import moment from 'moment';
import Footer from "./Footer";

export default {
    name: "Home"
    ,
    components: {Footer},
    data() {
        return {
            search_text: '',
            allJobs: [],
        }
    },
    mounted() {
        this.getJobList();
    },
    methods: {
        getJobList(reset = false) {
            this.search_text = reset == true ? '' : this.search_text;
            axios.get('/api/get-jobs', {
                    params: {
                        search_text: this.search_text
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    this.allJobs = response.data.data;
                }
            });
        },
        hoursFromNow(created_date_time) {
            const now = moment(); // Current date and time
            const createdDate = moment(created_date_time); // Created date
            const hoursDifference =  now.diff(createdDate, 'hours');
            return hoursDifference > 0 ? hoursDifference+ ' hour ago' : 'Just now';
        },
    }
}
</script>

<style scoped>
.job-list-container {
    max-height: 80vh;
    overflow-y: scroll;
}
.logo-image {
    max-width: 60px;
    max-height: 60px;
    width: auto;
    height: auto;
}
.btn-search, .btn-reset{
    margin-left: -1px;
    min-width: 4rem;
}
.btn-reset {
    border-radius: 0px 5px 5px 0px;
}
.input-search::placeholder {
    color: rgba(255, 38, 109, 0.99);
    opacity: 0.5; /* Firefox */
}

.input-search {
    border: 1px solid #fb246a;
}
</style>
