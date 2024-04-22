<template>
    <v-app id="inspire">

  
      <v-app-bar>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-app-bar-title>Application</v-app-bar-title>
      </v-app-bar>
  
      <v-navigation-drawer
      class="bg-deep-purple"
      rail
        v-model="drawer"
        expand-on-hover
        permanent
        @update:rail="updateRail"
      >
      <v-list>
          <v-list-item
            prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
            subtitle="sandra_a88@gmailcom"
            title="Sandra Adams"
          ></v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-folder" title="My Files" value="myfiles"  :href="'https://randomuser.me/'"></v-list-item>
          <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
          <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
        </v-list>
        <template v-slot:append >
          <div class="pa-2">
            <v-slide-x-reverse-transition leave-absolute>
                <v-btn block prepend-icon="mdi-logout" variant="outlined"  v-if="!statRail">
                Logout
            </v-btn>
            <v-btn icon="mdi-account-lock" size="small" variant="outlined" v-else>
            </v-btn>
      </v-slide-x-reverse-transition>
           
          </div>
        </template>
      </v-navigation-drawer>
  
      <v-main class="bg-grey-lighten-4">
        <slot />
       
      </v-main>
    </v-app>
  </template>
  
  <script setup>
    import { ref } from 'vue'
  
    const drawer = ref(null)
  </script>
  
  <script>
    export default {
      data: () => ({ drawer: null,
        statRail:true
        }),
      methods: {
        updateRail(v) {
            this.statRail = v;
        }   
      },
    }
  </script>