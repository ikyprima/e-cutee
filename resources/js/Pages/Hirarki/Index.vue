<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/notus/Buttons/ButtonTambah.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import CardStats from "@/Components/notus/Cards/CardStats.vue";
import { Head,Link } from '@inertiajs/vue3';

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

    <Head title="Manajemen Hirark Cuti" />

    <AdminLayout>
        <template #textnavbar>
            Manajemen Hirarki
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

                <card-table @clickedit="clickedit" @clickhapus="clickhapus" :list=hirarki.data :header=setting namaTitle='List Hirarki Penanda Tanagan Cuti (Dalam Pengembangan)'> 
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
                            <li class="page-item" v-for="paging in hirarki?hirarki.links:[]" :key="paging.id">
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
            <div class="relative p-6 flex-auto animatecss animatecss-fadeInLeft">
                <form @submit.prevent>
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2 ">
                            <InputLabel for="namahirarki" value="Nama" class="" />

                            <TextInput id="namahirarki" ref="namahirarkiInput" type="text" class="mt-1 block w-full"
                                placeholder="nama hirarki" v-model="formhirarki.nama_hirarki" />

                            <p v-if="formhirarki.errors.nama_hirarki" class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ formhirarki.errors.nama_hirarki }}
                            </p>
                        </div>


                    </div>
                    <template v-for="(item, index) in formhirarki.detail" :key="index">
                        <Transition :duration="{ enter: 500, leave: 500 }">
                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                                <div class="relative   ">
                                    <InputLabel value="Nama Pegawai" />
                                    <div class="mt-1 block w-full">
                                        <!-- v-model="formhirarki.detail[index]['id_pegawai']" -->
                                        <!-- @deselect="(selectedValue) => hapusdetail(selectedValue, index)" -->
                                        <Multiselect 
                                            v-bind="optionPegawaiSelect"
                                            @select="(val) => pilihpegawai(val, index) "
                                            @clear="() => hapusdetail(index)"
                                           
                                        
                                        />
                                    </div>
                                    <p v-if="$page.props.errors['detail.' + index + '.id_pegawai']"
                                        class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $page.props.errors['detail.' + index + '.id_pegawai'] }}
                                    </p>
                                </div>
                                <div class="relative  ">
                                    <InputLabel value="Urutan" class="" />
                                    <div class="relative w-full ">
                                        <TextInput :id="'urutan-' + index" ref="urutanInput" type="number"
                                            class="mt-1 block w-full" placeholder="urutan" v-model="item.urutan" />
                                        <button v-on="{ click: () => tambahAtauHapus(index) }" class="absolute top-0 right-0 p-2.5 h-full text-sm font-medium text-white
                                                    rounded-r-md
                                                    border 
                                                    focus:ring-4 focus:outline-none "
                                            :class="[index == 0 ? 'bg-blue-700 border-blue-700 hover:bg-blue-800 focus:ring-blue-300' :
                                                'bg-red-700 border-red-700 hover:bg-red-800 focus:ring-red-300']">
                                            <template v-if="index == 0">
                                                <i class="fas fa-lg fa-plus"></i>
                                            </template>
                                            <template v-else>
                                                <i class="fas fa-lg fa-trash-alt"></i>
                                            </template>
                                        </button>

                                    </div>
                                    <p v-if="$page.props.errors['detail.' + index + '.urutan']"
                                        class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $page.props.errors['detail.' + index + '.urutan'] }}
                                    </p>
                                </div>
                            </div>
                        </Transition>

                    </template>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan" 
                :class="{ 'opacity-25': formhirarki.processing }" :disabled="formhirarki.processing">
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
                text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2 " :class="{ 'opacity-25': formhirarki.processing }" :disabled="formhirarki.processing">
                Ya, Hapus</button>
            <button v-on:click="closeDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">Batal</button>
        </div>
        </Dialog>

    
</template>

<script>

export default {
    
    props: {
        hirarki: Object,

    },
    components: {
        Multiselect
    },
    data() {
        return {
            optionPegawaiSelect: {
                closeOnSelect: true,
                placeholder: 'pilih pegawai',
                filterResults: false,
                minChars: 0,
                resolveOnLoad: false,
                infinite: true,
                limit: 10,
                clearOnSearch: true,
                delay: 0,
                searchable: true,
                canClear :  true,
                options: async (query) => {
                    return await this.cariPegawai(query,this.formhirarki.detail)
                }
                
            },
            showModal: false,
            dialogHapus:false,
            editMode: false,
            objhirarki : null,
            formhirarki: this.$inertia.form({
                nama_hirarki: '',
                detail : [
                    {
                        urutan: '',
                        id_pegawai: ''
                    }
                ]
            }),

            setting: [ //seting header table
                {

                    title: 'Nama',
                    field: 'nama_hirarki',
                    type: 'string',
                    size: 44,
                    align: 'left'
                },
                {

                title: 'Nama',
                field: 'nama_hirarki',
                type: 'timeline',
                size: 'auto',
                align: 'left'
                },
                {

                    title: 'Aksi',
                    field: null,
                    type: 'button',
                    size: 20,
                    align: 'center'
                },


            ],

            
        };
    },
    methods: {
        cariPegawai : async(query,arrdata) => {
            const url = route('api.pegawai.index', { searchall: query });
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText} (Status: ${response.status})`);
                }
                const data = await response.json();

                return data.map((item) => {
                    let pegawai = arrdata.find(items => items.id_pegawai == item.id);
                    if(pegawai){
                        return { value: item.id, label: item.nama, disabled: true }
                    }else{
                        return { value: item.id, label: item.nama }
                    }
                })
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        },
        pilihpegawai : function (value, i) {
            
            let pegawai = this.formhirarki.detail.find(item => item.id_pegawai == value);
            if (!pegawai) {
                this.formhirarki.detail[i]['id_pegawai']= value;
            }
        },
        hapusdetail : function(i){
            this.formhirarki.detail[i]['id_pegawai']='';
        },
        tambahData() {
            this.editMode = false;
            this.objhirarki = null;
            this.showModal = !this.showModal;
            this.formhirarki.reset()
            this.formhirarki.clearErrors()
        },

        closeModal(){
            this.editMode = false;
            this.showModal = !this.showModal;
            this.formhirarki.reset();
            this.formhirarki.clearErrors()
        },
    
        tambahAtauHapus: function (value) {
            if (value == 0) {
                const tambahField = {
                    urutan: '',
                    id_pegawai: ''
                };
                
                this.formhirarki.detail.push(tambahField);
            } else {
                this.formhirarki.detail.splice(value, 1);
            }
        },

        simpan() {
            if (this.editMode == true) {
            

            } else {
                this.formhirarki.post(route('hirarkicuti.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.objhirarki = null;
                        this.formhirarki.reset();
                    },
                })
            }

        },
    },

    
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>