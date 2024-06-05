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
// import { Select, initTE } from "tw-elements";
// initTE({ Select });
</script>

<template>

    <Head title="Persetujuan Cuti" />

    <AdminLayout>
        <template #textnavbar>
            USER
        </template> 
        <template #header>
            <header-stats>
                <template #kontenheader>
                    <div>
                    <div id="content-to-print" hidden>
                <!-- Your content here -->
                <table class="w-full border-0">
                    <tr>
                        <td class="border-0 w-2/3"></td>
                        <td class="border-0 center text-sm " colspan="2">Padang, {{ moment().format('DD-MM-YYYY') }}</td>
                    </tr>
                    <tr >
                        <td class="border-0"></td>
                        <td class="border-0 text-sm " colspan="2">Kepada</td>
                    </tr>
                    <tr>
                        <td class="border-0"></td>
                        <td class="border-0 text-sm w-4 align-top">Yth. </td>
                        <td class="border-0 text-sm">Kepala Badan Pengelolaan Keuangan dan Aset Daerah Provinsi Sumatera Barat</td>
                    </tr>
                    <tr>
                    <td class="border-0"></td>
                    <td class="border-0 text-sm" colspan="2">di</td>
                    </tr>
                    <tr>
                    <td class="border-0"></td>
                    <td class="border-0 text-xs w-4 align-top"></td>
                    <td class="border-0 text-sm">Tempat</td>
                    </tr>
                </table>

                <table class="w-full border-0">
                    <tr>
                        
                        <td class="border-0 center font-bold">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</td>
                    </tr>
                    
                </table>

                <table class="w-full">
                    <tr class="border border-black">
                    <th class="text-base" colspan="3">I. DATA PEGAWAI</th>
                    </tr>
                    <tr class="text-sm border border-black">
                    <td class="border border-black">Nama</td>
                    <td colspan="2">{{ objRowSelect.pegawai?objRowSelect.pegawai.nama:'-' }}</td>
                    </tr>
                    <tr class="border border-black text-sm">
                    <td class="border border-black">Jabatan</td>
                    <td colspan="2">{{ objRowSelect.pegawai?objRowSelect.pegawai.jabatan_organisasi.nama_jabatan:'-' }}</td>
                    <td colspan="2"></td>
                    </tr>
                    <tr class="text-sm">
                    <td class="border border-black">Unit Kerja</td>
                    <td class="border border-black" colspan="3">Badan Pengelolaan Keuangan dan Aset Daerah Provinsi Sumatera Barat</td>
                    </tr>
                </table>
                
                <table class="w-full mt-4">
                    <tr>
                        <th class="border border-black text-base" colspan="4">II. JENIS CUTI YANG DIAMBIL</th>
                    </tr>
                    <tr class="border border-black text-sm">
                        <td class="border border-black w-1/3">1. Cuti Tahunan</td>
                        <td class="border border-black w-10 text-center">{{ objRowSelect.id_jenis_cuti == 1 ? '&#10003' : '' }}</td>
                        <td class="border border-black w-1/3">2. Cuti Besar</td>
                        <td class="border border-black w-10 text-center"> {{ objRowSelect.id_jenis_cuti == 4 ? '&#10003' : '' }}</td>
                        
                    </tr>
                    <tr class="border border-black text-sm">
                        <td class="border border-black w-1/3">3. Cuti Sakit</td>
                        <td class="border border-black w-10 text-center"> {{ objRowSelect.id_jenis_cuti == 2 ? '&#10003' : '' }}</td>
                        <td class="border border-black w-1/3">4. Cuti Melahirkan</td>
                        <td class="border border-black w-10 text-center"> {{ objRowSelect.id_jenis_cuti == 5 ? '&#10003' : '' }}</td>
                        
                    </tr>
                    <tr class="border border-black text-sm">
                        <td class="border border-black w-1/3">5. Cuti Karena Alasan Penting</td>
                        <td class="border border-black w-10 text-center">{{ objRowSelect.id_jenis_cuti == 3 ? '&#10003' : '' }}</td>
                        <td class="border border-black w-1/3">6. Cuti Diluar Tanggungan Negara</td>
                        <td class="border border-black w-10 text-center"> {{ objRowSelect.id_jenis_cuti == 6 ? '&#10003' : '' }}</td>
                        
                    </tr>
                </table>
                <table class="w-full mt-4">
                    <tr>
                        <th class="border border-black text-base" >III. ALASAN CUTI</th>
                    </tr>
                    <tr class="border border-black text-sm">
                        <td class="h-5" >{{ objRowSelect.alasan_cuti ? objRowSelect.alasan_cuti : ''}}</td>
                    </tr>
                </table>
                <table class="w-full mt-4">
                    <tr>
                        <th class="border border-black text-base" colspan="4">IV. LAMANYA CUTI</th>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black w-1/3">Selama</td>
                        <td class="border border-black w-16 text-center ">{{ objRowSelect.detail_tanggal?objRowSelect.detail_tanggal.length : '' }} hari</td>
                        <td class="border border-black w-20">Tanggal</td>
                        <td class="border border-black">
                            {{ moment(objRowSelect.detail_tanggal?objRowSelect.detail_tanggal[0].tgl:'').format('DD-MM-YYYY') }} s/d 
                            {{ moment(objRowSelect.detail_tanggal ? objRowSelect.detail_tanggal[objRowSelect.detail_tanggal.length - 1].tgl : '').format('DD-MM-YYYY') }} 
                        </td>
                        
                    </tr>
                    
                </table>
                <table class="w-full mt-4">
                <tbody>
                    <tr>
                        <th class="border border-black text-base" colspan="5">V. CATATAN CUTI</th>
                    </tr>
                    <tr class="text-sm">
                        <td colspan="3" class="border border-black w-1/2">1. Cuti Tahunan</td>
                        <td class="border border-black w-1/3">2. Cuti Besar</td>
                        <td class="border border-black"></td>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black">Tahun</td>
                        <td class="border border-black">Sisa</td>
                        <td class="border border-black" >Keterangan</td>
                        <td class="border border-black" >3. Cuti Sakit</td>
                        <td class="border border-black" ></td>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black"></td>
                        <td class="border border-black"></td>
                        <td class="border border-black"></td>
                        <td class="border border-black">4. Cuti Melahirkan</td>
                        <td class="border border-black"></td>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black"></td>
                        <td class="border border-black"></td>
                        <td class="border border-black"></td>
                        <td class="border border-black">5. Cuti Karena Alasan Penting</td>
                        <td class="border border-black"></td>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black"></td>
                        <td class="border border-black"></td>
                        <td class="border border-black"></td>
                        <td class="border border-black">6. Cuti Diluar Tanggungan Negara</td>
                        <td class="border border-black"></td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full mt-4">
                    <tr>
                        <th class="border border-black text-base" colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</th>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black w-2/3">{{ objRowSelect.alamat }}</td>
                        <td class="border border-black w-10">Telp</td>
                        <td class="border border-black">{{ objRowSelect.telp }}</td>
                        
                    </tr>
                    
                </table>
                <table class="w-full mt-4">
                    <tr>
                        <th class="border border-black text-base" colspan="4">PERTIMBANGAN ATASAN LANGSUNG **</th>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black w-1/4">DISETUJUI</td>
                        <td class="border border-black w-1/4">PERUBAHAN ***</td>
                        <td class="border border-black w-1/4">DITANGGUHKAN ***</td>
                        <td class="border border-black w-1/4">TIDAK DISETUJUI</td>
                        
                    </tr>
                    <tr class="text-sm h-5">
                        <td class="border border-black w-1/4 text-center">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[0].status == 1 ? '&#10003' : '')  :'' }}</td>
                        <td class="border border-black w-1/4">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[0].status == 3 ? '&#10003' : '')  :'' }}</td>
                        <td class="border border-black w-1/4">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[0].status == 4 ? '&#10003' : '')  :'' }}</td>
                        <td class="border border-black w-1/4">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[0].status == 2 ? '&#10003' : '')  :'' }}</td>
                        
                    </tr>
                    <tr class="text-sm h-5 ">
                        <td class="border border-black w-1/4" colspan="4">
                            <span class="font-bold">
                            {{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[0].status == 1 ? 'Disetujui' : objRowSelect.detail_persetujuan[0].status == 2 ? 'Ditolak' : '')  :'' }} 
                            </span>
                            Oleh <span class="font-bold">{{ objRowSelect.detail_persetujuan? objRowSelect.detail_persetujuan[0].pegawai.nama  :'' }}</span> pada tanggal  
                            <span class="font-bold"> {{ objRowSelect.detail_persetujuan? moment(objRowSelect.detail_persetujuan[0].updated_at).format('DD-MM-YYYY hh:mm:ss')  :'' }} </span></td>
                        
                    </tr>
                    
                </table>
                <table class="w-full mt-4">
                    <tr>
                        <th class="border border-black text-base" colspan="4">KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **</th>
                    </tr>
                    <tr class="text-sm">
                        <td class="border border-black w-1/4">DISETUJUI</td>
                        <td class="border border-black w-1/4">PERUBAHAN ***</td>
                        <td class="border border-black w-1/4">DITANGGUHKAN ***</td>
                        <td class="border border-black w-1/4">TIDAK DISETUJUI</td>
                        
                    </tr>
                    <tr class="text-sm h-5">
                        <td class="border border-black w-1/4 text-center">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[1].status == 1 ? '&#10003' : '')  :'' }}</td>
                        <td class="border border-black w-1/4">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[1].status == 3 ? '&#10003' : '')  :'' }}</td>
                        <td class="border border-black w-1/4">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[1].status == 4 ? '&#10003' : '')  :'' }}</td>
                        <td class="border border-black w-1/4">{{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[1].status == 2 ? '&#10003' : '')  :'' }}</td>
                    </tr>
                    <tr class="text-sm h-5 ">
                        <td class="border border-black w-1/4" colspan="4">
                            <span class="font-bold">
                                {{ objRowSelect.detail_persetujuan? (objRowSelect.detail_persetujuan[1].status == 1 ? 'Disetujui' : objRowSelect.detail_persetujuan[1].status == 2 ? 'Ditolak' : '')  :'' }} 
                            </span>
                            Oleh <span class="font-bold">{{ objRowSelect.detail_persetujuan? objRowSelect.detail_persetujuan[1].pegawai.nama  :'' }}</span> pada tanggal  
                            <span class="font-bold"> {{ objRowSelect.detail_persetujuan? moment(objRowSelect.detail_persetujuan[1].updated_at).format('DD-MM-YYYY hh:mm:ss')  :'' }} </span></td>
                        
                    </tr>
                </table>
                </div>
            
            </div>

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
                
                
                <card-table   @klik="klikMethod" :list=dataCuti.data :header=setting>
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
    
    <Dialog :show="dialogView" @close="closeDialogView()">
        <div class="flex m-4 md:flex items-center">
        
            <ol class="relative border-s border-gray-200 dark:border-gray-500">                  
                        <li v-for="(timeline, index) in objRowSelect['detail_persetujuan'] " class="ms-6" 
                        :class="(index === objRowSelect['detail_persetujuan'].length - 1) ? '' : 'mb-12'">            
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-500 dark:bg-blue-900">
                                <img class="rounded-full shadow-lg" src="/docs/images/people/profile-picture-3.jpg" @error="$event.target.src = image" alt="Bonnie image"/>
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-blue-800">{{ timeline['pegawai']['nama']}}
                                <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                    {{ timeline['status'] == 0 ? 'Menunggu Persetujuan' :  timeline['status'] == 1 ? 'Disetujui' : timeline['status'] == 2 ? 'Ditolak'  :'Tidak Diketahui'  }}</span></h3>
                            <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                                {{ timeline['pegawai']['nomor_induk_pegawai'] }}</time>
                            
                        </li>
                    </ol>
        </div>
    
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            
            <button v-on:click="closeDialogView()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">TUTUP</button>
        </div>
    </Dialog>
