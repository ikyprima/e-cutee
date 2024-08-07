<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/notus/Buttons/ButtonTambah.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import CardStats from "@/Components/notus/Cards/CardStats.vue";
import { Head,Link,router } from '@inertiajs/vue3';

import DangerButton from '@/Components/DangerButton.vue';
import Multiselect from '@vueform/multiselect'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/notus/Dialog.vue';

</script>

<template>

    <Head title="Manajemen Pegawai" />

    <AdminLayout>
        <template #textnavbar>
            MANAJEMEN PEGAWAI
        </template> 
        
        <template #header>
            <header-stats>
                <template #kontenheader>

                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <!-- <card-stats statSubtitle="PEGAWAI" statTitle="924" statArrow="down" statPercent="1.10"
                            statPercentColor="text-orange-500" statDescripiron="Since yesterday"
                            statIconName="fas fa-users" statIconColor="bg-pink-500" /> -->
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
                                    placeholder="cari data pegawai" required>

                            </div>

                        </div>

                    </div>
                    </div>

                </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card-table @klik="klikMethod" @clickedit="clickedit" @clickhapus="clickhapus" :list=pegawai.data :header=setting namaTitle='LIST PEGAWAI'> 

                    <template #button>
                        <div class="hidden md:block">
                            <ButtonTambah @click="tambahData">Tambah</ButtonTambah>
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
                            <li class="page-item" v-for="paging in pegawai?pegawai.links:[]" :key="paging.id">
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
    <Modal :show="showModalAddHirarki" @close="closeModalAddHirarki">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    Setting Alur Cuti
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
                <form >
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2">
                            <InputLabel for="permission" value="Pilih Alur" class="" />
                            <Multiselect 
                                valueProp="id" 
                                label="nama_hirarki" 
                                class="mt-1 block w-full" 
                                :options="hirarki"
                                :searchable="true"
                                @select="(value) => pilihHirarki(value)"
                                />
                          
                        </div>
                        
                    </div>
                    <div class="block w-full overflow-x-auto pt-4" v-if="arrPilihHirarki.length > 0">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr class="border">
                                    <th class="border px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-3 text-left w-1/4"> NAMA ATASAN </th>
                                    <th class="border px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-3 text-center w-1/4"> URUTAN </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border" v-for="data in arrPilihHirarki">
                                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-3 text-left w-1/4"> {{data.pegawai.nama}} </td>
                                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm text-center whitespace-nowrap p-3"> {{data.urutan}}   </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalAddHirarki">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpanAddHirarki" 
                :class="{ 'opacity-25': formAddHirarki.processing }" :disabled="formAddHirarki.processing">
                <div v-if="editMode == true">
                    Simpan Perubahan
                </div>
                <div v-else>
                    Simpan
                </div>
                </PrimaryButton>
            </div>
        </div>
    </Modal>
    <Modal :show="showModal" @close="closeModal">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    Tambah
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
                <form >
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2">
                            <InputLabel for="permission" value="Permission" class="" />
                            <TextInput
                                id="permission"
                                ref="permissionInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Permission"
                                v-model="formAddHirarki.permission"
                            />
                            <p v-if="formAddHirarki.errors.permission" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formAddHirarki.errors.permission }}
                            </p>
                        </div>
                        
                    </div>
                    

                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan" 
                :class="{ 'opacity-25': formAddHirarki.processing }" :disabled="formAddHirarki.processing">
                <div v-if="editMode == true">
                    Simpan Perubahan
                </div>
                <div v-else>
                    Simpan
                </div>
                </PrimaryButton>
            </div>
        </div>
    </Modal>
    <Dialog :show="dialogHapus" @close="closeDialogHapus()">
        <div class="md:flex items-center">
        
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold">Hapus Data</p>
                <p class="text-sm text-gray-700 mt-1">Anda Yakin Akan Menghapus Data Yang Dipilih?
                </p>
            </div>
        </div>
    
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button v-on:click="hapus()"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 
                text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2 " :class="{ 'opacity-25': formAddHirarki.processing }" :disabled="formAddHirarki.processing">
                Ya, Hapus</button>
            <button v-on:click="closeDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">Batal</button>
        </div>
        </Dialog>

    
