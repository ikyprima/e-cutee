<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
</script>

<template>
    <AdminLayout>
    
    <v-container>
      <v-dialog v-model="dialog" max-width="500">
      <template v-slot:default="{ isActive }">
        <v-card title="TIMELINE PERSETUJUAN">
        
          <template v-slot:text>
            <v-divider class="pb-4"></v-divider>
            <v-timeline side="end">
              <v-timeline-item
              v-for="item in objRow"
                :key="item.id"
                dot-color="pink"
                size="small"
              >
                <div class="d-flex">
                  <div>
                    <strong class="me-4">{{item.pegawai?item.pegawai.nama:"Nama Pegawai"}}</strong>
                    <div class="text-caption">
                      {{ moment(item.created_at).format('YYYY-MM-DD HH:mm:ss') }}
                    </div>
                  </div>
                  
                  <strong>   
                    <v-badge v-if="item.status == 0"
                      color="info"
                      content="Menunggu Persetujuan"
                      inline
                    ></v-badge>
                    <v-badge v-else-if="item.status == 1"
                      color="green"
                      content="Disetujui"
                      inline
                    ></v-badge>
                    <v-badge v-else
                      color="error"
                      content="Ditolak"
                      inline
                    ></v-badge>
                  </strong>
                  
                </div>
              </v-timeline-item>
            </v-timeline>
          </template>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
              color="surface-variant"
              text="TUTUP"
              variant="flat"
              @click="isActive.value = false"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
        <v-row>
            <v-card
            class="mx-auto my-8"
            elevation="16"
            min-width=100%
        >
    <v-card-item >
    
      <v-list-item >
     

      <template v-slot:title>
          <v-card-title class="pb-4">
        
        List Pengajuan Cuti
       
      </v-card-title>
    </template>

      <template v-slot:append>
        <v-btn
         @click="tambah"
          prepend-icon="mdi-plus"
          class="text-none"
          color="primary"
          text="Ajukan Cuti"
          variant="outlined"
          slim
        ></v-btn>
      </template>
    </v-list-item>
     
      <v-divider class="pb-4"></v-divider>
    
    </v-card-item>

    <v-card-text>
     
      <v-table>
    <thead>
      <tr>
        <th class="text-left ">
         <p class="text-subtitle-2"><b>JENIS CUTI</b></p> 
        </th>
        <th class="text-left ">
         <p class="text-subtitle-2"><b>ALASAN CUTI</b></p> 
        </th>
        <th class="text-left ">
         <p class="text-subtitle-2"><b>ALAMAT</b></p> 
        </th>
        <th class="text-left ">
         <p class="text-subtitle-2"><b>TELP</b></p> 
        </th>
        <th class="text-left ">
         <p class="text-subtitle-2"><b>STATUS</b></p> 
        </th>
        <th class="text-center ">
         <p class="text-subtitle-2"><b>AKSI</b></p> 
        </th>
       
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="item in dataCuti.data"
        :key="item.id"
      >
        <td>{{ item.jenis_cuti.jenis_cuti }}</td>
        <td>{{ item.alasan_cuti }}</td>
        <td>{{ item.alamat }}</td>
        <td>{{ item.telp }}</td>
        <td>
          <v-badge
          color="error"
          content="Status"
          inline
        ></v-badge>
        </td>
        <td class="text-center">
          <v-btn-toggle
        
          variant="outlined"
          divided
        >

          <v-btn icon="mdi-account-file-text"   v-on:click="klik(item)" ></v-btn>
          <v-btn icon="mdi-table-clock"></v-btn>
        </v-btn-toggle>
        </td>

      </tr>
    </tbody>
  </v-table>
      
        
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
          dialog: false,
          objRow : null
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
      klik(value){
          this.objRow = value.detail_persetujuan;
          this.dialog = !this.dialog;
      },
      tambah(){
        router.get(route('admin-ajukan-cuti'), {
          }, {
              replace: true,
              preserveScroll: true,
              preserveState: true  
          })
          
      },

    }
    }
</script>