</template>

<script>
import moment from 'moment';
export default {
    props:{
        dataCuti : Object
    },

    data() {
        return {
            search:'',
            dialogView : false,
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
                        title: 'ALAMAT',
                        field: 'alamat',
                        type: 'string',
                        size: 'auto',
                        align: 'left'
                    },
                    {
                        title: 'TELP',
                        field: 'telp',
                        type: 'string',
                        size: 'auto',
                        align: 'left'
                    },
                    {
                        title: 'Status',
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
        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },
        view(value){

            this.dialogView = !this.dialogView;
            this.objRowSelect = value;
            console.log(value);
            console.log('view'+value);

        },
        cetak(value){
            this.objRowSelect = value;
            setTimeout(() => {
                this.generatePDF();
            }, 1000);
        
        },
        generatePDF() {
            //     const printContent = document.getElementById('content-to-print').innerHTML;
            //     const originalContent = document.body.innerHTML;

            //     document.body.innerHTML = printContent;
            //     window.print();
            //     document.body.innerHTML = originalContent;


            // const printContent = document.getElementById('content-to-print').innerHTML;
            // const printWindow = window.open('', '', 'height=500,width=800');

            // printWindow.document.write('<html><head><title>Print</title>');

            // // Menyalin semua elemen <link> dan <style> dari dokumen asli
            // const styles = document.querySelectorAll('link[rel="stylesheet"], style');
            // styles.forEach(style => {
            //     printWindow.document.write(style.outerHTML);
            // });

            // printWindow.document.write('</head><body>');
            // printWindow.document.write(printContent);
            // printWindow.document.write('</body></html>');

            // printWindow.document.close();
            // printWindow.print();

            const printContent = document.getElementById('content-to-print').innerHTML;

            // Membuat elemen iframe
            const iframe = document.createElement('iframe');
            iframe.style.position = 'absolute';
            iframe.style.width = '0px';
            iframe.style.height = '0px';
            iframe.style.border = 'none';

            document.body.appendChild(iframe);

            const doc = iframe.contentWindow.document;

            doc.open();
            doc.write('<html><head><title>Print</title>');

            // Menyalin semua elemen <link> dan <style> dari dokumen asli
            const styles = document.querySelectorAll('link[rel="stylesheet"], style');
            styles.forEach(style => {
                doc.write(style.outerHTML);
            });

            doc.write('</head><body>');
            doc.write(printContent);
            doc.write('</body></html>');
            doc.close();

            iframe.contentWindow.focus();
            iframe.contentWindow.print();

            // Menghapus iframe setelah pencetakan selesai
            document.body.removeChild(iframe);

            }
    },

    
};
</script>
<style>

table, th, td {
  
  border-collapse: collapse;
}
th, td {
  text-align: left;
}
.header-table {
  width: 100%;

}
.content-table {
  width: 100%;
}


</style>