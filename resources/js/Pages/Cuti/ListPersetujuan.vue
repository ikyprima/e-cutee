<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import { Head,Link,router } from '@inertiajs/vue3';
import ButtonTambah from '@/Components/notus/Buttons/ButtonTambah.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/notus/Dialog.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import image from "@/img/no-image.png";
// import { Select, initTE } from "tw-elements";
// initTE({ Select });
</script>

<template>

    <Head title="Manajemen User" />

    <AdminLayout>
        <template #textnavbar>
            USER
        </template> 
        <template #header>
            <header-stats>
                <template #kontenheader>
                    <div class="w-full lg:w-full mt-5 ">
                        <div class="grid grid-cols-1 m-4">
                            <div class="text-lg font-bold">
                            </div>
                            <div class=" text-white rounded-md ">
                                <label for="search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only ">Cari</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="search" id="search" 
                                        v-model="search" v-on:keyup.enter="cari"
                                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                                        placeholder="cari data cuti" required>

                                </div>

                            </div>

                        </div>
                    </div>
                </template>
                
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card-table   @klik="klikMethod" :list=dataCuti.data :header=setting namaTitle='LIST PERSETUJUAN CUTI' >
                    <template #button>
                        <div class="hidden md:block">
                           
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
    <Modal :show="showModal" @close="closeShowModal" :maxWidth="'5xl'">
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
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-3">{{objRowSelect.nama}}  </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-3 text-left w-1/4"> NIP </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-3">{{objRowSelect.nip}} </td>
                            </tr>
                            <tr class="border">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left w-1/4"> JABATAN </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">{{objRowSelect.jabatan}} </td>
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
                                    <span v-for="item in objRowSelect.tanggal_cuti" class="text-s font-semibold inline-block py-1 px-2 uppercase rounded-full last:mr-0 mr-1 text-blue-200 bg-blue-500">
                                        {{ item.date }}
                                </span>
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
                                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 ">{{ timeline['nama_pegawai'] }}
                                                <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded  ms-3">
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
                <SecondaryButton @click="closeShowModal">
                    TUTUP
                </SecondaryButton>
                <PrimaryButton v-if="objRowSelect.status_persetujuan === '0' && objRowSelect.status_pengajuan === '0'"class="ml-3 bg-red-700 hover:bg-red-500 focus:bg-red-500" v-on:click="tolak" 
                >
                    TOLAK
                
                </PrimaryButton>
                <PrimaryButton v-if="objRowSelect.status_persetujuan === '0' && objRowSelect.status_pengajuan === '0' " class="ml-3 bg-green-700 hover:bg-green-500 focus:bg-green-500" v-on:click="setujui" 
                >
                
                    SETUJUI
                
                </PrimaryButton>
            </div>
        </div>
    </Modal>
    <Dialog :show="dialogKonfirmasi" @close="closeDialogKonfirmasi()">
        <div class="p-2">
            <div class="flex items-start justify-between border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    Konfirmasi
                </h3>
            </div>
        </div>

        <div class="md:flex items-center">
            <div v-if="statsetujui" class="mt-4 md:mt-0 md:ml-2 text-center md:text-left">
                <p class="text-sm text-gray-700 mt-1">Simpan dan setujui ? </p>
            </div>
        </div>
        <div v-if="stattolak">
            <div class="grid grid-cols-1 md:grid-cols-1 w-full px-2">
                <div class="relative ">
                    <InputLabel value="Alasan Ditolak " class="py-2" />
                        <textarea
                            type="text"
                            class="border-gray-300 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            rows="4"
                            v-model="alasantolak"
                        >
                        </textarea>
                </div>
            </div>
        </div>
    
        <div class="text-center md:text-right mt-4 pr-2 md:flex md:justify-end">
            <div v-if="statsetujui">
                <PrimaryButton class="bg-green-700 hover:bg-green-500 focus:bg-green-500"
                :class="{ 'opacity-25': loadingproses }"
                :disabled="loadingproses"
                v-on:click="konfirmasiSetujui">
                
                    Ya, Setujui
                
                </PrimaryButton>
            </div>
            <div v-if="stattolak">
                <PrimaryButton class="bg-red-700 hover:bg-red-500 focus:bg-red-500"
                :class="{ 'opacity-25': loadingproses }"
                :disabled="loadingproses"
                v-on:click="konfirmasiTolak">
                
                    Ya, Tolak
                
                </PrimaryButton>
            </div>
        </div>
    </Dialog>
</template>

<script>

export default {
    props:{
        dataCuti : Object
    },

    data() {
        return {
            loadingproses : false,
            dialogKonfirmasi : false,
            statsetujui: false,
            stattolak:false,
            alasantolak: '',
            image: image,
            search:'',
            showModal : false,
            objRowSelect : {},
            setting: [ //seting header table
                {
                    title: 'Nama',
                    field: 'nama',
                    type: 'string',
                    size: 'auto',
                    align: 'left',
                    class: ''
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
                    size: 'auto',
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
                        title: 'Status Pengajuan',
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
                                class: 'border rounded-xl border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]',
                                icon: 'fas fa-lg fa-file-contract'
                            },
                        
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
        closeShowModal(){
            this.objRowSelect = {};
            this.showModal = !this.showModal;
        },
        closeDialogKonfirmasi(){
            this.dialogKonfirmasi = !this.dialogKonfirmasi;
            this.statsetujui = false;
            this.stattolak = false;
        },
        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },
        view(value){
            this.showModal = !this.showModal;
            this.objRowSelect = value;
        },
        setujui(){
            // this.closeShowModal
            this.statsetujui = !this.statsetujui;
            this.dialogKonfirmasi = !this.dialogKonfirmasi;
        },
        tolak(){

            this.stattolak = !this.stattolak;
            this.dialogKonfirmasi = !this.dialogKonfirmasi;

        },
        konfirmasiSetujui(){
            this.loadingproses = true;
            router.post(route('admin-persetujuan-cuti-simpan'), {
                    id: this.objRowSelect.id,
                    id_ajukan_cuti: this.objRowSelect.id_ajukan_cuti,
                    id_detail_hirarki: this.objRowSelect.id_detail_hirarki,
                    status: 1
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.loadingproses = false;
                        this.dialogKonfirmasi = !this.dialogKonfirmasi;
                        this.statsetujui = false;
                        this.stattolak = false;

                        this.objRowSelect = {};
                        this.showModal = !this.showModal;
                    },
                    onFinish: visit => {
                        this.loadingproses = false;
                    },
                }
            )

        },
        konfirmasiTolak(){
            this.loadingproses = true;
            router.post(route('admin-persetujuan-cuti-simpan'), {
                    id: this.objRowSelect.id,
                    id_ajukan_cuti: this.objRowSelect.id_ajukan_cuti,
                    id_detail_hirarki: this.objRowSelect.id_detail_hirarki,
                    status: 2,
                    alasan_tolak : this.alasantolak
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.loadingproses = false;
                        this.dialogKonfirmasi = !this.dialogKonfirmasi;
                        this.statsetujui = false;
                        this.stattolak = false;

                        this.objRowSelect = {};
                        this.showModal = !this.showModal;
                    
                    },
                    onFinish: visit => {
                        this.loadingproses = false;
                    },
                }
            )
        },

    },

    
};
</script>