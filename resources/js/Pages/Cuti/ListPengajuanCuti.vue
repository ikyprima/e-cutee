<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/notus/Buttons/ButtonTambah.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import CardStats from "@/Components/notus/Cards/CardStats.vue";
import { Head,Link,router } from '@inertiajs/vue3';

import DangerButton from '@/Components/DangerButton.vue';
 
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/notus/Dialog.vue';
import image from "@/img/no-image.png";
import toast from '@/Stores/toast.js';
import ToastList from '@/Components/notus/Notifications/ToastList.vue';
</script>

<template>

    <Head title="Rekap Cuti" />

    <AdminLayout>
        <template #textnavbar>
            {{ header ? header : "MANAJEMEN REKAP CUTI" }}
            
        </template> 
        
        <template #header>
            <header-stats>
                <template #kontenheader>

                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <!-- <card-stats statSubtitle="PEGAWAI" statTitle="924" statArrow="down" statPercent="1.10"
                            statPercentColor="text-orange-500" statDescripiron="Since yesterday"
                            statIconName="fas fa-users" statIconColor="bg-pink-500" /> -->
                    </div>

                </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card-table @klik="klikMethod"  @clickedit="clickedit" :list=dataCuti.data :header=setting namaTitle='LIST PENGAJUAN CUTI PEGAWAI'> 
                    <template #button>
                        
                        
                    </template>
                </card-table>
                <footer class="px-2 py-4 border-t border-gray-100 bg ">
                    <nav aria-label="Page navigation example ">
                        <ul class="flex list-style-none ">
                            <li class="page-item" v-for="paging in dataCuti?dataCuti.links:[]" :key="paging.id">
                                <div v-if="paging.active == false && paging.url == null">
                                    <a class="
                                    page-link
                                    relative
                                    block
                                    py-1.5
                                    px-3
                                    border-0
                                    bg-transparent
                                    outline-none
                                    transition-all
                                    duration-300
                                    rounded-full
                                    text-gray-500
                                    pointer-events-none
                                    focus:shadow-none
                                " href="#" tabindex="-1" aria-disabled="false">
                                        <h3 v-html="paging.label"></h3>
                                    </a>
                                </div>
                                <div v-else-if="paging.active == true && paging.url != null">
                                    <Link class="
                                    page-link
                                    relative
                                    block
                                    py-1.5
                                    px-3
                                    border-0
                                    bg-blue-600
                                    outline-none
                                    transition-all
                                    duration-300
                                    rounded-full
                                    text-white
                                    hover:text-white hover:bg-blue-600
                                    shadow-md
                                    focus:shadow-md
                                " :href="paging.url">{{ paging.label }}
                                    <span class="visually-hidden">(current)</span></Link>
                                </div>
                                <div v-else>
                                    <Link class="
                                    page-link
                                    relative
                                    block
                                    py-1.5
                                    px-3
                                    border-0
                                    bg-transparent
                                    outline-none
                                    transition-all
                                    duration-300
                                    rounded-full
                                    text-gray-800
                                    hover:text-gray-800 hover:bg-gray-200
                                    focus:shadow-none
                                " :href="paging.url">
                                    <h3 v-html="paging.label"></h3>
                                    </Link>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </footer>
            </div>

        </div>
    </AdminLayout>
    <Modal :show="showModal" @close="closeModal">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    View Detail
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
            
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
                                    <span v-for="item in objRowSelect.detail_tanggal" class="text-s font-semibold inline-block py-1 px-2 uppercase rounded-full last:mr-0 mr-1 text-blue-200 bg-blue-500">
                                        {{ item.tgl }}
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
                <SecondaryButton @click="closeModal">
                    Tutup
                </SecondaryButton>
               
            </div>
        </div>
    </Modal>

    <Dialog :show="dialogViewLampiran" @close="closeViewLampiran()" :width="'md'">
        <div v-if="pdfUrl">
        <embed :src="pdfUrl" width="100%" height="600px" type="application/pdf">
        </div>
    
       
    </Dialog>
    <Dialog :show="dialogPrint" @close="closeDialogPrint()" >
    
        <div class="p-2">
            <div class="flex items-start justify-between border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    Cetak Dokumen
                </h3>
            </div>
            <div class="relative mt-4 flex-auto">


                
            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-400">
            <li class="pb-3 sm:pb-4" v-for="(item, index) in objRowSelect.dokumen_output" :key="index">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                   
                    <div class="flex-1 min-w-0">
                        <!-- <p class="text-sm font-medium text-gray-900 truncate dark:text-black">
                       
                        </p> -->
                        <p class="font-medium text-gray-500 truncate dark:text-gray-600">
                           {{ item.deskripsi_file }}
                        </p>
                    </div>
                    <div class="inline-flex m-4 items-center text-base font-semibold text-gray-900 dark:text-black">
                       
                <a 
                    class="z-[2] inline-block rounded bg-green-600 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white 
                    shadow-[0_4px_9px_-4px_#3b71ca]
                    transition duration-150 ease-in-out
                    hover:bg-green-800
                    hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
                    focus:z-[3] focus:bg-green-800 
                    focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] 
                    focus:outline-none focus:ring-0 
                    active:bg-green-800 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] 
                    dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] 
                    dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] 
                    dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] 
                    dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]
                    ml-4 
                    "
                    data-te-ripple-init
                    type="button"
                    id="button-addon2"
                
                
                    :href="route('admin-download-dokumen', {
                        path: item.path,
                        nama_file: item.nama_file
                        })" target="_blank">
                    CETAK
                </a>
                    </div>
                </div>
            </li>
            
            </ul>


               
            </div>
            </div>
    
    </Dialog>
   

    
