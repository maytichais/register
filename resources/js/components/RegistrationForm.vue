<template>
  <div>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="Username">Username:</label>
        <input type="text" name="Username" v-model="form.username" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" v-model="form.password" class="form-control">
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" v-model="form.password_confirmation" class="form-control">
      </div>
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" v-model="form.name" class="form-control">
      </div>
      <div class="form-group">
        <label for="surname">Surame:</label>
        <input type="text" name="surname" v-model="form.surname" class="form-control">
      </div>
      <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" name="address" v-model="form.address" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        surname: '',
        address: '',
        username: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    register() {
      axios.post('/api/register', this.form)
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
