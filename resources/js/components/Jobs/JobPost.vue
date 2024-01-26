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
                                    <h2>{{ jobDetails.subject }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-post-company pt-120 pb-120">
                <div class="container">
                    <div class="row justify-content-between">
                        <!-- Left Content -->
                        <div class="col-xl-7 col-lg-8">
                            <!-- job single -->
                            <div class="single-job-items mb-50">
                                <div class="job-items">
                                    <div class="company-img company-img-details">
                                        <a href="#">
                                            <img class="logo-image" :src="jobDetails.created_user && jobDetails.created_user.logo_path ? jobDetails.created_user.logo_path : '../company_logos/not-found.png'" alt="Company Logo">
                                        </a>
                                    </div>
                                    <div class="job-tittle">
                                        <a href="#">
                                            <h4>{{ jobDetails.subject }}</h4>
                                        </a>
                                        <ul>
                                            <li>{{ jobDetails.created_user.company_name }}</li>
                                            <li><i class="fas fa-map-marker-alt"></i>{{ jobDetails.location }}</li>
                                            <li>{{ jobDetails.salary }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- job single End -->

                            <div class="job-post-details">
                                <div class="post-details1 mb-50">
                                    <!-- Small Section Tittle -->
                                    <div class="small-section-tittle">
                                        <h4>Job Description</h4>
                                    </div>
                                    <p v-html="jobDetails.description"></p>
                                </div>
                                <div class="post-details2  mb-50">
                                    <!-- Small Section Tittle -->
                                    <div class="small-section-tittle">
                                        <h4>Required Knowledge, Skills, and Abilities</h4>
                                    </div>
                                    <span v-html="jobDetails.requirements"></span>
                                </div>
                                <div class="post-details2  mb-50">
                                    <!-- Small Section Tittle -->
                                    <div class="small-section-tittle">
                                        <h4>Education + Experience</h4>
                                    </div>
                                    <span v-html="jobDetails.education_and_experience"></span>
                                </div>
                            </div>

                        </div>
                        <!-- Right Content -->
                        <div class="col-xl-4 col-lg-4">
                            <div class="post-details3  mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Job Overview</h4>
                                </div>
                                <ul>
                                    <li>Posted date : <span>{{ formatDate(jobDetails.created_at) }}</span></li>
                                    <li>Location : <span>{{ jobDetails.location }}</span></li>
                                    <li>Vacancy : <span>{{ jobDetails.vacancy_count }}</span></li>
                                    <li>Job nature : <span>{{ jobDetails.job_type.job_type }}</span></li>
                                    <li>Salary : <span>{{ jobDetails.salary }}</span></li>
                                    <li>Application date : <span>{{ formatDate(jobDetails.vacancy_end_date) }}</span>
                                    </li>
                                </ul>
                                <div class="apply-btn2">
                                    <div class="alert alert-success" role="alert" v-if="alreadyApplied">
                                        You have already applied for this job.
                                    </div>
                                    <button class="btn btn-primary" @click="showModal" v-else-if="isLogin">Apply Now</button>
                                    <div class="alert alert-danger" role="alert" v-else>
                                        To apply for this job, you need to login to the system first.
                                    </div>
                                </div>
                            </div>
                            <div class="post-details4  mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Company Information</h4>
                                </div>
                                <span>{{ jobDetails.created_user.company_name }}</span>
                                <p>{{ jobDetails.created_user.company_description }}</p>
                                <ul>
                                    <li>Name: <span> {{ jobDetails.created_user.name }} </span></li>
                                    <li>Web : <span> {{ jobDetails.created_user.company_web }} </span></li>
                                    <li>Email: <span> {{ jobDetails.created_user.company_email }} </span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <JobApplyModal @getJobApplyStatusData="checkJobApplyStatus" v-if="isLogin" @close="hideModal"></JobApplyModal>
        </main>
        <Footer/>
    </div>
</template>

<script>
import JobApplyModal from "./JobApplyModal";
import moment from 'moment';
import Footer from "../Footer";

export default {
    name: "JobPost",
    components: {Footer, JobApplyModal},
    data() {
        return {
            search_text: '',
            jobId: null,
            jobDetails: [],
            user: null,
            isLogin: false,
            alreadyApplied: false,
        }
    },
    created() {
        this.jobId = this.$route.params.id;
        let user = localStorage.getItem('user');
        if(user){
            this.isLogin =  true;
            this.user = JSON.parse(user);
            this.checkJobApplyStatus()
        }
    },
    mounted() {
        this.getJobByID();
    },
    methods: {
        checkJobApplyStatus() {
            axios.get('/api/job-apply-status/'+ this.jobId, {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    this.alreadyApplied = response.data.data;
                }
            }).finally(res => {

            });
        },
        getJobByID() {
            axios.get('/api/get-job-details/' + this.jobId
            ).then(response => {
                if (response.data && response.data.data) {
                    this.jobDetails = response.data.data;
                }
            });
        },
        hideModal() {
            $("#job-apply-modal").modal('hide');
        },
        showModal() {
            $("#job-apply-modal").modal('show');
        },
        formatDate(date) {
            return moment(date).format("DD MMM YYYY");
            ;
        }
    }
}
</script>

<style scoped>
.logo-image {
    max-width: 100px;
    max-height: 100px;
    width: auto;
    height: auto;
}
</style>
