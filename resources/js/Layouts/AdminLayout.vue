<template>
    <v-app id="inspire">

  
      <v-app-bar>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-app-bar-title>E-Cuti</v-app-bar-title>
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
            :prepend-avatar="image"
            :subtitle="$page.props.auth.user.username"
            :title="$page.props.auth.user.name"
          >
        </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-folder" title="CUTI" @click="handleClick('admin-index-cuti')"></v-list-item>
          <v-list-item prepend-icon="mdi-account-multiple" title="PERSETUJUAN" @click="handleClick('admin-persetujuan-cuti')" ></v-list-item>
        
        </v-list>
        <template v-slot:append >
          <div class="pa-2">
            <v-slide-x-reverse-transition leave-absolute>
                <v-btn  @click="logout()" block prepend-icon="mdi-logout" variant="outlined"  v-if="!statRail">
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
    import 'vuetify/styles'
    import { router } from '@inertiajs/vue3';
    import image from "@/img/bootstrap.jpg";
    
    const drawer = ref(null)
  </script>
  
  <script>
    export default {
      data: () => ({ drawer: null,
        statRail:true,
        image : image
        }),
      methods: {
        updateRail(v) {
            this.statRail = v;
        },
        handleClick(value) {
          router.get(route(value), {
          }, {
              replace: true,
              preserveScroll: true,
              preserveState: true  
          })
        },   
        logout() {

        router.post(route('logout'), {},
          {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
            },
          }
        )
},

      },
    }
  </script>