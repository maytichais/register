<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">{{ formTitle }}</div>

          <div class="card-body">
            <form @submit.prevent="login">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="username" class="form-control" id="username" v-model="username">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" v-model="password">
              </div>

              <button type="submit" class="btn btn-primary">{{ submitButton }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        formTitle: 'Login',
        submitButton: 'Login',
        username: '',
        password: '',
        errors: []
      }
    },
    methods: {
      login() {
        axios.post('/login', {
          username: this.username,
          password: this.password
        })
        .then(response => {
          window.location.href = response.data.redirect;
        })
        .catch(error => {
          console.log(error);
        });
      }
    }
  };
</script>