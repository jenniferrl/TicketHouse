@extends('layouts.main')
@section('content')
    <style>
        /* body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8;
        color: #333;
        } */

        header {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 1em 0;
        }

        section {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        }

        h1, h2 {
        color: #198754;
        }

        h3 {
            color: #3AAD6B;
        }

        p {
        line-height: 1.6;
        font-size: 16px;
        }

        /* ul li dicomment, kalo ngga navbar ancur wkwk */
        /* ul {
        list-style-type: none;
        padding: 0;
        font-size: 20px;
        }

        li {
        margin-bottom: 10px;
        font-size: 20px;
        } */

        #about {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-top: 10px;
        }
    </style>
    <div class="container" style="min-height: 650px; padding-top:100px;">
        <h1>About Us</h1><hr>
        <img id="about" src="{{ asset('images/aboutUs/ecommerce.svg') }}" alt="ilustrasi misi" style="width: 500px; float: right; margin: 30px">
        <br><h3>Selamat Datang di Ticket House!</h3>
        <p>Destinasi terbaik Anda untuk menemukan dan mendapatkan tiket untuk berbagai acara mulai dari seminar, konser, pariwisata, lokakarya, hingga tempat-tempat menarik lainnya. Kami bangga menyajikan platform yang memungkinkan Anda merasakan momen-momen istimewa tanpa ribet.</p><br>

        <h3>Misi Kami</h3>
        <p>Misi kami adalah menyediakan akses mudah dan cepat ke berbagai acara yang Anda inginkan. Dengan kecanggihan teknologi, kami berkomitmen untuk menjadikan proses pembelian tiket lebih sederhana dan menyenangkan bagi Anda.</p><br>

        <h3>Keunggulan Kami</h3>
        <ul>
        <li><strong>Kode Referral yang Menguntungkan:</strong> Di Ticket House, kami mengerti bahwa setiap pelanggan berharga. Oleh karena itu, kami memberikan kesempatan kepada Anda untuk mendapatkan diskon atau poin dengan berbagi kebahagiaan. Gunakan kode referral Anda dan nikmati penawaran istimewa yang menunggu.</li>
        <li><strong>Fitur E-Commerce Dasar yang Lengkap:</strong> Berbelanja di Ticket House tidak hanya tentang memilih acara yang diinginkan, tetapi juga tentang pengalaman berbelanja yang lengkap. Nikmati fitur e-commerce dasar seperti metode pembayaran yang beragam, konfirmasi cepat, dan dukungan pelanggan yang responsif.</li>
        <li><strong>Pemetaan Acara Lokal:</strong> Kami memahami pentingnya mendekati acara-acara yang berlangsung di sekitar Anda. Ticket House dilengkapi dengan fitur pemetaan yang memungkinkan Anda menemukan acara yang sesuai dengan lokasi Anda. Ini memudahkan Anda untuk terlibat dalam pengalaman lokal yang tak terlupakan.</li>
        </ul><br>

        <h3>Bagaimana Ticket House Bekerja</h3>
        <ol>
        <li><strong>Pencarian yang Mudah:</strong> Temukan acara yang sesuai dengan minat dan preferensi Anda dengan mudah melalui fitur pencarian yang canggih.</li>
        <li><strong>Pembelian yang Aman dan Mudah:</strong> Pilih jumlah tiket yang diinginkan, lakukan pembayaran dengan aman melalui metode pembayaran pilihan Anda, dan terima konfirmasi instan.</li>
        <li><strong>Manfaatkan Kode Referral:</strong> Bagikan kegembiraan dengan teman-teman Anda dengan menggunakan kode referral Anda dan nikmati diskon atau poin menarik.</li>
        </ol><br>

        <p>Ticket House adalah rumah bagi semua jenis acara, dari yang paling trendi hingga yang paling tradisional. Bergabunglah dengan komunitas kami dan rasakan pengalaman belanja tiket yang tak terlupakan. Terima kasih telah memilih Ticket House sebagai teman setia Anda dalam menciptakan kenangan berharga.</p>
    </div>
@endsection