</template>

<script>

export default {
    
    props: {
        pegawai: Object,
        hirarki : Object
    },
    components : {
        Multiselect
    },
    data() {
        return {
            search:'',
            showModal: false,
            showModalAddHirarki : false,
            dialogHapus:false,
            editMode: false,
            objpermission : null,
            arrPilihHirarki :  [],
            formAddHirarki: this.$inertia.form({
                id_hirarki: '',
                id_pegawai: '',
            }),

            setting: [ //seting header table
                {

                    title: 'NIP',
                    field: 'nomor_induk_pegawai',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {
                    title: 'Nama',
                    field: 'nama',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {
                    title: 'Jabatan',
                    field: 'nama_jabatan',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },

                // {

                //     title: 'Aksi',
                //     field: null,
                //     type: 'button',
                //     size: 20,
                //     align: 'center'
                // },
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
                                action: 'addhirarki',
                                class: 'border rounded-l-2xl border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]',
                                icon: 'fas fa-lg fa-file-contract'
                            },
                            {
                                text: '',
                                type: 'button',
                                action: 'clickedit',
                                class: 'border border-blue-500 hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-700 focus:bg-green-500 focus:text-white focus:z-[1]',
                                icon: 'fas fa-lg fa-edit'
                            },
                            {
                                text: '',
                                type: 'button',
                                action: 'clickhapus',
                                class: 'border rounded-r-2xl border-blue-500  hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-700 focus:bg-red-500 focus:text-white  focus:z-[1]',
                                icon: 'fas fa-lg fa-trash'
                            },
                        ],
                        size: 20,
                        align: 'center'
                    },

            ],

            
        };
    },
    methods: {
        tambahData() {
            this.editMode = false;
            this.objpermission = null;
            this.showModal = !this.showModal;
            this.formAddHirarki.reset()
            this.formAddHirarki.clearErrors()
        },
        closeModal(){
            this.editMode = false;
            this.showModal = !this.showModal;
        
        },
        closeModalAddHirarki(){
            this.editMode = false;
            this.showModalAddHirarki = !this.showModalAddHirarki;
            this.formAddHirarki.reset()
            this.formAddHirarki.clearErrors()
            this.arrPilihHirarki = []
        
        },
        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },
        addhirarki(value){
            this.formAddHirarki.id_pegawai = value.id;
            console.log(value);
            this.showModalAddHirarki = !this.showModalAddHirarki;
        },
        clickedit(value){
            this.editMode = true;
            this.objpermission = value;
            this.showModal = !this.showModal;
            this.formAddHirarki.reset()
            this.formAddHirarki.clearErrors()
         
        },
        clickhapus(value){
        
            this.objpermission = value;
            this.dialogHapus = !this.dialogHapus;
        
        },
        closeDialogHapus: function () {
            this.dialogHapus = !this.dialogHapus;
        },
        simpan() {
            if (this.editMode == true) {
               

            } else {
               
            }

        },
        simpanAddHirarki(){
            this.formAddHirarki.post(route('pegawai.add.hirarki'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModalAddHirarki = !this.showModalAddHirarki;
                        this.arrPilihHirarki = [];
                        this.formAddHirarki.reset();
                    },
                })
        },
        cari(){
            router.get(route('pegawai.index'), {
                search: this.search 
            }, {
                replace: true,
                preserveScroll: true,
                preserveState: true  
            })
            
        },
        pilihHirarki(value){
            let hirarki = this.hirarki.find(item => item.id == value)
            this.arrPilihHirarki = hirarki.detail_hirarki;
            this.formAddHirarki.id_hirarki = value;
            
        }
        
    },

    
};
</script>