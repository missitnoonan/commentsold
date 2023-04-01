<script setup>
  import { onMounted, ref } from "vue";
  import productsProvider from "../../../providers/ProductsProvider";
  import ProductListTable from "../../../components/Products/ProductListTable.vue";
  import Pagination from "../../../components/Pagination.vue";
  import ListOptions from "../../../components/ListOptions.vue";

  const products = ref([]);

  const sort = ref('id');
  const sort_direction = ref('desc');
  const limit = ref(20);
  const page = ref(1);
  const pages = ref(0);

  const is_loading = ref(true);
  const show_pagination = ref(false);

  const sortable_fields = {
    id: 'Id',
    product_name: 'Name',
    style: 'Style',
    brand: 'Brand'
  }

  onMounted(() => {
    getList().then(() => show_pagination.value = true);
  });

  async function getList() {
    is_loading.value = true;
    await productsProvider.getList({
      sort: sort.value,
      sort_direction: sort_direction.value,
      page: page.value,
      limit: limit.value,
    })
        .then((results) => {
          products.value = results.product_repositories;
          page.value = results.page;
          pages.value = results.pages;
          limit.value = results.limit;

          is_loading.value = false;
        });

    return true;
  }

  function handlePaginationNavigate(navigate_to) {
    page.value = navigate_to;
    getList();
  }

  function handleSort(new_sort) {
    page.value = 1;
    sort.value = new_sort;
    getList();
  }

  function handleSortDirection(new_sort_direction) {
    page.value = 1;
    sort_direction.value = new_sort_direction;
    getList();
  }

  function handleLimit(new_limit) {
    page.value = 1;
    limit.value = new_limit;
    getList();
  }
</script>

<template>
  <div class="columns">
    <div class="column is-12">
      <div class="card">
        <div class="card-content">
          <p class="title">Products</p>
            <div v-if="show_pagination" class="columns is-multiline is-mobile">
              <div class="column is-12">
                <ListOptions
                    :sort="sort"
                    :sort_direction="sort_direction"
                    :limit="limit"
                    :sortable_fields="sortable_fields"
                    model="Products"
                    @sortNavigate="handleSort"
                    @sortDirectionNavigate="handleSortDirection"
                    @limitNavigate="handleLimit"
                />
              </div>
              <div v-if="!is_loading" class="column is-12">
                <ProductListTable :products="products" />
              </div>
              <progress v-else class="progress is-large is-info" max="100">60</progress>
              <div class="column is-12">
                <Pagination :current_page="page" :pages="pages" route="products_list"  @paginationNavigate="handlePaginationNavigate"/>
              </div>
            </div>
            <progress v-else class="progress is-large is-info" max="100">60</progress>
        </div>
      </div>
    </div>
  </div>
</template>