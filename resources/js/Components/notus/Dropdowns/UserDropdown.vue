<template>
  <div>
    <a
      class="text-blueGray-500 block"
      href="#pablo"
      ref="btnDropdownRef"
      v-on:click="toggleDropdown($event)"
    >
      <div class="items-center flex">
        <span
          class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"
        >
          <img
            alt="..."
            class="w-full rounded-full align-middle border-none shadow-lg"
            :src="image"
          />
        </span>
      </div>
    </a>
    <div
      ref="popoverDropdownRef"
      class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48"
      v-bind:class="{
        hidden: !dropdownPopoverShow,
        block: dropdownPopoverShow,
      }"
    >
      <a
        href="javascript:void(0);"
        @click="profile"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
      >
        Profile
    </a>
      
      <div class="h-0 my-2 border border-solid border-blueGray-100" />
    
      <Link :href="route('logout')" method="post" as="button"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">
        Logout
      </Link>
    
    </div>
  </div>
</template>

<script>
import { createPopper } from "@popperjs/core";
import { Link,router } from '@inertiajs/vue3';
import image from "@/img/user_blank.png";

export default {
  data() {
    return {
      dropdownPopoverShow: false,
      image: image,
    };
  },
  components: {Link,router},
  methods: {
    profile() {
          router.get(route('profile.edit'), {
          }, {
              replace: true,
              preserveScroll: true,
              preserveState: true  
          })
        },   
    toggleDropdown: function (event) {
      event.preventDefault();
      if (this.dropdownPopoverShow) {
        this.dropdownPopoverShow = false;
      } else {
        this.dropdownPopoverShow = true;
        createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
          placement: "bottom-start",
        });
      }
    },
  },
};
</script>
