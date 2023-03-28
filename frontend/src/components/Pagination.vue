<script setup>
  import { computed } from "vue";

  const props = defineProps(['current_page', 'pages', 'route']);

  const is_first_page = computed(() => {
    return props.current_page === 1;
  });

  const is_last_page = computed(() => {
    return props.current_page === props.pages;
  });

  const previous_page = computed(() => {
    return props.current_page - 1;
  });

  const next_page = computed(() => {
    return props.current_page + 1;
  });

  const display = computed(() => {
    let not_filled = true;
    let check_page = props.current_page - 2;
    let display_pages = [];
    while (not_filled) {
      if (check_page > 0 && check_page <= props.pages) {
        display_pages.push(check_page);
      }
      check_page++;
      if (display_pages.length >= 5 || check_page === props.pages) {
        not_filled = false;
      }
    }

    if (display_pages.includes(2) && !display_pages.includes(1)) {
      display_pages.unshift(1);
    }

    if (display_pages.includes(props.pages - 1) && !display_pages.includes(props.pages)) {
      display_pages.push(props.pages);
    }

    return {
      pages: display_pages,
      starting_ellipsis: !display_pages.includes(1) && display_pages.length > 0,
      ending_ellipsis: !display_pages.includes(props.pages) && display_pages.length > 0,
    }
  });
</script>

<template>
  <nav class="pagination" role="navigation" aria-label="pagination">
    <a
        v-if="!is_first_page"
        class="pagination-previous"
        aria-label="Goto page {{ previous_page }}"
        @click="$emit('paginationNavigate', previous_page)"
    >
      Previous Page
    </a>
    <a
        v-if="!is_last_page && pages > 0"
        class="pagination-previous"
        aria-label="Goto page {{ next_page }}"
        @click="$emit('paginationNavigate', next_page)"
    >
      Next Page
    </a>
    <ul class="pagination-list">
      <li v-if="display.starting_ellipsis">
        <a
            class="pagination-link"
            aria-label="Goto page 1"
            @click="$emit('paginationNavigate', 1)"
        >
          1
        </a>
      </li>
      <li v-if="display.starting_ellipsis">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>

      <li v-for="display_page in display.pages">
        <a
            class="pagination-link"
            :class="{ 'is-current': display_page === current_page }"
            aria-label="Goto page {{ display_page }}"
            @click="$emit('paginationNavigate', display_page)"
        >
          {{ display_page }}
        </a>
      </li>

      <li v-if="display.ending_ellipsis">
        <a
            class="pagination-link"
            aria-label="Goto page {{ props.pages }}"
            @click="$emit('paginationNavigate', props.pages)"
        >
          {{ props.pages }}
        </a>
      </li>
      <li v-if="display.ending_ellipsis">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
    </ul>
  </nav>
</template>