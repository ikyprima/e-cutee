<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import { Head,Link, router } from '@inertiajs/vue3';
import ButtonTambah from '@/Components/notus/Buttons/ButtonTambah.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/notus/Dialog.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import CardStats from "@/Components/notus/Cards/CardStats.vue";
import image from "@/img/no-image.png";
import toast from '@/Stores/toast.js';
import ToastList from '@/Components/notus/Notifications/ToastList.vue';
// import { Select, initTE } from "tw-elements";
// initTE({ Select });
</script>

<template>

    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #textnavbar>
            Dashboard
        </template> 
        <template v-if="!dialogView" #notif>
            <ToastList  />
        </template> 
        <template #header>
            <header-stats>
                <template #kontenheader>


            
                        
                    <div class="max-w-full mx-auto">
                        
                        <div class="rounded-lg m-4 bg-white shadow-lg sm:grid sm:grid-cols-6">
                        <div class="flex flex-col  border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                            <div class="order-2 mt-2 text-lg leading-6 font-extrabold text-gray-500">
                                Cuti Tahunan
                            </div>
                            <dd class="order-1 text-5xl font-extrabold text-gray-700">{{ data_rekap.cuti_tahunan }}</dd>
                        </div>
                        <div
                            class="flex flex-col border-t border-b border-gray-100 p-6 text-center sm:border-0 sm:border-l sm:border-r">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">
                               Cuti Sakit
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-gray-700">{{ data_rekap.cuti_sakit }}</dd>
                        </div>
                        <div
                            class="flex flex-col border-t border-b border-gray-100 p-6 text-center sm:border-0 sm:border-l sm:border-r">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">
                                Cuti Karena Alasan Penting
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-gray-700">{{ data_rekap.cuti_karena_alasan_penting }}</dd>
                        </div>
                        <div
                            class="flex flex-col border-t border-b border-gray-100 p-6 text-center sm:border-0 sm:border-l sm:border-r">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">
                                Cuti Besar
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-gray-700">{{ data_rekap.cuti_besar }}</dd>
                        </div>
                        <div
                            class="flex flex-col border-t border-b border-gray-100 p-6 text-center sm:border-0 sm:border-l sm:border-r">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">
                                Cuti Melahirkan
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-gray-700">{{ data_rekap.cuti_melahirkan }}</dd>
                        </div>
                        
                        <div class="flex flex-col border-t border-gray-100 p-6 text-center sm:border-0 sm:border-l">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">
                                Cuti Diluar Tanggungan Negara
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-gray-700">{{ data_rekap.cuti_diluar_tanggungan_negara }}</dd>
                            
                        </div>
                        
                    </div>
                    
                </div>


                

                    </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-7">
            <div class="w-full mb-12 px-4">

                <div class="grid grid-cols-3 gap-4">
                
                <div class="col-span-2">
                    <card-table   @klik="klikMethod" :list=dataCuti.data :header=setting :namaTitle="'List Pengajuan Terbaru'">
                            <template #button>
                                <div class="hidden md:block">
                                    <ButtonTambah @click="tambahData">AJUKAN CUTI</ButtonTambah>
                                </div>
                                <div class="md:min-w-full md:hidden block">
                                    <div class="flex flex-wrap">
                                        <div class="w-full">
                                            <button
                                                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                                                type="button">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                    </card-table>
                </div>
                <div > 
                    <a class="relative  bg-indigo-900 block p-6 border border-gray-100 rounded-lg max-w-sm mx-auto shadow-lg" href="#">
  
                <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>

                <div class="my-4">
                    <h2 class="text-white text-2xl font-bold pb-2">Sisa Cuti Tahunan </h2>
                    <h2 class="text-white text-2xl font-bold pb-2">{{ sisa_cuti_tahunan }} Hari Lagi </h2>
                   
                </div>

                <div class="flex justify-end">
                    <button class="px-2 py-1 text-white border border-gray-200 font-semibold rounded hover:bg-gray-800">Detail</button>
                </div>
                </a>
                <ul class="bg-white shadow overflow-hidden sm:rounded-b-md max-w-sm mx-auto mt-2">
                    <li>
                        <div class="px-4 py-5 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Pengajuan Cuti </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Tanggal 01-12-2023</p>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-500">Status: <span class="text-green-600">Disetujui</span></p>
                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Detail</a>
                            </div>
                        </div>
                    </li>
                    
                </ul>
                    
                   
                    
                    </div>
        

            </div>
               
              
            </div>

        </div>
    </AdminLayout>
    <Modal :show="dialogView" @close="closeDialogView" :maxWidth="'5xl'">
        <ToastList/>
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    View Detail Persetujuan
                </h3>
            </div>
            <div class="block w-full overflow-x-auto p-6">
                    <table class="items-center w-full bg-transparent border-collapse">
                        <thead class="thead-light">
                            
                        </thead>
                        <tbody>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-3 text-left w-1/4"> NAMA </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-3">{{objRowSelect.pegawai.nama}}  </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-3 text-left w-1/4"> NIP </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-3">{{objRowSelect.pegawai.nomor_induk_pegawai}} </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> JABATAN </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">{{objRowSelect.pegawai.jabatan_organisasi.nama_jabatan}} </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> JENIS CUTI </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4"> {{objRowSelect.jenis_cuti.jenis_cuti}} </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> ALASAN CUTI </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4"> {{objRowSelect.alasan_cuti}} </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> TANGGAL CUTI </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4"> 
                                    <span v-for="item in objRowSelect.tanggal" class="text-s font-semibold inline-block py-1 px-2 uppercase rounded-full last:mr-0 mr-1 text-blue-200 bg-blue-500">
                                        {{ item.date }}
                                </span>
                                </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> LAMPIRAN </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4"> 
                                    <template v-for="item in objRowSelect.lampiran">
                                        <SecondaryButton @click="lihatLampiran(item)">
                                            Lihat
                                        </SecondaryButton>
                                    </template>
                                   
                                </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> ALAMAT SELAMA CUTI </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4"> {{objRowSelect.alamat}} </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> NO TELP </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4"> {{objRowSelect.telp}} </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> PERSSETUJUAN CUTI </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4"> 
                                    <ol class="relative border-s border-gray-200 dark:border-gray-500">                  
                                        <li v-for="(timeline, index) in objRowSelect.detail_persetujuan " class="ms-6" 
                                        :class="(index === objRowSelect.detail_persetujuan.length - 1) ? '' : 'mb-12'">            
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-500 dark:bg-blue-900">
                                                <img class="rounded-full shadow-lg" src="/docs/images/people/profile-picture-3.jpg" @error="$event.target.src = image" alt="Bonnie image"/>
                                            </span>
                                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 ">{{ timeline['pegawai']['nama'] }}
                                                <span class="  text-sm font-medium me-2 px-2.5 py-0.5 rounded  ms-3"
                                                    :class="(timeline['status'] == 2) ? 'bg-red-100 text-red-800':'bg-blue-100 text-blue-800'"
                                                >
                                                    {{ timeline['status'] == 0 ? 'menunggu persetujuan':  timeline['status'] == 1  ? 'disetujui' :  timeline['status'] == 2 ? 'ditolak'  : 'tidak diketahui' }}
                                                </span>
                                            </h3>
                                            <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ timeline['jabatan'] }}</time>
                                            <blockquote v-if="timeline['status'] == 2" class="p-1 my-4 border-s-4 border-gray-300 bg-gray-50 ">
                                                <p class="text-sm italic font-medium leading-relaxed text-gray-900">"{{ timeline['alasan_tolak'] }}"</p>
                                            </blockquote>
                                        </li>
                                    </ol>
                                
                                </td>
                            </tr>
                        </tbody>
                    </table>

                   
            </div>
           
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeDialogView">
                    TUTUP
                </SecondaryButton>
           
            </div>
        </div>
    </Modal>
    <Dialog :show="dialogViewLampiran" @close="closeViewLampiran()" :width="'md'">
        <div v-if="pdfUrl">
        <embed :src="pdfUrl" width="100%" height="600px" type="application/pdf">
        </div>
    
       
    </Dialog>
