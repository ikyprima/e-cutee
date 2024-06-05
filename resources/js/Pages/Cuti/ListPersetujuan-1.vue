<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
</script>

<template>
  <AdminLayout>

    <v-container>
      <v-dialog v-model="konfirmasi" max-width="500">
        <v-card :color="getColor()" title="KONFIRMASI">

          <v-card-text v-if="valuekonfirmasi === 1">
            Apakah anda yakin menyetujui pengajuan cuti ?
          </v-card-text>
          <v-card-text v-else>
            Apakah anda yakin menolak pengajuan cuti ?
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text="Batal" variant="outlined" @click="tutupkonfirmasi"></v-btn>
            <v-btn v-if="valuekonfirmasi === 1" text="Ya, Setujui" variant="outlined" @click="simpan"></v-btn>
            <v-btn v-else text="Ya, Tolak" variant="outlined" @click="simpan"></v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog v-model="dialog" fullscreen>

        <v-card title="DETAIL">

          <template v-slot:text>
            <v-divider class="pb-4"></v-divider>
            <v-row>
              <v-col cols="4">
                <v-card class="mx-auto" max-width="368" :elevation="20">

                  <v-card-text class="py-0">
                    <v-row align="center" no-gutters>
                      <v-col class="text-h2 text-center pt-4">

                        <v-avatar :image="image" size="120"></v-avatar>
                      </v-col>


                    </v-row>
                  </v-card-text>

                  <v-list-item density="compact" v-if="objRow !== null">
                    <v-divider class="border-opacity-25 mt-2 "></v-divider>
                    <v-list-item-title class="text-uppercase mt-2">{{ objRow.nama }}</v-list-item-title>
                    <v-divider class="border-opacity-25 mt-2 "></v-divider>
                    <v-list-item-subtitle class="mt-2 mb-1 text-uppercase">NIP : {{ objRow.nip }}</v-list-item-subtitle>
                    <v-divider class="border-opacity-25 mt-2"></v-divider>
                    <v-list-item-subtitle class="mt-2 mb-1 text-uppercase ">{{ objRow.jabatan }}</v-list-item-subtitle>
                    <v-divider class="border-opacity-25 mt-2"></v-divider>
                  </v-list-item>



                  <div class="d-flex py-3 justify-space-between">
                    <v-list-item density="compact">
                      <v-list-item-subtitle>12</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item density="compact" prepend-icon="mdi-weather-windy">
                      <v-list-item-subtitle>12</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item density="compact" prepend-icon="mdi-weather-pouring">
                      <v-list-item-subtitle>4</v-list-item-subtitle>
                    </v-list-item>
                  </div>



                </v-card>

              </v-col>

              <v-col>

                <v-sheet class="pa-4 mx-auto" :elevation="20" min-height="70vh" rounded="lg">
                  <!--  -->
                  <h2 class="text-h5 m-6 pb-4">INFORMASI PENGAJUAN</h2>
                  <v-table density="compact" class=" mb-4" v-if="objRow !== null">
                    <tbody>
                      <tr>
                        <th class="text-left border-b-thin" style="width:30%">
                          JENIS CUTI
                        </th>
                        <th class="text-left  border-b-thin">
                          <v-list-item-subtitle>{{ objRow.jenis_cuti.jenis_cuti }}</v-list-item-subtitle>
                        </th>
                      </tr>
                      <tr>
                        <th class="text-left border-b-thin">
                          ALASAN CUTI
                        </th>
                        <th class="text-left  border-b-thin">
                          <v-list-item-subtitle>{{ objRow.alasan_cuti }}</v-list-item-subtitle>
                        </th>
                      </tr>
                      <tr>
                        <th class="text-left border-b-thin">
                          ALAMAT
                        </th>
                        <th class="text-left  border-b-thin">
                          <v-list-item-subtitle>{{ objRow.alamat }}</v-list-item-subtitle>
                        </th>
                      </tr>
                      <tr>
                        <th class="text-left border-b-thin">
                          TELP
                        </th>
                        <th class="text-left  border-b-thin">
                          <v-list-item-subtitle>{{ objRow.telp }}</v-list-item-subtitle>
                        </th>
                      </tr>

                    </tbody>
                  </v-table>
                  <FullCalendar :options='calendarOptions'>
                  </FullCalendar>

                  <v-divider class="pb-6"></v-divider>
                  <v-container fluid>
                    <v-timeline size="large" side="end">
                    <v-timeline-item  v-if="objRow !== null"
                    v-for="item in objRow.detail_persetujuan"
                      :key="item.id"
                      dot-color="pink"
                      size="small"
                    >
                      <div class="d-flex">
                      <v-card class="elevation-2" min-width="800">
                          <v-card-title class="text-h5">
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
                          </v-card-title>
                      <v-card-text>
          
                        <div>
                          <strong class="me-4">{{item.nama_pegawai?item.nama_pegawai:"Nama Pegawai"}}</strong>
                          <div class="text-caption">
                            {{ moment(item.created_at).format('YYYY-MM-DD HH:mm:ss') }}
                          </div>
                        </div>
                      </v-card-text>
            </v-card>
                      </div>
                    </v-timeline-item>
                  </v-timeline>
                    
                    </v-container> 
                 
                </v-sheet>
              </v-col>
            </v-row>



          </template>

          <v-card-actions>
            <v-spacer></v-spacer>
            <template v-if="objRow!=null">
              <v-btn v-if="objRow.status_persetujuan != 1" color="error" text="TOLAK" variant="flat" @click="konfirmasisetujui(0)"></v-btn>
              <v-btn v-if="objRow.status_persetujuan != 1" color="info" text="SETUJUI" variant="flat" @click="konfirmasisetujui(1)"></v-btn>
            
            </template>
            <v-btn color="surface-variant" text="TUTUP" variant="flat" @click="tutupdialog"></v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-row>
        <v-card class="mx-auto my-8" elevation="16" min-width=100%>
          <v-card-item>

            <v-list-item>


              <template v-slot:title>
                <v-card-title class="pb-4">

                  List Persetujuan Cuti

                </v-card-title>
              </template>


            </v-list-item>

            <v-divider class="pb-4"></v-divider>

          </v-card-item>

          <v-card-text>

            <v-table>
              <thead>
                <tr>
                  <th class="text-left ">
                    <p class="text-subtitle-2"><b>NIP</b></p>
                  </th>
                  <th class="text-left ">
                    <p class="text-subtitle-2"><b>NAMA</b></p>
                  </th>
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
                <tr v-for="item in dataCuti" :key="item.id">
                  <td>{{ item.nip }}</td>
                  <td>{{ item.nama }}</td>
                  <td>{{ item.jenis_cuti.jenis_cuti }}</td>
                  <td>{{ item.alasan_cuti }}</td>
                  <td>{{ item.alamat }}</td>
                  <td>{{ item.telp }}</td>
                  <td>
                    <v-badge v-if="item.status_persetujuan == 0" color="info" content="Menunggu Persetujuan"
                      inline></v-badge>
                    <v-badge v-else-if="item.status_persetujuan == 1" color="green" content="Disetujui"
                      inline></v-badge>
                    <v-badge v-else color="error" content="Ditolak" inline></v-badge>
                  </td>
                  <td class="text-center">
                    <v-btn-toggle variant="outlined" divided>

                      <v-btn icon="mdi-account-edit" v-on:click="klik(item)"></v-btn>
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
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import image from "@/img/bootstrap.jpg";
import { INITIAL_EVENTS, createEventId } from './event-utils'
export default {
  props: {
    dataCuti: Object,


  },
  components: { FullCalendar },

  // data: () => ({

  // }),
  data() {
    return {
      image:image,
      konfirmasi: false,
      dialog: false,
      objRow: null,
      valuekonfirmasi: null, // 1 setuju / 0 ditolak
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          interactionPlugin // needed for dateClick
        ],
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
        initialView: 'dayGridMonth',
        initialDate: null,
        // initialEvents: INITIAL_EVENTS, // alternatively, use the `events` setting to fetch from a feed
        editable: false,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        handleWindowResize: true,
        events: [
          // { title: 'event 1', date: '2024-04-01',color:'#ff0000' },
          //     { title: 'event 2', date: '2024-04-02' }
        ]
        /* 
        eventAdd:
        eventChange:
        eventRemove:
        */
      },

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
    klik(value) {
      this.objRow = value;
      this.dialog = !this.dialog;
      this.calendarOptions.events = value.tanggal_cuti
      this.calendarOptions.initialDate = value.tanggal_cuti[0].date
    },
    tutupkonfirmasi() {
      this.konfirmasi = !this.konfirmasi;
      this.valuekonfirmasi = null;

    },
    tutupdialog() {
      this.valuekonfirmasi = null;
      this.objRow = null
      this.calendarOptions.events = []
      this.dialog = !this.dialog;
     

    },
    konfirmasisetujui(value) {
      this.konfirmasi = !this.konfirmasi;
      this.valuekonfirmasi = value;

    },
    simpan() {

      router.post(route('admin-persetujuan-cuti-simpan'), {
        id: this.objRow.id,
        id_ajukan_cuti: this.objRow.id_ajukan_cuti,
        id_detail_hirarki: this.objRow.id_detail_hirarki,
        status: this.valuekonfirmasi
      },
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => {
            this.konfirmasi = !this.konfirmasi;
            this.valuekonfirmasi = null;
            this.dialog = !this.dialog;
            this.objRow = null
          },
        }
      )
    },
    getColor() {
      return this.valuekonfirmasi === 1 ? 'primary' : 'error';
    }

  }
}
</script>