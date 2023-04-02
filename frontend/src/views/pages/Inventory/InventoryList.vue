<script setup>
  import { onMounted, ref } from "vue";
  import inventoryProvider from "../../../providers/InventoryProvider";
  import InventoryListTable from "../../../components/Inventory/InventoryListTable.vue";
  import Pagination from "../../../components/Pagination.vue";
  import ListOptions from "../../../components/ListOptions.vue";
  import SearchBar from "../../../components/SearchBar.vue";

  const inventory = ref([]);

  const sort = ref('id');
  const sort_direction = ref('desc');
  const limit = ref(20);
  const page = ref(1);
  const pages = ref(0);

  const search = ref('');

  const is_loading = ref(true);
  const show_pagination = ref(false);

  // Display the Product Name, sku, quantity, color, size, price and cost
  const sortable_fields = {
    id: 'ID',
    product_name: 'Product Name',
    sku: 'SKU',
    quantity: 'Quantity',
    color: 'Color',
    size: 'Size',
    price_cents: 'Price',
    cost_cents: 'Cost',
  }

  async function getList() {
    is_loading.value = true;
    await inventoryProvider.getList({
      sort: sort.value,
      sort_direction: sort_direction.value,
      page: page.value,
      limit: limit.value,
      search: search.value,
    })
        .then((results) => {
          inventory.value = results.inventory_repositories;
          page.value = results.page;
          pages.value = results.pages;
          limit.value = results.limit;

          is_loading.value = false;
        });

    return true;
  }

  onMounted(() => {
    getList().then(() => show_pagination.value = true);
  });

  // Not DRY, but simple
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

  function handleSearch(new_search) {
    page.value = 1;
    search.value = new_search;
    getList();
  }
</script>

<template>
  <div class="columns">
    <div class="column is-12">
      <div class="card">
        <div class="card-content">
          <p class="title">Inventory</p>
          <div v-if="show_pagination" class="columns is-multiline is-mobile">
            <div class="column is-12">
              <ListOptions
                  :sort="sort"
                  :sort_direction="sort_direction"
                  :limit="limit"
                  :sortable_fields="sortable_fields"
                  model="Items"
                  @sortNavigate="handleSort"
                  @sortDirectionNavigate="handleSortDirection"
                  @limitNavigate="handleLimit"
              />
            </div>
            <div class="column is-12">
              <SearchBar :search="search" @searchNavigate="handleSearch"/>
            </div>
            <div v-if="!is_loading" class="column is-12">
              <InventoryListTable :inventory_items="inventory" :display_product_name="true" />
            </div>
            <progress v-else class="progress is-large is-info" max="100">60</progress>
            <div class="column is-12">
              <Pagination :current_page="page" :pages="pages" route="inventory_list"  @paginationNavigate="handlePaginationNavigate"/>
            </div>
          </div>
          <progress v-else class="progress is-large is-info" max="100">60</progress>
        </div>
      </div>
    </div>
  </div>
</template>