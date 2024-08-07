<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import Card from "@/Components/notus/Cards/Card.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import { Head,Link,router } from '@inertiajs/vue3';
import ButtonTambah from '@/Components/notus/Buttons/ButtonTambah.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/notus/Dialog.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect'
import toast from '@/Stores/toast.js';
import ToastList from '@/Components/notus/Notifications/ToastList.vue';
// import { Select, initTE } from "tw-elements";
// initTE({ Select });
</script>

<template>

    <Head title="Ajukan Cuti" />

    <AdminLayout>
        <template #textnavbar>
            AJUKAN 
        </template> 
        <template #notif>
            <ToastList/>
        </template>
 
        <template #header>
            <header-stats>
                <template #kontenheader>
                    
                </template>
                
            </header-stats>
        </template>

        <card :minheigth="'min-h-0'">
                        <template #headercard>
                            <div class="pt-2 pb-2 mx-8 border-b border-solid border-blueGray-200 ">
                                <div class="flex flex-wrap items-center">
                                <div class="max-w-full flex-grow">
                                    <h3 class="font-semibold text-lg"
                                        :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
                                        Tambah Cuti
                                    </h3>
                                
                                </div>
                                    <div class="relative md:w-full md:max-w-full flex-grow flex-1 text-right">
                                        <div class="hidden md:block">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template> 
                        <div class="bg-white   w-full transform transition-all sm:w-full sm:mx-auto ">
                            <div class="relative px-6 pb-4 mx-2 flex-auto">
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 py-2">
                                    <div class="relative  ">

                                        <InputLabel value="Jenis " class="" />
                                        <Multiselect 
                                        v-model="formAjukanCuti.jenisCuti"
                                        valueProp="value" 
                                        label="title" 
                                        class="mt-1 block w-full" 
                                        :options="itemsJenisCuti"
                                        :searchable="true"
                                        @select="() => pilihJenisCuti()"
                                    
                                        />
                                        <p v-if="formAjukanCuti.errors.jenisCuti" 
                                            class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            {{formAjukanCuti.errors.jenisCuti }}
                                        </p>
                                    </div>
                                
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 py-2">
                                    <div class="relative  ">

                                    
                                        <InputLabel value="Lampiran " class="" />
                                        <input
                                            id="fileInput"
                                            type="file"
                                            ref="lampiran"
                                            @input="formAjukanCuti.file = $event.target.files[0]" 
                                            accept=".jpeg,.jpg,.pdf"
                                            class="
                                                w-full
                                                px-4
                                                py-2
                                                mt-2
                                                border
                                                rounded-md
                                                focus:outline-none
                                                focus:ring-1
                                                focus:ring-blue-600
                                            "
                                        />
                                        <p v-if="formAjukanCuti.errors.file" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                            formAjukanCuti.errors.file }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 py-2">
                                    
                                    <div class="relative  ">
                                        <InputLabel value="Alasan " class="" />
                                        <TextInput
                                        v-model="formAjukanCuti.alasanCuti"
                                        id="alasanId" 
                                        ref="AlasanInput"
                                        type="text" class="mt-1 block w-full"
                                        />
                                        <p v-if="formAjukanCuti.errors.alasanCuti" 
                                            class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            {{formAjukanCuti.errors.alasanCuti }}
                                        </p>
                                    </div>
                                </div>
                                <div v-if="formAjukanCuti.jenisCuti == 4 || formAjukanCuti.jenisCuti == 5 || formAjukanCuti.jenisCuti == 6" class="grid grid-cols-2 md:grid-cols-2 gap-2 py-2">
                                    
                                    <div class="relative  ">
                                        <InputLabel value="Pilih Range Tanggal" class="" />
                                        <VueDatePicker 
                                        v-model="dataDatepicker"
                                        range
                                        :enable-time-picker="false" 
                                        :format="'dd-MM-yyyy'"
                                        class="mt-1 block w-full "
                                        @update:model-value="handleDate"
                                        />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-1 py-2">

                                <FullCalendar  ref="calendar" class='demo-app-calendar' :options='calendarOptions'>

                                </FullCalendar>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 py-2">
                                    
                                        <div class="relative ">
                                                    <InputLabel value="Alamat Selama Cuti" class="" />
                                                        <textarea
                                                        type="text"
                                                        class="border-gray-300 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                        rows="4"
                                                        v-model="formAjukanCuti.alamat"
                                                        >
                                                        </textarea>
                                            </div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 py-2">
                                    
                                    <div class="relative  ">

                                        <InputLabel value="Nomor Telp" class="" />
                                        <TextInput 
                                        id="telpId"
                                        ref="telpInput" 
                                        type="text" 
                                        v-model="formAjukanCuti.noTelp"
                                        class="mt-1 block w-full"
                                        />
                                        
                                        <p v-if="formAjukanCuti.errors.noTelp" 
                                            class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            {{formAjukanCuti.errors.noTelp }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <template #footercard>
                            <div class="flex flex-row justify-end py-4 mx-2">
                            <div class="mx-2"> 
                                <PrimaryButton  
                                    class="bg-red-600 hover:bg-red-400 focus:bg-red-400 focus:ring-red-600 ">
                                        Batal
                                </PrimaryButton></div>
                            <div class="mx-2">
                                
                                <PrimaryButton class="ml-3" v-on:click="simpan" 
                                :class="{ 'opacity-25': formAjukanCuti.processing }" :disabled="formAjukanCuti.processing">
                                    Simpan
                                
                                </PrimaryButton>
                            </div>
                            
                            </div>
                    
                    </template>

        </card>

    </AdminLayout>
    

</template>

<script>
import moment from 'moment';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import { INITIAL_EVENTS, createEventId } from './event-utils'
export default {
    mounted() {

        const startDate = new Date();
        const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
        this.dataDatepicker = [startDate, startDate];
        this.data_tanggal.forEach(element => {
            this.calendarOptions.events.push(
                { 
                    title: element.title,
                    date: element.tgl,
                    color:'#FF0000',
                    daridb : true
                }
            )
        });
    },
    
    props:{
        color: {
            default: "light",
            validator: function (value) {
                // The value must match one of these strings
                return ["light", "dark"].indexOf(value) !== -1;
            },
        },
        data_tanggal : Object,
        rekap_cuti : Object
    },

    data() {
        return {
            dataDatepicker: null,
            filteredDates: [],
            formAjukanCuti: this.$inertia.form({
                file:'',
                tanggalAwal : '',
                tanggalAkhir : '',
                jenisCuti: '',
                alasanCuti: '',
                alamat: '',
                noTelp: '',
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
                    right: ''
                },
                initialView: 'dayGridMonth',
                // initialEvents: INITIAL_EVENTS, // alternatively, use the `events` setting to fetch from a feed
                editable: false,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                weekends: false,
                select: this.handleDateSelect,
                // eventClick: this.handleEventClick,
                // eventsSet: this.handleEvents,
                events: [
                    
                 ]
                /* 
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
            currentEvents: [],
            itemsJenisCuti: [
                { value: '', title: 'Silahkan Pilih' },
                { value: 1, title: 'Cuti Tahunan' },
                { value: 2, title: 'Cuti Sakit' },
                { value: 3, title: 'Cuti Karena Alasan Penting' },
                { value: 4, title: 'Cuti Besar' },
                { value: 5, title: 'Cuti Melahirkan' },
                { value: 6, title: 'Cuti Diluar Tanggungan Negara' }
            ]
        };
    },
    components: { 
        FullCalendar,
        Multiselect

    },
    computed: {
    
    },
    
    methods: {
        pilihJenisCuti(){
            // this.currentEvents = [];
            // this.calendarOptions.events = [];
            // this.formAjukanCuti.tanggal = [];
        },

        handleDate(modelData) {
         

            const calendarApi = this.$refs.calendar.getApi();
            
            const events = calendarApi.getEvents(); 
            const eventsToRemove = events.filter(event => {
                        const daridb = event.extendedProps.daridb;
                        return daridb === false;
            });
            eventsToRemove.forEach(event => {
                        if (!event.extendedProps.daridb) {
                            event.remove();
                            console.log('Extended Props:', event.extendedProps);

                            const indextgl = this.formAjukanCuti.tanggal.findIndex(item => item.id === event.id);
                            if (indextgl !== -1) {
                                this.formAjukanCuti.tanggal.splice(indextgl, 1);
                            }
                        }
                    
                    
                    });
            
                    
            // const allEvents = calendarApi.getEvents();

            // let arrayEventYangSudahAda = [];
            // _.forEach(allEvents, function(event) {

            //     arrayEventYangSudahAda.push({
            //         date:moment(event.date).format('YYYY-MM-DD'),
            //         daridb : true 
            //     }
            //     );
            // });
           
        
            let arrayEventYangSudahAda =this.calendarOptions.events;
            let newarrray = []
            _.forEach(modelData, function(modelData) {
                newarrray.push(moment(modelData).format('YYYY-MM-DD'));
            });
        
        
            this.formAjukanCuti.tanggalAwal = newarrray[0];
            this.formAjukanCuti.tanggalAkhir = newarrray[1];
            this.dataDatepicker = modelData;

            let start = moment(newarrray[0]);
            let end = moment(newarrray[1]);
            let dates = [];
            

            while (start <= end) {
            // Only add the date if it is not Saturday (6) or Sunday (0)
                if (start.day() !== 0 && start.day() !== 6) {
                    let dataKalender = {
                        title: this.itemsJenisCuti.find(item => item.value == this.formAjukanCuti.jenisCuti).title,
                        date: start.format('YYYY-MM-DD'),
                        color: '#5C88C4',
                        daridb : false
                    };
                    // dates.push(start.format('YYYY-MM-DD'));
                    dates.push(dataKalender);
                }
                start.add(1, 'days');
            }
          
            const cekEventYangAda =arrayEventYangSudahAda.some(eventSatu => 
                dates.some(eventDua =>
                    eventSatu.date === eventDua.date
                )
            );

            if (cekEventYangAda) {
                toast.add({
                    message: 'Range Tanggal Yang Dipilih Sudah Ada Yang Terisi Cuti, silahkan hapus terlebih dahulu',
                    category : 'warning',
                    duration : 6000
                })
            }else{

                dates.forEach(item => {
                    const id = createEventId();
                    
                    calendarApi.addEvent({
                        id: id,
                        title: item.title,
                        start: item.date,
                        color: item.color,
                        daridb : item.daridb
                    })

                
                    this.formAjukanCuti.tanggal.push({
                        'id': id,
                        'title':item.title,
                        'tgl':item.date,
                        'color':item.color,
                        // 'end': event.endStr // End date
                        // 'end': event.endStr ? moment(event.endStr).subtract(1, 'day').format() : null
                    })

                });

                // _.forEach(dates, function(item){
                    
                // });

                // this.calendarOptions.events= dates;
            }
        
        },

        handleWeekendsToggle() {
            this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
        },

        handleDateSelect(selectInfo) {
            if (this.formAjukanCuti.jenisCuti === '') {
                //jika belum pilih jenis cuti
                toast.add({
                    message: 'Silahkan Pilih Jenis Cuti',
                    category : 'warning'
                })
            }else{
                // let title = prompt('Please enter a new title for your event')
                // let title = this.formAjukanCuti.jenisCuti?this.formAjukanCuti.jenisCuti.title:'cuti'
                let title = this.itemsJenisCuti.find(item => item.value == this.formAjukanCuti.jenisCuti).title
                let calendarApi = selectInfo.view.calendar
            
                const events = selectInfo.view.calendar.getEvents(); // Mendapatkan semua acara yang sedang ditampilkan
                // const currentDate = selectInfo.start.toISOString().slice(0, 10); // Mendapatkan tanggal acara yang sedang dirender
                const currentDate = selectInfo.startStr; // Mendapatkan tanggal acara yang sedang dirender
                // Mengecek apakah ada acara lain pada tanggal yang sama
                const eventExists = events.some(event => {
                    // const eventDate = event.start.toISOString().slice(0, 10);
                    const eventDate = event.startStr;
                    return eventDate === currentDate && event.id !== selectInfo.id;
                });
                
            
                // Jika ada acara lain pada tanggal yang sama, jangan tampilkan acara ini

                if (eventExists) {
                   

                    const eventsToRemove = events.filter(event => {
                        // console.log('Extended Props:', event.extendedProps);
                        // const eventDate = event.start.toISOString().slice(0, 10);
                     
                        const eventDate = event.startStr;
                        return eventDate === currentDate;
                    });

    
                  
                    // Remove the events from the calendar
                    eventsToRemove.forEach(event => {
                        if (!event.extendedProps.daridb) {
                            event.remove();
                            const indextgl = this.formAjukanCuti.tanggal.findIndex(item => item.id === event.id);
                            if (indextgl !== -1) {
                                this.formAjukanCuti.tanggal.splice(indextgl, 1);
                            }
                        }
                    
                    
                    });
                //    console.log('ada event');
                }else{
                    calendarApi.unselect() // clear date selection

                    if (title) {
                        // console.log(selectInfo.startStr);
                        // console.log(selectInfo.endStr);
                            const id = createEventId();
                       

                        calendarApi.addEvent({
                            id: id,
                            title,
                            start: selectInfo.startStr,
                            // end: selectInfo.endStr,
                            allDay: selectInfo.allDay,
                            color:'#5C88C4',
                            daridb : false
                        })
                        
                        this.formAjukanCuti.tanggal.push({
                                'id': id,
                                'title':title,
                                'tgl':selectInfo.startStr,
                                'color':"#5C88C4",
                                // 'end': event.endStr // End date
                                // 'end': event.endStr ? moment(event.endStr).subtract(1, 'day').format() : null
                            })
                    }
                }
            }
        
        },

        handleEventClick(clickInfo) {
            // if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
            //     clickInfo.event.remove()
            // }
        },

        handleEvents(events) {
            // console.log(events);
            // let tglawal,tglakhir ;
            // events.forEach(event => {
            //     const startDate = moment(event.startStr);
            //     const endDate =moment(event.endStr).subtract(1, 'day').format();
            //         // console.log(event.startStr),
            //         // console.log(moment(event.endStr).subtract(1, 'day').format())
            //         let currentDate = startDate.clone();
            //         while (currentDate.isSameOrBefore(endDate, 'day')) {
            //             // Format tanggal dalam format YYYY-MM-DD
            //             console.log(currentDate.format('YYYY-MM-DD'));
            //             // Tambahkan satu hari
            //             currentDate.add(1, 'days');
            //         }
            // });
            
         
            // console.log(tglawal + '1');
            // console.log(tglakhir + '2');
            this.currentEvents = events
            this.formAjukanCuti.tanggal = events.map(event => ({
                'title':event.title,
                'tgl':event.startStr,
                'color':event.backgroundColor,
                // 'end': event.endStr // End date
                // 'end': event.endStr ? moment(event.endStr).subtract(1, 'day').format() : null
            }));
        },
        simpan() {
          
            if (this.formAjukanCuti.tanggal.length > 0) {
            
                if (this.formAjukanCuti.jenisCuti == 1 && ( this.formAjukanCuti.tanggal.length > this.rekap_cuti.sisa_cuti_tahunan) ) {
                    toast.add(
                    {
                        message: 'Sisa Kuota Cuti Tahunan Anda Tidak Mencukupi',
                        category : 'warning'
                    }
                )
                }else{
                    this.formAjukanCuti.post(route('admin-ajukan-cuti-simpan'), {
                        preserveScroll: true,
                        preserveState: true,
                        onSuccess: () => {
                            this.formAjukanCuti.reset();
                        },
                        onError: (errors) => {
                            toast.add({
                                message: errors.global_error,
                                category : 'warning',
                                duration : 6000
                            })
                        },
                    })
                
                   
                }
            
            }else{
                toast.add(
                    {
                        message: 'Silahkan Pilih Tanggal',
                        category : 'warning'
                    }
                )
            }
        },
        


    },

    
};
</script>