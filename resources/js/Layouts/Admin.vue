<template>
  <div>
    <slot name="notif" />
    <sidebar />
    
    <div class="relative md:ml-64 bg-blueGray-100">

      <admin-navbar #namaheader>
        <slot name="textnavbar" />
        
      </admin-navbar> 
      
      <template v-if="$page.props.notifikasi.length > 0">
        <div class="bg-emerald-600 flex ">


          <div v-if="!route().current('admin-persetujuan-cuti')" v-for="item in $page.props.notifikasi" class="text-white px-6 py-4 m-6 border-0 rounded relative w-full bg-red-400">
            <span class="text-xl inline-block mr-5 align-middle">
              <i class="fas fa-bell"></i>
            </span>
            <span class="inline-block align-middle mr-8">
              <b class="capitalize">{{ item.judul }} -</b> {{ item.deskripsi }} 
              <Link :href="route('admin-persetujuan-cuti')">
                <span class="text-transparent font-bold bg-clip-text bg-gradient-to-tr from-blue-600 to-indigo-500">
                  Klik Disini Untuk Detail
              </span>
                  
              </Link>
            </span>
            <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
              <span>×</span>
            </button>
          </div>
        </div>
        
      </template>
      <slot name="header" />
    
      <div class="px-4 md:px-10 mx-auto w-full -m-32 min-h-full ">
        
        <main>
            <slot />
        </main>
            <footer-admin />
      </div>
      
      
    </div>
  </div>
</template>
<script>
import AdminNavbar from "@/Components/notus/Navbars/AdminNavbar.vue";
import Sidebar from "@/Components/notus/Sidebar/Sidebar.vue";
import FooterAdmin from "@/Components/notus/Footers/FooterAdmin.vue";
import { Link } from '@inertiajs/vue3';
import "../../css/tailwind.css";
import '../../css/app.css';
export default {
  name: "admin-layout",
  components: {
    AdminNavbar,
    Sidebar,
    FooterAdmin,
    Link
  },
};
</script>
