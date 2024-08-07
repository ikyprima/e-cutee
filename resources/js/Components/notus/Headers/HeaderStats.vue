<template>
  <!-- Header -->
  <div class="relative bg-emerald-600 md:pt-28 pb-28 pt-8">
    <div class="px-4 md:px-10 mx-auto w-full">
      <div>
        <!-- Card stats -->
        <div class="flex flex-wrap">
        
          <slot name="kontenheader"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CardStats from "@/Components/notus/Cards/CardStats.vue";

export default {
  components: {
    CardStats,
  },
};
</script>
