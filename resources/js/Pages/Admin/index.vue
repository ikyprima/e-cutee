<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import CardTable from "@/Components/notus/Cards/CardTable.vue";
import HeaderStats from "@/Components/notus/Headers/HeaderStats.vue";
import { Head,Link } from '@inertiajs/vue3';
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

    <Head title="Manajemen User" />

    <AdminLayout>
        <template #textnavbar>
            USER
        </template> 
        <template #header>
            <header-stats>
                <template #kontenheader>
                    SELAMAT DATANG <b> {{ $page.props.auth.user.name }}.</b>
                </template>
                
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">
                
                
            </div>

        </div>
    </AdminLayout>
    
</template>

<script>

export default {
    props:{
       
    },

    data() {
        return {
        };
    },
    computed: {
    
    },
    methods: {
    },

    
};
</script>