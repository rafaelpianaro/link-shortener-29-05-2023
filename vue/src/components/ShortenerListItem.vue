<template>
  <div class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[270px]">
    <h4 class="mt-4 text-lg font-bold">{{ shortener.title }}</h4>
    <a :href="`http://localhost:8010/shortener/${shortener.identifier}`" target="_blank">{{ shortener.shortenedUrl }}</a>
    <h4 class="mt-4 text-lg font-bold">{{ shortener.access }}</h4>
    <div v-html="shortener.url" class="overflow-hidden flex-1"></div>

    <div class="flex justify-between items-center mt-3">
      <router-link
        :to="{ name: 'ShortenerView', params: { id: shortener.identifier } }"
        class="flex py-2 px-4 border border-transparent text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 mr-2"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
          />
        </svg>
        Edit
      </router-link>
    </div>
  </div>
</template>

<script setup>

const { shortener } = defineProps({
  shortener: Object,
});
const emit = defineEmits(["delete", "edit"]);
</script>

<style></style>