</template>

<script>

export default {
    
    props: {
        dataCuti: Object,
        header :  String

    },
    data() {
        return {
            pdfUrl: null,
            showModal: false,
            objRowSelect : null,
            image: image,
            dialogKonfirmasi : false,
            dialogViewLampiran : false,
            dialogPrint:false,

            setting: [ //seting header table
                {
                    title: 'Nama',
                    field: 'pegawai',
                    subfield : [
                        {
                            field : 'nama',
                            class : 'font-bold'
                        },
                        {
                            field : 'nomor_induk_pegawai',
                            class : 'text-xs'
                        }
                    ],
                    type: 'object',
                    size: 'auto',
                    align: 'left'
                },
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
                    title: 'Alasan Cuti',
                    field: 'alasan_cuti',
                    type: 'string',
                    size: 'auto',
                    align: 'left',
                    class: ''
                },
                {
                    title: 'Alamat Selama Cuti',
                    field: 'alamat',
                    type: 'string',
                    size: '40',
                    align: 'left',
                    class: ''
                },
                {
                    title: 'Telp Selama Cuti',
                    field: 'telp',
                    type: 'string',
                    size: 'auto',
                    align: 'left',
                    class: ''
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
                                class: 'border rounded-l-2xl border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]',
                                icon: 'fas fa-lg fa-file-contract'
                            },
                            {
                                text: '',
                                type: 'button',
                                action: 'editdata',
                                class: 'border border-blue-500 hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-700 focus:bg-green-500 focus:text-white focus:z-[1]',
                                icon: 'fas fa-lg fa-edit'
                            },
                            {
                                text: '',
                                type: 'button',
                                action: 'cetak',
                                class: 'border rounded-r-2xl border-blue-500  hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-700 focus:bg-red-500 focus:text-white  focus:z-[1]',
                                icon: 'fas fa-lg fa-print'
                            },
                        ],
                        size: 20,
                        align: 'center'
                    },
            ],

            
        };
    },
    methods: {
       
        closeModal(){
        
            this.showModal = !this.showModal;
        },
        clickedit(value){
           
            this.showModal = !this.showModal;
        
        },

        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },
        view(value){

            this.showModal = !this.showModal;
            this.objRowSelect = value;
            // console.log(value);
            // console.log('view'+value);

        },
        cetak(value){
            this.dialogPrint = !this.dialogPrint;
            this.objRowSelect = value;
        },
        editdata(value){
            console.log(value);
            router.get(route(''), {
            }, {
                replace: true,
                preserveScroll: true,
                preserveState: true  
            })
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
        closeViewLampiran(){
            window.URL.revokeObjectURL(this.pdfUrl);
            this.pdfUrl = null;
            this.dialogViewLampiran = !this.dialogViewLampiran;
        
        },
        closeDialogPrint(){
            this.dialogPrint = !this.dialogPrint;
        }
        
        
    },

    
};
</script>