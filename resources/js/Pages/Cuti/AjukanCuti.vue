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
        Ajukan Cuti
      </v-card-title>
      <v-divider class="pb-4"></v-divider>
    
    </v-card-item>

    <v-card-text>
        <v-combobox
            clearable
            label="Jenis Cuti Yang Diambil"
            :items="itemsJenisCuti"
            variant="outlined"
            v-model="formAjukanCuti.jenisCuti"
        ></v-combobox>
        <v-text-field clearable label="Alasan Cuti" variant="outlined" v-model="formAjukanCuti.alasanCuti"></v-text-field>
        <div class="text-subtitle-2 mb-2">Silahkan Pilih Tanggal </div>
        <v-divider class="border-opacity-25 pb-4" ></v-divider>
        <FullCalendar class='demo-app-calendar' :options='calendarOptions'>
            <template v-slot:eventContent='arg'>
                <b>{{ arg.timeText }}</b>
                <i>{{ arg.event.title }}</i>
            </template>
        </FullCalendar>
        <v-textarea class="pt-4" label="Alamat Selama Menjalankan Cuti" variant="outlined" v-model="formAjukanCuti.alamat"></v-textarea>
        <v-text-field clearable label="Nomor Telp" variant="outlined" v-model="formAjukanCuti.noTelp"></v-text-field>
    </v-card-text>
    <v-card-actions>
      
      <v-list-item class="w-100">
   

        <template v-slot:append>
          <div class="justify-self-end">
            <v-btn
            class="text-none mb-4"
            color="indigo-darken-3"
            variant="flat"
            block
            text="AJUKAN CUTI"
            v-on:click="simpan" 
            :class="{ 'opacity-25': formAjukanCuti.processing }" :disabled="formAjukanCuti.processing"
        ></v-btn>
     
          </div>
        </template>
      </v-list-item>
    </v-card-actions>
  </v-card>
        </v-row>
    </v-container>
    
    </AdminLayout>
</template>
<script>
// import '@fullcalendar/core/vdom'
import moment from 'moment';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import { INITIAL_EVENTS, createEventId } from './event-utils'
  export default {
    components: {  FullCalendar },
    
    // data: () => ({
        
    // }),
    data() {
        return {
            formAjukanCuti: this.$inertia.form({
                jenisCuti: null,
                alasanCuti: null,
                alamat: null,
                noTelp: null,
                tanggal : [],
                
            }),
            calendarOptions: {
                plugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin // needed for dateClick
                ],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'dayGridMonth',
                // initialEvents: INITIAL_EVENTS, // alternatively, use the `events` setting to fetch from a feed
                editable: false,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                weekends: true,
                select: this.handleDateSelect,
                eventClick: this.handleEventClick,
                eventsSet: this.handleEvents,
                events: [
                    { title: 'event 1', date: '2024-04-01' },
                    { title: 'event 2', date: '2024-04-02' }
                ]
                /* 
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
            currentEvents: [],
            eventsAll: [],
            itemsJenisCuti: [
                { value: 1, title: 'Cuti Tahunan' },
                { value: 2, title: 'Cuti Sakit' },
                { value: 3, title: 'Cuti Karena Alasan Penting' },
                { value: 4, title: 'Cuti Besar' },
                { value: 5, title: 'Cuti Melahirkan' },
                { value: 6, title: 'Cuti Diluar Tanggungan Negara' }
            ]
        };
    },
    computed: {
       
    },
    mounted() {
        
    },
    methods: {
        simpan() {
        
                this.formAjukanCuti.post(route('admin-ajukan-cuti-simpan'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.formAjukanCuti.reset();
                    },
                })
            
        },

        handleWeekendsToggle() {
            this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
        },

        handleDateSelect(selectInfo) {
            // let title = prompt('Please enter a new title for your event')
            let title = this.formAjukanCuti.jenisCuti?this.formAjukanCuti.jenisCuti.title:'cuti'
            let calendarApi = selectInfo.view.calendar
            const events = selectInfo.view.calendar.getEvents(); // Mendapatkan semua acara yang sedang ditampilkan
            const currentDate = selectInfo.start.toISOString().slice(0, 10); // Mendapatkan tanggal acara yang sedang dirender
          // Mengecek apakah ada acara lain pada tanggal yang sama
            const eventExists = events.some(event => {
                const eventDate = event.start.toISOString().slice(0, 10);
                return eventDate === currentDate && event.id !== selectInfo.id;
            });

            // Jika ada acara lain pada tanggal yang sama, jangan tampilkan acara ini
            if (eventExists) {
            
                const eventsToRemove = events.filter(event => {
                    const eventDate = event.start.toISOString().slice(0, 10);
                    return eventDate === currentDate;
                });

                // Remove the events from the calendar
                eventsToRemove.forEach(event => {
                    event.remove();
                });
            //    console.log('ada event');
            }else{
                calendarApi.unselect() // clear date selection

                if (title) {
                    calendarApi.addEvent({
                        id: createEventId(),
                        title,
                        start: selectInfo.startStr,
                        end: selectInfo.endStr,
                        allDay: selectInfo.allDay
                    })
                }
            }
        },

        handleEventClick(clickInfo) {
            if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
                clickInfo.event.remove()
            }
        },

        handleEvents(events) {
            this.currentEvents = events
            this.formAjukanCuti.tanggal = events.map(event => ({
                'title':event.title,
                'tgl':event.startStr,
                // 'end': event.endStr // End date
                // 'end': event.endStr ? moment(event.endStr).subtract(1, 'day').format() : null
            }));
      
        },
      

    }
    }
</script>