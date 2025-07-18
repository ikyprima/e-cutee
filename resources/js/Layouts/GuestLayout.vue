<script setup>
import '../../css/app.css';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
<div class="bg-cover" style="background-image: url('https://masjidraya.sumbarprov.go.id/images/2023/03/slider/gallery-2.jpg');">
    <div class="bg-opacity-75 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-300"
        
    >
        
            <Link href="/">
                <ApplicationLogo class="w-80 h-30 text-gray-500" />
                <h3 class="text-center font-bold">- BPKAD SUMATERA BARAT -</h3>
            </Link>
        

        <div
            class="opacity-80 w-full sm:max-w-md mt-6 px-6 py-4 bg-slate-100 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</div> 
    
</template>
