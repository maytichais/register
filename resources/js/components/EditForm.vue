<template>
  <div>
    <form @submit.prevent="edit">
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
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <div>
      <div v-if="imageSrc">
        {{ message }}
        <img :src="imageSrc" alt="Uploaded Image">
      </div>
      <input type="file" @change="onFileChange">
    </div>

    <div class="form-group">
      <button type="submit" @click="cancel" class="btn btn-primary">Cancel</button>
    </div>
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
      },
      imageSrc: null,
      message: null,
    };
  },
  created() {
    this.fetchProfile();
  },
  methods: {
    fetchProfile() {
      axios.get('/api/get_profile')
      .then(response => {
        this.form.name = response.data.user.name;
        this.form.surname = response.data.user.surname;
        this.form.address = response.data.user.address;
        this.imageSrc = response.data.imageSrc;
      });
    },
    edit() {
      axios.post('/api/update_profile', this.form)
        .then(response => {
          window.location.href = response.data.redirect;
        })
        .catch(error => {
          console.log(error);
        });
    },
    onFileChange(event) {
      const file = event.target.files[0];
      this.uploadImage(file);
    },
    async uploadImage(file) {
      const formData = new FormData();
      formData.append('image', file);
      try {
        const response = await axios.post('/api/upload_image', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        this.message = response.data.message;
        this.imageSrc = response.data.imageSrc;
      } catch (error) {
        console.log(error.response.data.message);
      }
    },
    cancel(){
      window.location.href = '/dashboard';
    }
  }
};
</script>
