<template>
    <div class="manage-users container">
        <div class="title d-block mx-auto text-center mt-3 mb-5" style="background: linear-gradient(to right, #3498db, #6c5b7b); color: #ffffff; padding: 20px; border: 2px solid #34495e; border-radius: 10px;">
            <h1 style="font-size: 0.5em; color: #f7f7f7; text-shadow: 2px 2px 4px #fb246a;">Manage Users</h1>
        </div>
        <div class="my-4">
            <div id="m_manage_register_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <table class="table table-bordered table-checkable border border-light" id="manage-user-table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">User Role</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Company Web</th>
                        <th scope="col">Company Email</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="usersList.length != 0" v-for="(user, index) in usersList">
                        <td scope="row">{{ index + 1 }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.user_role.role }}</td>
                        <td>{{ user.company_name ? user.company_name : '-' }}</td>
                        <td>{{ user.company_web ? user.company_web : '-' }}</td>
                        <td>{{ user.company_email ? user.company_email : '-' }}</td>
                        <td><div class="custom-control custom-switch d-flex justify-content-center">
                            <input type="checkbox" v-model="user.status" @change="setUserStatus(user.status, user.id)" class="custom-control-input" id="customSwitches">
                            <label class="custom-control-label" for="customSwitches"></label>
                        </div></td>
                    </tr>
                    <tr v-else>
                        <td>No records found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ManageUsers",
    data() {
        return{
            usersList: [],
        }
    },
    mounted() {
        this.getUsers();
    },
    methods : {
        getUsers() {
            axios.get('/api/get-all-users', {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    this.usersList = response.data.data;
                    this.usersList = this.usersList.map(user => ({
                        ...user,
                        status: user.status == '0' || user.status == 0 || user.status == 'false' || user.status == false ? false : true
                    }));
                }
            }).catch(error => {
                // Handle error response
                if (error.response && error.response.data && error.response.data.status) {
                    const errors = error.response.data;

                    this.$swal({
                        icon: 'error',
                        title: 'Login session is expired',
                        text: 'Please log in again.',
                        confirmButtonText: 'OK',
                        timer: 3000
                    }).then((result) => {
                        localStorage.removeItem("user");
                        localStorage.removeItem("token");
                        this.$router.push('/');
                        location.reload();
                    });
                }
            }).finally(res => {
                $(document).ready(function () {
                    $('#manage-user-table').DataTable();
                });
            });
        },
        setUserStatus(status, id) {
            let userStatus = status ? 'active.' : 'inactive.';
            let text = 'You want to change status to ' + userStatus;
            this.$swal({
                icon: "warning",
                showConfirmButton: true,
                title: 'Are you sure?',
                text: text,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'No, Keep it!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    if (status) {
                        status = true;
                    } else {
                        status = false;
                    }
                    this.changeUserStatus(status, id);
                } else {
                    this.getUsers();
                }
            });
        },
        changeUserStatus(status, id) {
            axios.get('/api/user-status-change', {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    },
                    params: {
                        user_id: id,
                        status: status,
                    }
                },
            ).then(response => {

            }).finally(res => {

            });
        }
    }

}
</script>

<style scoped>

</style>
