<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
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
        Ajukan Cuti
      </v-card-title>
      <v-divider class="pb-4"></v-divider>
    
    </v-card-item>

    <v-card-text>
       
        <v-combobox
        
            clearable
            label="Jenis Cuti Yang Diambil"
            :items="['Cuti Tahunan', 'Cuti Sakit', 'Cuti Karena Alasan Penting', 'Cuti Besar', 'Cuti Melahirkan', 'Cuti di Luar Tanggungan Negara']"
            variant="outlined"
        ></v-combobox>
        <v-text-field clearable label="Alasan Cuti" variant="outlined"></v-text-field>
        <div class="text-subtitle-2 mb-2">Tanggal </div>
        <v-divider class="border-opacity-25 pb-4" ></v-divider>
        <VueDatePicker v-model="selectedDate"/>
    </v-card-text>
  </v-card>
        </v-row>
    </v-container>
    
    </AdminLayout>
</template>
<script>
  export default {
    components: { VueDatePicker },
    
    data: () => ({
        fromDateMenu: false,
        selectedDate: null,
        minDate: new Date().toISOString().substr(0, 10), // Mengatur tanggal minimum ke hari ini
    }),
    computed: {
        selectedDateFormatted() {
      return this.selectedDate ? new Date(this.selectedDate).toLocaleDateString() : '';
    }
 
  }
  }
</script>