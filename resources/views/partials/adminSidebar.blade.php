<div style=" width: 250px; height: 100%; margin-top: 70px; " class="position-fixed">
    <button style="  margin-left: 10px; background-color: transparent; border: none;" onclick="toggleSidebar()"><i class="fa-solid fa-greater-than fa-xl"></i></button> 
</div>
<div id="sidebar" style="width: 250px; height: 100%; background-color: #F1F8FF; margin-top: 60px;" class="sidebar position-fixed ">
    <button style="margin-top: 10px; margin-left: 200px; background-color: transparent; border: none;" onclick="toggleSidebar()"><i class="fa-solid fa-less-than fa-xl"></i></button>
    <ul class="list-unstyled">
        <li class="pt-2 active">
            <a href="/adminDashboard" class="text-decoration-none text-dark fw-bold" ><img src="{{ asset('images/admin/home.png') }}" style="width: 30px; height: 30px; margin-left: 10px;" alt="Home"> Home</a>
        </li>
        <li class="pt-1">
            {{-- margin p tag harus di 0 kan spy ga makan tempat. secara default p tag ada margin dan paddingnya --}}
            <p onclick="toggleMaster()" class="sidebarMainMenu ps-3" id="masterMenu" style="margin:0; padding: 5px; font-weight: bold; background-color: #FD9191;">Masters</p>
            <ul id="masterSubMenu" class="list-unstyled" style="display: block">
                <li>
                    <a href="/admin/master/penjual" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/people.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="penjual">  Penjual
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/admin/master/pembeli" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/2-people.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Pembeli"> Pembeli
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/admin/master/tiket" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/ticket.png') }}" style="width: width: 20px; height: 20px; margin-left: 10px;" alt="Tiket"> Tiket
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/admin/master/aktivitas" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">    
                            <img src="{{ asset('images/admin/danger.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Activity"> Aktivitas
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/admin/master/promo" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/discount.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Promo"> Promo
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="">
            <p onclick="toggleLaporan()" id="laporanMenu"  class="sidebarMainMenu ps-3" style="margin:0; padding: 5px; font-weight: bold; background-color: #FD9191;">Laporan</p>
            <ul id="laporanSubMenu" style="display: block" class="list-unstyled">
                <li>
                    <a href="{{ route('seller.report') }}" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/people.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Laporan-Penjual"> Penjual
                        </div>    
                    </a>
                </li>
                <li>
                    <a href="{{ route('buyer.report') }}" class="text-decoration-none text-dark align" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/2-people.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Laporan-Pembeli"> Pembeli
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ticket.report') }}" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/ticket.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Laporan-Tiket"> Tiket
                        </div>    
                    </a>
                </li>
                <li>
                    <a href="{{ route('kunjungan.report') }}" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/time.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Laporan-Kunjungan"> Kunjungan
                        </div>    
                    </a>
                </li>
                <li>
                    <a href="{{ route('transaksi.report') }}" class="text-decoration-none text-dark" style="font-weight: bold;">
                        <div class="sidebarMenu" style="padding-bottom: 5px; padding-top: 5px;">
                            <img src="{{ asset('images/admin/receipt.png') }}" style="width: 20px; height: 20px; margin-left: 10px;" alt="Laporan-Transaksi"> Transaksi
                        </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <script>
        function toggleLaporan() {
            var laporanSubMenu = document.getElementById('laporanSubMenu');
            var laporanMenu = document.getElementById('laporanMenu');
            laporanMenu.style.backgroundColor = (laporanMenu.style.backgroundColor === 'lightblue') ? "#FD9191" : 'lightblue';
            laporanSubMenu.style.display = (laporanSubMenu.style.display === 'none') ? 'block' : 'none';
        }
        function toggleMaster() {
            var masterSubMenu = document.getElementById('masterSubMenu');
            var masterMenu = document.getElementById('masterMenu');
            masterMenu.style.backgroundColor = (masterMenu.style.backgroundColor === 'lightblue') ? '#FD9191' : "lightblue";
            masterSubMenu.style.display = (masterSubMenu.style.display === 'none') ? 'block' : 'none';
        }
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.style.display = (sidebar.style.display === 'none') ? 'block' : 'none';

        }
    </script>
</div>