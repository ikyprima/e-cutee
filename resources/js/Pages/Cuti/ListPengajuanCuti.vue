<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/notus/Buttons/ButtonTambah.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import CardStats from "@/Components/notus/Cards/CardStats.vue";
import { Head,Link } from '@inertiajs/vue3';

import DangerButton from '@/Components/DangerButton.vue';
 
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/notus/Dialog.vue';

</script>

<template>

    <Head title="Rekap Cuti" />

    <AdminLayout>
        <template #textnavbar>
            MANAJEMEN REKAP CUTI
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

                <card-table @clickedit="clickedit" :list=dataCuti.data :header=setting namaTitle='LIST REKAP CUTI PEGAWAI'> 
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
                                v-model="formpermission.permission"
                            />
                            <p v-if="formpermission.errors.permission" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formpermission.errors.permission }}
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
                :class="{ 'opacity-25': formpermission.processing }" :disabled="formpermission.processing">
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
   

    
</template>

<script>

export default {
    
    props: {
        dataCuti: Object,

    },
    data() {
        return {
            showModal: false,
            objpermission : null,

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
            ],

            
        };
    },
    methods: {
       
        closeModal(){
        
            this.showModal = !this.showModal;
        },
        clickedit(value){
            this.objpermission = value;
            this.showModal = !this.showModal;
        
        },
        
    },

    
};
</script>