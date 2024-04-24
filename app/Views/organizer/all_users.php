<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
button:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
table {
	font-family: 'Montserrat', sans-serif;
	font-size: 14px;
}


</style>

<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll" id="vue-app">

  <!-- Content wrapper start -->
  <div class="content-wrapper">

    <!-- Row start -->
    <!-- <div class="row gutters">
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="stats-tile">
          <div class="sale-icon">
            <i class="icon-shopping-bag1"></i>
          </div>
          <div class="sale-details">
            <h2><?= '' ?></h2>
            <p>Events</p>
          </div>
          <div class="sale-graph">
            <div id="sparklineLine1"></div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- Row end -->

    <!-- Row start -->
    <!-- Row end -->

    <!-- Row start -->
    <!-- Row end -->

    <!-- USER EDIT FORM -->
    <div class="row gutters" v-if="edit_user_form == true">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Edit User</div>
            <div class="graph-day-selection" role="group">
              <a href="javascript:void(0)"><button type="button" class="btn active" v-on:click="edit_user_form = false">Close</button></a>
            </div>
          </div>

          <div class="card-body">
                    <div v-if="edit_user_form_error == true" class="alert alert-danger alert-dismissible fade show" role="alert">
											{{ edit_user_form_message }}
											<button v-on:click="edit_user_form_error = false" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
              <form action="" method="POST" name="edit_user_form" @submit.prevent="handleSubmitEditUser">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" v-model="user_to_update.name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Surname</label>
                    <input type="text" name="surname" class="form-control" v-model="user_to_update.surname">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" v-model="user_to_update.email">
                  </div>

                  <div class="form-group col-md-6">
                    <label for="">Mobile number</label>
                    <input type="text" name="mobile_number" class="form-control" v-model="user_to_update.mobile_number">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Confirm password</label>
                    <input type="password" name="confirm_password" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Account type</label>
                    <select name="account_type" id="account_type" class="form-control" v-model="user_to_update.account_type">
                      <option value="">SELECT</option>
                      <option value="admin">Admin</option>
                      <option value="participant">Participant</option>
                      <option value="organizer">Organizer</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="" class="p-4">Email verified:</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="email_verified" id="verified" value="1" v-model="user_to_update.email_verified">
                      <label class="form-check-label" for="verified">Verified</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="email_verified" id="not_verified" value="0" v-model="user_to_update.email_verified">
                      <label class="form-check-label" for="not_verified">Not Verified</label>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="form-group col-md-6">
                    <label for="">Machine</label>
                    <input type="text" name="machine" class="form-control" v-model="user_to_update.machine">
                  </div>

                  <div class="form-group col-md-6">
                    <label for="">Size of wheel</label>
                    <input type="text" name="size_of_wheel" class="form-control" v-model="user_to_update.size_of_wheel">
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="form-group col-md-6">
                    <label for="">Class</label>
                    <input type="text" name="class" class="form-control" v-model="user_to_update.class">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary btn-sm" name="save">Save</button>
                  </div>
                </div>
              </form>
          </div>
        </div>  
      </div>
    </div>
    <!-- EDIT USER FORM ^^^ -->

    <!-- ADD USER FORM -->
    <div class="row gutters" v-if="add_user_form == true">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Add New User</div>
            <div class="graph-day-selection" role="group">
              <a href="javascript:void(0)"><button type="button" class="btn active" v-on:click="hide_add_user_form">Close</button></a>
            </div>
          </div>

          <div class="card-body">
                    <div v-if="add_user_form_error == true" class="alert alert-danger alert-dismissible fade show" role="alert">
											{{ add_user_form_message }}
											<button v-on:click="add_user_form_error = false" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
              <form action="" method="POST" name="add_user_form" @submit.prevent="handleSubmitAddUser">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Surname</label>
                    <input type="text" name="surname" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label for="">Mobile number</label>
                    <input type="text" name="mobile_number" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Confirm password</label>
                    <input type="password" name="confirm_password" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">Account type</label>
                    <select name="account_type" id="account_type" class="form-control">
                      <option value="">SELECT</option>
                      <option value="participant">Participant</option>
                      <option value="organizer">Organizer</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="" class="p-4">Email verified:</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="email_verified" id="verified" value="1">
                      <label class="form-check-label" for="verified">Verified</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="email_verified" id="not_verified" value="0">
                      <label class="form-check-label" for="not_verified">Not Verified</label>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="form-group col-md-6">
                    <label for="">Machine</label>
                    <input type="text" name="machine" class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label for="">Size of wheel</label>
                    <input type="text" name="size_of_wheel" class="form-control">
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="form-group col-md-6">
                    <label for="">Class</label>
                    <input type="text" name="class" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary btn-sm" name="save">Save</button>
                  </div>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <!-- ADD USER FORM ^^^ -->


    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">All Users</div>
            <div class="graph-day-selection" role="group">
              <a href="javascript:void(0)"><button type="button" class="btn active" v-on:click="show_add_user_form">Add User</button></a>
            </div>
          </div>
          <div class="card-body all_users_container">
            <div class="row mb-4">
            <style>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
              
              <table class="table products-table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Class</th>
                    <th>Email</th>
                    <th>Mobile number</th>
                    <th>Account type</th>
                    <th>Email verified</th>
                    <th>Machine</th>
                    <th>Size of Wheel</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                      <tr v-for="(user, index) in users"  :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.surname }}</td>
                        <td>{{ user.class }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.mobile_number }}</td>
                        <td>{{ user.account_type }}</td>
                        <td>
                          <span class='text-success' v-if="user.email_verified == 1">Verified</span>
                          <span class='text-danger' v-if="user.email_verified == 0">Not verified</span>
                        </td>
                        <td>
                          {{ user.machine }}
                        </td>
                        <td>
                          {{ user.size_of_wheel }}
                        </td>
                        <td>
                          <a href="javascript:void(0);" v-on:click="show_edit_user_form(user.id);"><span class="text-success">Edit</span></a>&nbsp;&nbsp;
                          <a href="javascript:void(0);" v-on:click="delete_user(user.id);"><span class="text-danger">Delete</span></a>
                        </td>
                      </tr>
                    <tr v-if="users.length == 0">
                      <td colspan="4"><em>No record found!</em></td>
                    </tr>
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Row end -->

    <!-- Row start -->
    <!-- Row end -->

  </div>
  <!-- Content wrapper end -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const { createApp } = Vue;

        const app = createApp({
          methods: {
            show_add_user_form: function(){
              // hide edit user form if it is opened
              this.edit_user_form = false;

              this.add_user_form = true;
            },
            hide_add_user_form: function(){
              this.add_user_form = false;
            },
            handleSubmitAddUser: function(){
              $('.alert').remove();

              let form = $('form[name="add_user_form"]');
              let name = (form.find('input[name="name"]').val()).trim();
              let surname = (form.find('input[name="surname"]').val()).trim();
              let userClass = (form.find('input[name="class"]').val()).trim();
              let email = (form.find('input[name="email"]').val()).trim();
              let mobile_number = (form.find('input[name="mobile_number"]').val()).trim();
              let password = (form.find('input[name="password"]').val()).trim();
              let confirm_password = (form.find('input[name="confirm_password"]').val()).trim();
              let account_type = (form.find('select[name="account_type"]').val()).trim();
              let email_verified = form.find('input[name="email_verified"]:checked').val();
              let machine = form.find('input[name="machine"]').val().trim();
              let size_of_wheel = form.find('input[name="size_of_wheel"]').val().trim();

              if (name == '' || userClass == '' || surname == '' || email == '' || mobile_number == '' || password == '' || confirm_password == '' || account_type == '' || email_verified === undefined) {
                this.add_user_form_error = true;
                this.add_user_form_message = 'All fields are required';
              } else if (password != confirm_password) {
                this.add_user_form_error = true;
                this.add_user_form_message = 'Incorrect confirm password';
              } else {
                this.add_user_form_error = false;
                this.add_user_form_message = '';
                let outerThis = this;
                // save user to database
                $.ajax({
                  url: '<?= base_url('organizer/add_user') ?>',
                  method: 'POST',
                  data: {name,surname,userClass, email,mobile_number,password,account_type,email_verified,machine,size_of_wheel},
                  success: function(success) {
                    if (success.email_used !== undefined) {
                      $('form[name="add_user_form"]').before($(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Email in use!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>`));
                    } else if (success.user_created !== undefined) {
                      $('.all_users_container').prepend($(`<div class="alert alert-success alert-dismissible fade show" role="alert">
											User created successfully!
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`));
                      outerThis.add_user_form = false;
                      outerThis.users = success.users;
                    }
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
              }
            },
            delete_user: function(id) {
              $('.alert').remove();
              
              let confirm = window.confirm('Are you sure?');
              let outerThis = this;
              if (confirm) {
                $.ajax({
                  url: '<?= base_url('organizer/delete_user'); ?>',
                  method: 'POST',
                  data: {
                    user_id: id
                  },
                  success: function(success) {
                    if (success.user_deleted !== undefined) {
                      $('.all_users_container').prepend($(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                        User deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>`));
                      outerThis.users = outerThis.users.filter(user => user.id != id);
                    }
                  }
                });
              }
            },
            show_edit_user_form: function(id) {
              // hide add form if it is opened
              this.add_user_form = false;

              let user_to_update = {...this.users.find(user => user.id == id)};
              // user_to_update.email_verified = (user_to_update.email_verified == 1) ? true : false;
              this.user_to_update = user_to_update;
              this.edit_user_form = true;
            },
            handleSubmitEditUser: function() {
              $('.alert').remove();
              let form = $('form[name="edit_user_form"]');
              let name = (form.find('input[name="name"]').val()).trim();
              let surname = (form.find('input[name="surname"]').val()).trim();
              let userClass = (form.find('input[name="class"]').val()).trim();
              let email = (form.find('input[name="email"]').val()).trim();
              let mobile_number = (form.find('input[name="mobile_number"]').val()).trim();
              let password = (form.find('input[name="password"]').val()).trim();
              let confirm_password = (form.find('input[name="confirm_password"]').val()).trim();
              let account_type = (form.find('select[name="account_type"]').val());
              let email_verified = form.find('input[name="email_verified"]:checked').val();
              let machine = (form.find('input[name="machine"]').val()).trim();
              let size_of_wheel = (form.find('input[name="size_of_wheel"]').val()).trim();

              if (name == '' || surname == '' || email == '' || mobile_number == '' || account_type == '' || email_verified === undefined) {
                this.edit_user_form_error = true;
                this.edit_user_form_message = 'All fields are required';
              } else if (password != '' && password != confirm_password) {
                this.edit_user_form_error = true;
                this.edit_user_form_message = 'Incorrect confirm password';
              } else {
                this.edit_user_form_error = false;
                this.edit_user_form_message = '';
                let outerThis = this;
                // save user to database
                $.ajax({
                  url: '<?= base_url('organizer/update_user') ?>',
                  method: 'POST',
                  data: {user_id: this.user_to_update.id, name,surname,userClass,email,mobile_number,password,account_type,email_verified,machine,size_of_wheel},
                  success: function(success) {
                    if (success.email_used !== undefined) {
                      $('form[name="edit_user_form"]').before($(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Email in use!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>`));
                    } else if (success.user_updated !== undefined) {
                      $('.all_users_container').prepend($(`<div class="alert alert-success alert-dismissible fade show" role="alert">
											User updated successfully!
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`));
                      outerThis.edit_user_form_error = false;
                      outerThis.edit_user_form = false;
                      outerThis.users = success.users;
                    }
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
              }
            }
          },
          data() {
            return {
              users: [],
              user_to_update: null,
              add_user_form: false,
              add_user_form_error: false,
              add_user_form_message: '',
              edit_user_form: false,
              edit_user_form_error: false,
              edit_user_form_message: ''
            }
          },
          mounted() {
            let outerThis = this;
            $.ajax({
              url: '<?= base_url('organizer/all_users') ?>',
              method: 'GET',
              data: {
                jsonResponse: true
              },
              success: function(success) {
                window.qaisar = outerThis;
                if (success.users !== undefined) {
                  outerThis.users = success.users;
                }
              },
              error: function(error) {
                console.log(error);
              }
            });
          }
        }).mount('#vue-app');
});
</script>