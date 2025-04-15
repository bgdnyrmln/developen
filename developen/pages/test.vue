<script setup lang="ts">
  import { ref } from "vue";

  const onClickHandler = (page: number) => {
    console.log(page);
  };

  const currentPage = ref(1);
</script>

<template>
  <vue-awesome-paginate
    :total-items="50"
    :items-per-page="5"
    :max-pages-shown="3"
    v-model="currentPage"
    @click="onClickHandler"
  />
</template>

<style>
  .pagination-container {
    display: flex;
  }

  .paginate-buttons {
    height: 40px;
    width: 40px;
    cursor: pointer;
    background-color: whitesmoke;
    border: 1px solid #404447;
    color: black;
    transition: all 0.3s ease;
    border-radius: 5px;
  }

  .paginate-buttons:hover {
    background-color: #d8d8d8;
  }

  .active-page {
    background-color: #a6adb1;

    border: 1px solid #404447;

    color: white;
  }

  .active-page:hover {
    background-color: #406f8e;
  }
</style>