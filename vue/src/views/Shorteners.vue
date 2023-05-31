<template>
  <!-- <PageComponent title="Urls"> -->
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Encurtar Url</h1>
        <router-link :to="{ name: 'ShortenerCreate' }"
          class="py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="w-4 h-4 inline-block">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Nova url
        </router-link>
      </div>
      <!-- <pre>{{shorteners.data[0].url}}</pre> -->
    </template>
    <div v-if="shorteners.loading" class="flex justify-center">Loading...</div>
    
    <div v-else-if="shorteners.data.length">
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
        <!-- <pre>{{ shorteners.data }}</pre> -->
        <ShortenerListItem v-for="shortener in shorteners.data" :key="shortener.identifier" :shortener="shortener"
          @delete="deleteShortener(shortener)">
        </ShortenerListItem>
      </div>
    </div>
    <div v-else class="text-gray-600 text-center py-16">
      Ainda sem urls
    </div>
  </PageComponent>
</template>

<script setup>
import store from "../store";
import { computed } from "vue";
import PageComponent from '../components/PageComponent.vue';
import ShortenerListItem from "../components/ShortenerListItem.vue";

const shorteners = computed(() => store.state.shorteners);
store.dispatch("getShorteners");

// store.dispatch("getShorteners", { url: link.url });

</script>

<style scoped></style>