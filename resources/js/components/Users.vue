<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" data-toggle="modal" data-target="#addNewUserModal">
                      Add New <i class="fas fa-user-plus"></i>
                  </button>
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                      <tr>
                        <th>Name</th>
                        <th>E-mail address</th>
                        <th>Biography</th>
                        <th>Type</th>
                        <th>Registered at</th>
                        <th>Modify</th>
                      </tr>

                      <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.bio }}</td>
                        <td>{{ user.type }}</td>
                        <td>{{ user.created_at | myDate }}</td>
                        <td>
                            <a href="#" style="text-decoration: none;">
                                <i class="fas fa-user-edit blue"></i>
                            </a>

                            <a href="#" style="text-decoration: none;">
                                <i class="fas fa-trash-alt red"></i>
                            </a>
                        </td>
                      </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="createUser">

                  <div class="modal-body">

                    <div class="form-group">
                        <input type="text" 
                                name="name" 
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('name') }"
                                placeholder="Name"
                                v-model="form.name">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <input type="email" 
                                name="email" 
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('email') }"
                                placeholder="Email address"
                                v-model="form.email">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                        <textarea 
                                name="bio" 
                                id="bio" 
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('bio') }"
                                placeholder="Biography"
                                v-model="form.bio"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>

                    <div class="form-group">
                        <input type="password" 
                                name="password" 
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('password') }"
                                placeholder="Password"
                                v-model="form.password">
                        <has-error :form="form" field="password"></has-error>
                    </div>

                    <div class="form-group">
                        <select 
                                name="type" 
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('type') }"
                                placeholder="Type"
                                v-model="form.type">

                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

                  </div>

                  <div class="modal-footer">
                    <button id="closeModalBtn" type="button" class="btn btn-danger" data-dismiss="modal" @click="resetAndClear">Close</button>
                    <button :disabled="form.busy" type="submit" class="btn btn-success">Create</button>
                  </div>

              </form>

            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: {},
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: ''
                }),
                pageNumber: 0
            };
        },
        methods: {
            loadUsers() {
                axios.get('api/user')
                     .then((response) => {
                        console.log(response);
                        this.users = response.data.data
                    });
            },
            createUser() {
                this.form.post('api/user')
                    .then((response) => {
                        console.log(response);
                        this.closeModal();
                    })
                    .catch((error) => {
                        if(error.response){
                            console.log(error.response.data.errors);
                        }
                    });
                
            },
            resetAndClear() {
                this.form.reset();
                this.form.clear();
            },
            closeModal() {
                document.querySelector("#closeModalBtn").click()
            }
        },
        created() {
            this.loadUsers();
        }
    }
</script>
