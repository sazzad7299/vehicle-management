<!-- EnterUserData.vue -->
<template>
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="nextStep">
            <label for="name">Name:</label>
            <input v-model="user.name" type="text" required />
            <label for="email">Email:</label>
            <input v-model="user.email" type="email" required />
            <button type="submit">Next</button>
            <button type="button" @click="prevStep">Previous</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    dataUser: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      user: this.dataUser ? this.dataUser : {
        name: "",
        email: "",
      }
    };
  },
  methods: {
    nextStep() {
      this.$emit("nextStep", { user: this.user });
      console.log(this.user);
    },
    prevStep() {
      this.$emit("prevStep");
    },
  },
};
</script>
