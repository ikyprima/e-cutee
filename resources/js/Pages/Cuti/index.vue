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
    <v-card-item >
    
    
      <v-card-title class="pb-4">
        List Pengajuan Cuti
      </v-card-title>
      <v-divider class="pb-4"></v-divider>
    
    </v-card-item>

    <v-card-text>
     

       <v-data-table
      :page="page"
      :pageCount="numberOfPages"
      :headers="headers"
      :items="passengers"
      :options.sync="options"
      :server-items-length="totalPassengers"
      :loading="loading"
      class="elevation-1"
    >
      <template v-slot:item.logo="{ item }">
        <img :src="item.airline.logo" style="width: 10%;" />
      </template>
      <template v-slot:item.website="{ item }">
        <a :href="item.airline.website">{{ item.airline.website }}</a>
      </template>
    </v-data-table>
        
    </v-card-text>
    <v-card-actions>
    </v-card-actions>
  </v-card>
        </v-row>
    </v-container>
    
    </AdminLayout>
</template>
<script>
import moment from 'moment';

  export default {
    props:{
        dataCuti : Object,
      
    },
    components: {   },
    
    // data: () => ({
        
    // }),
    data() {
        return {
          page: 0,
          totalPassengers: 0,
          numberOfPages: 0,
          passengers: [],
          loading: true,
          options: {},
          headers: [
            { text: "Passenger Name", value: "name" },
            { text: "Number Of Trips", value: "trips" },
            { text: "Airline", value: "airline[0].name" },
            { text: "Logo", value: "logo" },
            { text: "Website", value: "website" },
          ],
        
        };
    },
    watch: {
     
      
    },
    computed: {
       
    },
    mounted() {
    //  this.readDataFromAPI();
    },
    methods: {
    

    }
    }
</script>