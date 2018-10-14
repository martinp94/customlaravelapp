<template>
    <div class="container">
        <!-- set progressbar -->

        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="showUserModal('create')">
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

                      <tr v-for="user in users.data" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.bio }}</td>
                        <td>{{ user.type }}</td>
                        <td>{{ user.created_at | myDate }}</td>
                        <td>
                            <a href="#" style="text-decoration: none;" @click="showUserModal('edit', user)">
                                <i class="fas fa-user-edit blue"></i>
                            </a>

                            <a href="#" style="text-decoration: none;" @click="deleteUser(user.id)">
                                <i class="fas fa-trash-alt red"></i>
                            </a>
                        </td>
                      </tr>
                  </tbody>
                  
                </table>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-muted">
                <nav aria-label="...">
                  <ul class="pagination">
                    <li class="page-item" :class="{ disabled: users.current_page === 1 }">
                      <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>


                    <li class="page-item" v-for="page in users.last_page" :class="{ active: page === users.current_page}">

                        
                        <button class="page-link" @click.prevent="loadUsersFromPage(page)">
                            {{ page }}
                        </button>


                    </li>
                    <!-- <li class="page-item active">
                      <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li> -->


                    <li class="page-item" :class="{ disabled: users.current_page === users.last_page }">
                      <a class="page-link" href="#" >Next</a>
                    </li>
                  </ul>
                </nav>
              </div>

              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="userDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editmode">
                    Add
                </h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>
                    Edit
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="editmode ? updateUser() : createUser()">

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

                    <div class="form-group" v-if="!editmode">
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
                    <button :disabled="form.busy" type="submit" class="btn btn-success" v-if="!editmode">Create</button>
                    <button :disabled="form.busy" type="submit" class="btn btn-success" v-else>Update</button>
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
                editId: 0,
                editmode: false,
                users: {},
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: ''
                })
            };
        },
        methods: {
            showUserModal(type, userData = []) {
                this.form.reset();
                this.editmode = false;

                if(type === 'edit') {
                    this.editmode = true;
                    this.form.fill(userData);
                    this.editId = userData.id;
                }
                
                $("#userDataModal").modal('show');
            },
            loadUsers() {
                axios.get('api/user')
                     .then((response) => {
                        this.users = response.data;
                    });
            },
            loadUsersFromPage(page){

                axios.get(`http://aplikacija.test/api/user?page=${page}`)
                     .then((response) => {
                        console.log(response);
                        this.users = response.data;
                    });
            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                    .then((response) => {
                        this.userCreated(response);
                    })
                    .catch((error) => {
                        if(error.response){
                            console.log(error.response.data.errors);
                        }
                    });
                
            },
            updateUser() {
                this.$Progress.start();
                this.form.patch(`api/user/${this.editId}`)
                    .then((response) => {
                        this.userUpdated(response);
                    })
                    .catch((error) => {
                        if(error.response){
                            console.log(error.response.data.errors);
                        }
                    });

            },
            deleteUser(id) {
                swal({
                  title: 'Are you sure to delete?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Delete'
                }).then((result) => {

                  if (result.value) {
                    
                    this.form.delete(`api/user/${id}`)
                        .then((response) => {
                            this.loadUsers();
                            swal(
                              'Deleted!',
                              'Your file has been deleted.',
                              'success'
                            )
                        });
                  }

                })
            },
            resetAndClear() {
                this.form.reset();
                this.form.clear();
            },
            closeModal() {
                document.querySelector("#closeModalBtn").click()
            },
            userCreated(data) {
                console.log(data);
                this.closeModal();
                this.$Progress.finish();
                toastTopRight('User created successfuly');
                Fire.$emit('userCreated');
            },
            userUpdated(data) {
                console.log(data);
                this.closeModal();
                this.$Progress.finish();
                toastTopRight('User updated successfuly');
                Fire.$emit('userUpdated');
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('userCreated', () => {
                this.loadUsers();
            });

            Fire.$on('userUpdated', () => {
                this.loadUsers();
            });
        }
    }
</script>
