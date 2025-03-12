<template>
  <q-page class="q-ma-xl">
    <div class="row">
      <q-input label="Page ID" type="number" v-model="pageId"></q-input>
      <q-btn type="button" label="Go to page" @click="navigate" :to="url" />
    </div>

    <div class="row q-mt-xl">
      <p>
        Enter any valid number (eg, 24) and go click on the button to go to that page.
        <br />In the laravel app type the following artisan command:
        <br /><strong>php artisan pushy:push 24</strong>
        <br />Change the number to the same as the pageId
        <br /> This will send a notification to page 24 (in this example). If you opened two pages, eg, /page/24 and
        /page/53 then in this example only page 24 will receive the notification
      </p>
    </div>
  </q-page>
</template>

<script setup>

import { ref, computed } from "vue";
const pageId = ref(1);

const url = computed(() => {
  return "/page/" + pageId.value;
});
</script>
