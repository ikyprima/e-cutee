<template>
  <div>
    <slot name="notif" />
    <sidebar />
    
    <div class="relative md:ml-64 bg-blueGray-100">

      <admin-navbar #namaheader>
        <slot name="textnavbar" />
        
      </admin-navbar> 
      

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
import "../../css/tailwind.css";
import '../../css/app.css';
export default {
  name: "admin-layout",
  components: {
    AdminNavbar,
    Sidebar,
    FooterAdmin,
  },
};
</script>
