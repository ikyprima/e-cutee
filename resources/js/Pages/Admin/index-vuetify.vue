<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

</script>

<template>
    <AdminLayout>
    
    <v-container>
        
        <v-row>
            <v-card
            class="mx-auto my-8"
            elevation="16"
            min-width=100%
        >
    <v-card-item>
      <v-card-title>
        Dashboard
      </v-card-title>

      <v-card-subtitle>
      
      </v-card-subtitle>
    </v-card-item>

    <v-card-text>
      SELAMAT DATANG <b> {{ $page.props.auth.user.name }}.</b>
    </v-card-text>
  </v-card>
        </v-row>
    </v-container>
    </AdminLayout>
</template>