</template>

<script>

export default {
    props:{
        dataCuti:Object,
        data_rekap : Object,
        sisa_cuti_tahunan : Number
    },

    data() {
        return {
            pdfUrl: null,
            image: image,
            dialogView : false,
            dialogViewLampiran : false,
            objRowSelect : {},
            setting: [ //seting header table
                    {
                            title: 'Jenis Cuti',
                            field: 'jenis_cuti',
                            subfield : [
                                {
                                    field : 'jenis_cuti',
                                    class : ''
                                },
                            ],
                            type: 'object',
                            size: 'auto',
                            align: 'left',
                            class: ''
                    },
                    {
                        title: 'ALASAN CUTI',
                        field: 'alasan_cuti',
                        type: 'string',
                        size: 'auto',
                        align: 'left'
                    },
                    {
                        title: 'Persetujuan Atasan',
                        field: 'stringstat',
                        subfield : [
                            {
                                field : 'nama',
                                class : 'class'
                            },
                        ],
                        type: 'badge',
                        size: 'auto',
                        align: 'left',
                        class: ''
                    },
                    {
                        title: 'Aksi',
                        field: null,
                        type: 'button-group',
                        data: [
                            {
                                text: '',
                                type: 'button',
                                action: 'view',
                                class: 'border rounded-md border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]',
                                icon: 'fas fa-lg fa-file-contract'
                            }
                        
                        ],
                        size: 20,
                        align: 'center'
                    },
                ],
        };
    },
    computed: {
    
    },
    methods: {
        tambahData(){
            router.get(route('admin-ajukan-cuti'), {
            }, {
                replace: true,
                preserveScroll: true,
                preserveState: true  
            })
            
        },
        closeDialogView(){
            this.objRowSelect = {};
            this.dialogView = !this.dialogView;
        },
        closeViewLampiran(){
            window.URL.revokeObjectURL(this.pdfUrl);
            this.pdfUrl = null;
            this.dialogViewLampiran = !this.dialogViewLampiran;
        
        },
        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },
        view(value){

            this.dialogView = !this.dialogView;
            this.objRowSelect = value;
            // console.log(value);
            // console.log('view'+value);

            },

            lihatLampiran(value){
            axios.post(route('admin-view-lampiran-cuti'), 
            {
                nama_file: value.nama_file,
                path_file: value.path
            },
            {
                    responseType: 'blob'
                }).then(response => {

                    if (response.status === 200) {
                            const url = window.URL.createObjectURL(new Blob(
                                [response.data],
                                { type: 'application/pdf' }
                                ));
                            this.pdfUrl = url;
                            this.dialogViewLampiran = true; // Tampilkan dialog

                        
                    } else {
                        // Tangani kasus ketika file tidak ditemukan (misalnya tampilkan pesan error)
                        toast.add({
                            message: "File Tidak ditemukan :", response,
                            category : 'warning'
                        })
                    }
                
            }).catch(error => {
                toast.add({
                    message: "Error loading PDF:", error,
                    category : 'warning'
                })

            });
            },
    },

    
};
</script>

