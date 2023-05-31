<template>
    <PageComponent>
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ route.params.id ? model.title : "Criar Url" }}
                </h1>
                <div class="flex">
                    <a
                        :href="`http://localhost:8010/shortener/${model.identifier}`"
                        target="_blank"
                        v-if="model.identifier"
                        class="flex py-2 px-4 border border-transparent text-sm rounded-md text-indigo-500 hover:bg-indigo-700 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2"
                    >
                        Ver link Público
                    </a>
                    <button
                        v-if="route.params.id"
                        type="button"
                        @click="deleteShortener()"
                        class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red-600"
                    >
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 -mt-1 inline-block"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        >
                        <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        />
                        </svg>
                        Deletar Url
                    </button>
                </div>
            </div>
        </template>
        <div v-if="shortenerLoading" class="flex justify-center">Loading...</div>
        <form v-else @submit.prevent="saveShortener" class="animate-fade-in-down">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700"
                    >Title</label
                    >
                    <input
                    type="text"
                    name="title"
                    id="title"
                    v-model="model.title"
                    autocomplete="shortener_title"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    />
                </div>
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700"
                        >Identificador</label
                        >
                        <input
                        type="text"
                        name="identifier"
                        id="identifier"
                        :disabled="model.identifier.length >= 6 ? '' : disabled"
                        v-model="model.identifier"
                        autocomplete="shortener_title"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                </div>
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700"
                        >Url</label
                        >
                        <input
                        type="text"
                        name="url"
                        id="url"
                        v-model="model.url"
                        autocomplete="shortener_title"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button
                    type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Salvar
                </button>
        </div>
            </div>
        </form>

    </PageComponent>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store";
import PageComponent from '../components/PageComponent.vue';

const router = useRouter();

const route = useRoute();

// Get shortener loading state, which only changes when we fetch shortener from backend
const shortenerLoading = computed(() => store.state.currentShortener.loading);

// Create empty shortener
let model = ref({
    title: "",
    url: "",
    identifier: "",
    shortenedUrl: "",
});

// Watch to current shortener data change and when this happens we update local model
watch(
  () => store.state.currentShortener.data,
  (newVal, oldVal) => {
    model.value = {
      ...JSON.parse(JSON.stringify(newVal)),
      status: !!newVal.status,
    };
  }
  );

if (route.params.id) {
    // console.log(route.params.id)
  store.dispatch("getShortener", route.params.id);
}

/**
 * create or update
 */
function saveShortener() {
  let action = "created";
  if (model.value.identifier) {
    action = "updated";
  }
  store.dispatch("saveShortener", { ...model.value }).then(({ data }) => {
    store.commit("notify", {
      type: "success",
      message: "A url foi " + action + " com sucesso",
    });
    router.push({
      name: "ShortenerView",
      params: { id: data.data.identifier },
    });
  });
}

function deleteShortener() {
  if (
    confirm(
      `Tem certeza que deseja deletar a url? Esta operação não pode ser desfeita!!`
    )
  ) {
    store.dispatch("deleteShortener", model.value.identifier).then(() => {
      router.push({
        name: "Shorteners",
      });
    });
  }
}
</script>