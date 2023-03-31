<script setup>
  import {useUserStore} from "../../stores/user";
  import {useAlertStore} from "../../stores/alert";
  import { ref, computed } from 'vue';
  import AuthProvider from "../../providers/AuthProvider";
  import validationProvider from "../../providers/ValidationProvider";
  import router from "../../router";

  const userStore = useUserStore();
  const password = ref('');
  const email = ref('');
  const errors = ref({
    email: [],
    password: [],
  })

  const has_errors = computed(() => {
    let return_value = false;
    for (const field in errors.value) {
      if (errors.value[field].length > 0) {
        return_value = true;
        break;
      }
    }

    return return_value;
  })

  const hide_login = ref(userStore.is_logged_in);
  const is_loading = ref(false);

  async function login() {
    is_loading.value = true;
    hide_login.value = false;

    validateForm();

    if (has_errors.value) {
      is_loading.value = false;
      return
    }

    const response = await AuthProvider.login({
      email: email.value,
      password: password.value,
    });

    if (response) {
      userStore.setToken(response.access_token, response.expires_in);

      let user = response?.user;

      if (!user) {
        user = await AuthProvider.getUser();
      }

      if (user) {
        userStore.$patch({
          user: user,
          is_logged_in: true,
        });

        useAlertStore().addAlert('Successfully Logged In');

        router.push({ name: 'home' });
      }
    }

    is_loading.value = false;
  }

  function validateForm() {
    errors.value = {
      email: [],
      password: [],
    }

    if (!email.value) {
      errors.value.email.push('Email is required.');
    }

    if (!validationProvider.validateEmail(email.value)) {
      errors.value.email.push('Must be a valid email.');
    }

    if (!password.value) {
      errors.value.password.push('Password is required.');
    }

    if (!validationProvider.validateLength(password.value, 8)) {
      errors.value.password.push('Password must be at least 8 characters.');
    }
  }
</script>

<template>
  <div v-if="hide_login">
    You are already logged in
  </div>
  <div v-else class="columns is-centered">
    <div class="column is-half">
      <div class="card">
        <div class="card-content">
          <p class="title is-4">Login</p>
          <div class="columns is-multiline">
            <div class="column is-full">
              <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control">
                  <input
                      id="email"
                      class="input"
                      type="text"
                      placeholder="Email Address"
                      v-model="email"
                      @keyup.enter="login"
                  >
                </div>
                <div>
                  <p class="help is-danger" v-for="(error, index) in errors.email ">
                    {{ error }}
                  </p>
                </div>
              </div>
            </div>

            <div class="column is-full">
              <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control">
                  <input
                      id="password"
                      class="input"
                      type="password"
                      placeholder="Password"
                      v-model="password"
                      @keyup.enter="login"
                  >
                </div>
                <p class="help is-danger" v-for="(error, index) in errors.password ">
                  {{ error }}
                </p>
              </div>
            </div>
          </div>

          <div class="columns">
            <div class="column is-full">
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-info" :class="{ 'is-loading': is_loading }" @click="login" data-test="login-button">Login</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>