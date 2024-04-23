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
            :items="['Cuti Tahunan', 'Cuti Sakit', 'Cuti Karena Alasan Penting', 'Cuti Besar', 'Cuti Melahirkan', 'Cuti di Luar Tanggungan Negara']"
            variant="outlined"
        ></v-combobox>
        <v-text-field clearable label="Alasan Cuti" variant="outlined"></v-text-field>
        <div class="text-subtitle-2 mb-2">Silahkan Pilih Tanggal </div>
        <v-divider class="border-opacity-25 pb-4" ></v-divider>
        <FullCalendar class='demo-app-calendar' :options='calendarOptions'>
            <template v-slot:eventContent='arg'>
                <b>{{ arg.timeText }}</b>
                <i>{{ arg.event.title }}</i>
            </template>
        </FullCalendar>
        <v-textarea class="pt-4" label="Alamat Selama Menjalankan Cuti" variant="outlined"></v-textarea>
        <v-text-field clearable label="Nomor Telp" variant="outlined"></v-text-field>
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
                // events: [
                //     { title: 'event 1', date: '2024-04-01' },
                //     { title: 'event 2', date: '2024-04-02' }
                // ]
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
            currentEvents: [],
            eventsAll: []
        };
    },
    computed: {
       
    },
    mounted() {
        
    },
    methods: {

        handleWeekendsToggle() {
            this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
        },

        handleDateSelect(selectInfo) {
            let title = prompt('Please enter a new title for your event')
            let calendarApi = selectInfo.view.calendar
            
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
        },

        handleEventClick(clickInfo) {
            if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
                clickInfo.event.remove()
            }
        },

        handleEvents(events) {
            this.currentEvents = events
            this.eventsAll = events.map(event => ({
                'title':event.title,
                'tgl':event.startStr,
                // 'end': event.endStr // End date
                // 'end': event.endStr ? moment(event.endStr).subtract(1, 'day').format() : null
            }));
      
        },
      

    }
    }
</script>