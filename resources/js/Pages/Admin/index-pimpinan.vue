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
            DASHBOARD PIMPINAN
        </template> 
        <template #header>
            <header-stats>
                <template #kontenheader>

                </template>
                
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">
                <card-table @klik="klikMethod" :list=dataCuti.data :header=setting namaTitle='LIST PENGAJUAN CUTI PEGAWAI TERBARU'> 
                    <template #button>
                        
                        
                    </template>
                </card-table>
                
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
                <PrimaryButton v-if="objRowSelect.status === '1' "class="ml-3 bg-red-700 hover:bg-red-500 focus:bg-red-500" v-on:click="tolak" 
                >
                    TOLAK
                
                </PrimaryButton>
                <PrimaryButton v-if="objRowSelect.status === '1' " class="ml-3 bg-green-700 hover:bg-green-500 focus:bg-green-500" v-on:click="setujui" 
                >
                
                    SETUJUI
                
                </PrimaryButton>
               
            </div>
        </div>
    </Modal>
    <Dialog :show="dialogViewLampiran" @close="closeViewLampiran()" :width="'md'">
        <div v-if="pdfUrl">
        <embed :src="pdfUrl" width="100%" height="600px" type="application/pdf">
        </div>
    
       
    </Dialog>
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
        dataCuti: Object,
        header : String,
        message: String,

    },

    data() {
        return {
            pdfUrl: null,
            loadingproses : false,
            statsetujui: false,
            stattolak: false,
            alasantolak: '',
            dialogKonfirmasi : false,
            showModal: false,
            objRowSelect : null,
            dialogViewLampiran : false,
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
                                class: 'border rounded-md border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]',
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
        closeModal(){
        
            this.showModal = !this.showModal;
        },
        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },
        view(value){
            
            this.showModal = !this.showModal;
            this.objRowSelect = value;
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
        closeDialogKonfirmasi(){
            this.dialogKonfirmasi = !this.dialogKonfirmasi;
            this.statsetujui = false;
            this.stattolak = false;
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
            router.post(route('persetujuan-pimpinan'), {
                    id_ajukan_cuti: this.objRowSelect.id,
                    status : 1
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
            router.post(route('persetujuan-pimpinan'), {
                    id_ajukan_cuti: this.objRowSelect.id,
                    status: 0,
                    keterangan : this.alasantolak
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