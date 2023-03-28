<script setup>
  import { onMounted } from "vue";

  onMounted(() => {
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  });
</script>

<template>
  <nav class="navbar is-info is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <router-link :to="{ name: 'home' }" class="navbar-item">Frontend</router-link>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="divelog_navbar">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="divelog_navbar" class="navbar-menu">
      <div class="navbar-start">
        <router-link :to="{ name: 'test_page' }" class="navbar-item">Test Page</router-link>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">

        </div>
      </div>
    </div>
  </nav>
</template>