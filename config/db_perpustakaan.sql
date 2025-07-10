-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jul 2025 pada 11.11
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publication_year` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `publication_year`, `isbn`, `publisher`, `category`, `description`) VALUES
(1, 'Data Science Menggunakan Bahasa R : Deep Learning', 'Dr. Adi Nugroho, S.T., M.M.S.I.', 2025, '9786230142888', 'Penerbit Andi', 'Komputer', '-'),
(2, 'Analisis dan Visualisasi Data dengan Power Bi dan Tableau', 'Jubilee Enterprise', 2024, '9786230056673', 'Elex Media Komputindo', 'Komputer', 'Buku ini mengupas bagaimana mempersiapkan data source, melakukan transformasi, menganalisis, dan memvisualisasikan data-data menggunakan teknik yang sederhana tetapi sangat mendasar. Tujuannya, agar Anda bisa menjadi analis data yang handal dan dapat membuat story yang efisien dan efektif.\r\n\r\nAnda bisa langsung mempraktikkan pembelajaran di dalam buku ini karena:\r\n\r\nAplikasi Power BI dan Tableau dapat digunakan secara gratis.\r\n\r\nDataset tersedia lengkap.\r\n\r\nAkhir kata, tingkatkan daya tawar Anda di industri mana pun terutama di lingkungan perusahaan besar yang sangat mengandalkan data untuk setiap pengambilan keputusan bisnis.'),
(3, 'Seporsi Mie Ayam Sebelum Mati', 'Brian Khrisna', 2025, '9786020531328', 'Gramedia Widiasarana Indonesia', 'Fiksi', 'Ale, seorang pria berusia 37 tahun memiliki tinggi badan 189 cm dan berat 138 kg. Badannya bongsor, berkulit hitam, dan memiliki masalah dengan bau badan. Sejak kecil, Ale hidup di lingkungan keluarga yang tidak mendukungnya. Ia tak memiliki teman dekat dan menjadi korban perundungan di sekolahnya.\r\nAle didiagnosis psikiaternya mengalami depresi akut. Bukannya Ale tidak peduli untuk memperbaiki dirinya sendiri, ia peduli. Ale telah berusaha mengatasi masalah-masalah yang timbul dari dirinya agar ia diterima di lingkungan pertemanan. Namun usahanya tidak pernah berhasil. Bahkan keluarganya pun tidak mendukungnya saat Ale membutuhkan sandaran dan dukungan.\r\n\r\nAtas itu semua, Ale memutuskan untuk mati. Ia mempersiapkan kematiannya dengan baik. Agar ketika mati pun, Ale tidak banyak merepotkan orang. Dua puluh empat jam dari sekarang, ia akan menelan obat antidepresan yang dia punya sekaligus. Sebelum waktu itu tiba, Ale membersihkan apartemennya yang berantakan, makan makanan mahal yang tak pernah ia beli, pergi berkaraoke dan menyanyi sepuasnya hingga mabuk.\r\n\r\nSaat 24 jam itu tiba, Ale telah bersiap dengan kemeja hitam dan celana hitam, bak baju melayat ke pemakamannya sendiri. Ia kenakan topi kecurut ulang tahun dan meletuskan konfeti yang ia beli untuk dirinya sendiri.\r\n“Selamat ulang tahun yang terakhir, Ale.”\r\n\r\nAle siap menenggak seluruh obat antidepresan yang ia punya. Saat ia memain-mainkan botolnya, Ale terdiam saat membaca anjuran di kemasan botol itu, dikonsumsi sesudah makan. Seketika perutnya berbunyi. Dan Ale pun memutuskan untuk makan dulu sebelum mengakhiri hidupnya. Setidaknya, itu akan menjadi satu-satunya keputusan yang bisa dia ambil atas kehendaknya sendiri. Setelah selama hidupnya ia tak pernah mampu melakukan hal-hal yang ia inginkan.\r\n\r\nAle akan makan seporsi mie ayam sebelum mati.'),
(4, 'The Psychology of Money Edisi Revisi', 'Jason Sweig', 2024, '9786238371044', 'Baca', 'Pengembangan Diri', 'Kesuksesan dalam mengelola uang tidak selalu tentang apa yang Anda ketahui. Ini tentang bagaimana Anda berperilaku. Dan perilaku sulit untuk diajarkan, bahkan kepada orang yang sangat pintar sekalipun. Seorang genius yang kehilangan kendali atas emosinya bisa mengalami bencana keuangan. Sebaliknya, orang biasa tanpa pendidikan finansial bisa kaya jika mereka punya sejumlah keahlian terkait perilaku yang tak berhubungan dengan ukuran kecerdasan formal.\r\n\r\nUang―investasi, keuangan pribadi, dan keputusan bisnis―biasanya diajarkan sebagai bidang berbasis matematika, dengan data dan rumus memberi tahu kita apa yang harus dilakukan. Namun di dunia nyata, orang tidak membuat keputusan finansial di spreadsheet. Mereka membuatnya di meja makan, atau di ruang rapat, di mana sejarah pribadi, pandangan unik Anda tentang dunia, ego, kebanggaan, pemasaran, dan berbagai insentif bercampur.\r\n\r\nDalam The Psychology of Money, penulis pemenang penghargaan, Morgan Housel membagikan 19 cerita pendek yang mengeksplorasi cara-cara aneh orang berpikir tentang uang dan mengajari Anda cara memahami salah satu topik terpenting dalam hidup dengan lebih baik.\r\n\r\nThe Psychology of Money penuh dengan ide-ide menarik dan kesimpulan praktis. Bacaan penting bagi siapa saja yang ingin mengelola uang dengan lebih baik. Semua orang wajib memiliki buku ini.”\r\n—James Clear, penulis buku laris Atomic Habits\r\n\r\n“Hanya sedikit orang yang menulis tentang keuangan dengan kejernihan menawan seperti Morgan Housel. The Psychology of Money adalah bacaan penting bagi siapa saja yang ingin membuat keputusan yang lebih bijak atau menjalani kehidupan yang lebih kaya.”\r\n—Daniel H. Pink, penulis buku terlaris versi New York Times untuk When, To Sell Is Human, dan Drive'),
(5, 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa', 'James Clear', 2019, '9786020633176', 'Gramedia Pustaka Utama', 'Pengembangan Diri', 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa adalah buku kategori self improvement karya James Clear. Pada umumnya, perubahan-perubahan kecil seringkali terkesan tak bermakna karena tidak langsung membawa perubahan nyata pada hidup suatu manusia. Jika diumpamakan sekeping koin tidak bisa menjadikan kaya, suatu perubahan positif seperti meditasi selama satu menit atau membaca buku satu halaman setiap hari mustahil menghasilkan perbedaan yang bisa terdeteksi. Namun hal tersebut tidak sejalan dengan pemikiran James Clear, ia merupakan seorang pakar dunia yang terkenal dengan \'habits\' atau kebiasaan. Ia tahu bahwa tiap perbaikan kecil bagaikan menambahkan pasir ke sisi positif timbangan dan akan menghasilkan perubahan nyata yang berasal dari efek gabungan ratusan bahkan ribuan keputusan kecil. Ia menamakan perubahan kecil yang membawa pengaruh yang luar biasa dengan nama atomic habits.\r\n\r\nDalam buku ini James Clear, seorang penulis sekaligus pembicara yang sangat terkenal akan topik \'habit\' memaparkan bahwa pada hakikatnya sebuah perubahan kecil (Atomic Habit) sering dianggap remeh, sebenarnya akan memberikan hasil yang sangat menjanjikan dalam hidup. Yang dipandang penting dalam perubahan perilaku bukan satu persen perbaikan tunggal, melainkan ribuan perbaikan atau sekumpulan atomic habits yang saling bertumpuk dan menjadi unit dasar dalam suatu sistem yang penting.\r\n\r\nJames Clear menjelaskan bahwa terdapat tiga tingkat perubahan yaitu perubahan hasil, perubahan proses, dan perubahan identitas. Cara paling efektif dalam mengubah kebiasaan adalah bukan berfokus pada apa yang ingin dicapai, melainkan tipe orang seperti apa yang diinginkan. Identitas seseorang muncul dari kebiasaan yang dilakukan setiap harinya. Alasan utama kebiasaan penting karena kebiasaan dapat mengubah keyakinan tentang diri sendiri.\r\n\r\nClear juga memperkenalkan empat Kaidah Perubahan Perilaku untuk membantu mengubah perilaku manusia yaitu menjadikannya terlihat, menjadikannya menarik, menjadikannya mudah, menjadikannya memuaskan. Keempat kaidah ini tidak hanya mengajari kita cara menciptakan kebiasaan-kebiasaan baru, melainkan menyingkapi sejumlah wawasan menarik tentang perilaku manusia.'),
(6, 'Think Like A Monk, Berpikir Seperti Rahib: Cara Melatih Pikiran Untuk Meraih Kedamaian Hidup', 'Jay Shetty', 2023, '9786020663906', 'Gramedia Pustaka Utama', 'Pengembangan Diri', 'Belum pernah begitu banyak orang merasa tidak puas seperti saat ini—atau begitu sibuk mengejar “kebahagiaan.” Budaya dan media menjejali kita dengan gambaran serta konsep tentang siapa diri kita dan harus menjadi apa kita, sembari memberi teladan pencapaian dan kesuksesan. Ketenaran, uang, dan keglamoran: Pada akhirnya, tidak ada satu pun dari semua itu yang dapat memuaskan kita. Berpikir seperti rahib menawarkan alternatif bagi cara pandang dan pendekatan kita terhadap kehidupan. Cara yang sarat dengan pelepasan kelekatan, penemuan kembali, fokus, disiplin—dan pelayanan. Tujuan pola pikir rahib adalah kehidupan yang bebas dari ego, rasa iri, nafsu, kecemasan, kemarahan, kegetiran, dan beban. Mengadopsi pola pikir rahib bukan hanya memungkinkan—tetapi diperlukan. Kita tidak punya pilihan lain. Kita perlu menemukan ketenangan, keheningan, dan kedamaian. Selling Point: Ditulis oleh Jay Shetty, penulis terlaris #1 New York Times, pencerita pemenang penghargaan, pembawa acara podcast, dan mantan rahib yang berdedikasi untuk memviralkan kebijaksanaan. Pada 2019, dia menjadi bintang sampul Adweek’s Young Influentials dan digambarkan sebagai “sang pemancar kekuatan spiritual”. Majalah Forbes menobatkannya dalam daftar 30 Under 30 pada 2017 atas inovasinya dalam dunia media. Video viralnya telah ditonton sebanyak lebih dari 10 miliar kali dan dia memiliki total lebih dari 50 juta pengikut di seluruh media sosialnya. Jay membuat On Purpose pada 2019, yang kini menjadi podcast kesehatan dan kebugaran nomor #1 di dunia.'),
(7, 'Rahasia Lembah Sunyi', 'Dewi Lestari', 2024, '9786020650337', 'GPU', 'Misteri', 'Seorang detektif memecahkan kasus pembunuhan di desa terpencil.'),
(8, 'Laiqa: Hijab for Sisters: Dia Ibu yang Harus Dihormati, Fayla!', 'NURILLAH ACHMAD', 2024, '9786230055935', 'Elex Media Komputindo', 'Fiksi', 'Sebagai remaja yang hendak mempelajari ilmu agama, hidup Fayla sudah ideal; tinggal di pesantren dan belajar di sekolah yang diimpikan, punya banyak teman yang baik dan loyal, serta orangtua yang menyayanginya tanpa kurang. Hingga suatu hari videonya saat berdebat keras dengan seorang ustazah, diviralkan orangtua santri yang berkunjung. Membuatnya dipandang sebagai santri bermasalah sekaligus anak kurang ajar.\r\n\r\nHinaan dan cercaan yang diterima tidak sebanding dengan satu fakta yang dibawa salah seorang kerabat, membuat hidup ideal Fayla seketika itu berantakan. Bahkan dia membenci ibunya yang selama ini menyembunyikan kenyataan mengenai asal-usulnya. Lantas, apa lagi yang perlu dipertahankan dalam hidup Fayla setelah semua berbalik dari harapan idealnya?\r\n\r\nProfil Penulis:\r\nSeusai menyantri di TMI Putri Al-Amien Prenduan Sumenep, dia melanjutkan pendidikan di Fakultas Hukum Universitas Jember. Pada tahun 2019, terpilih sebagai Emerging Writer of Ubud Writers & Readers Festival. Novelnya yang berjudul Berapa Jarak antara Luka dan Rumahmu? (Elex Media, 2023) meraih juara 2 sayembara novel Islami yang diadakan oleh Gramedia Writing Project (GWP) x Elex Media Komputindo. Selain itu, dia juga menerbitkan novel Lahbako (Elex Media, 2021) dan kumpulan cerpen Cara Bodoh Menertawakan Tuhan (Buku Inti, 2020). Pada tahun 2022 terpilih sebagai penulis biografi ulama Kongres Ulama Perempuan Indonesia (KUPI). Sementara pada tahun 2023 terpilih sebagai peserta residensi cerpenis di Gresik yang diadakan oleh Yayasan Gang Sebelah, bekerja sama dengan Kemdikbudristek. Saat ini tinggal di Jember. Penulis terbuka dengan diskusi, saran atau kritik lewat akun Instagram @nurillah.achmad, FB: Nurillah Achmad atau email: nurillah.achmad71@gmail.com'),
(9, 'Dilema Usaha Manusia Rasional: Teori Kritis Sekolah Frankfurt (2025)', 'Sindhunata', 2025, '9786020630113', 'Gramedia Pustaka Utama', 'Filsafat', 'Buku Teori Kritis Sekolah Frankfurt memperkenalkan pemikiran filsuf Max Horkheimer dan Theodor W. Adorno dalam dua pokok pemikiran. Pertama, konsep tentang teori kritis. Kedua, kritik terhadap usaha manusia rasional yang terlihat macet dan gagal. Pada edisi baru ini, Sindhunata menambahkan tulisan tentang teori Sekolah Frankfurt yang digunakan untuk menyoroti beberapa gejala sosial di masa sekarang. Rasionalitas yang berbalik menjadi irasionalitas, dan pencerahan yang terjungkir menjadi mitos yang banyak kita temukan dalam realitas. Penulis memaparkan bagaimana berdasarkan teori kritis Horkheimer dan Adorno, kita dapat melihat dan mengkritisi gejala post-modernisme & post-truth, populisme, politik identitas, dan radikalisasi agama, yang merebak muncul akhir-akhir ini.\r\n\r\nBuku yang terus dipergunakan sebagai pegangan untuk bidang pengajaran filsafat dan ilmu sosial ini memberi sumbangan pemikiran kritis bagi kalangan akademis dan intelektual. Dengan mempelajari teori kritis, kita akan terus digugat, agar tidak malas untuk berpikir, agar mau terus mengasah akal budi, untuk meraih dunia yang lebih baik daripada dunia sekarang ini.\r\n\r\n\r\nBuku Sindhunata ini begitu memperkaya khazanah kepustakaan filsafat berbahasa Indonesia. Teori kritis dengan tokohnya Max Horkheimer bukan sembarang filsafat. Teori itu yang paling mendalam menganalisa sistem masyarakat industri maju yang bayangannya terasa sampai ke Indonesia. Kekayaan, kedalaman, dan problematika salah satu aliran filsafat modern yang paling berpengaruh diutarakan secara tepat dan mendalam. Buku ini membuka kesempatan kita untuk berkenalan dengan suatu cara berpikir yang memberi cap kepada iklim intelektual di Barat. Prof. Dr. Franz Magnis Suseno'),
(10, 'Beyond The Noise', 'Sanaha Purba', 2025, ' 9786238398720', 'Terang Sejati', 'Filsafat', 'Derasnya arus informasi yang menerpa kita di era digital ini seolah-olah membuat kita terjebak dalam kebisingan dunia. Dalam situasi itu, kita memerlukan suatu keterampilan berpikir kritis. Namun, untuk sanggup berpikir kritis, kita butuh logika. Apa itu ‘Logika’? Seperti yang pernah diungkapkan oleh Aristoteles, “Logika adalah seni berpikir dengan benar.” Pertanyaannya, sudahkah cara kita berpikir selama ini benar?\r\n\r\nBuku ini hadir untuk membantu Anda mengasah keterampilan berpikir kritis dengan menggunakan logika. Pada dasarnya, logika memberikan kita alat untuk memahami dan menganalisis informasi, argumen, pemikiran, penilaian, dan pandangan-pandangan yang memapar benak kita setiap harinya. Oleh karena itu, logika akan membantu kita untuk menilai sejauh mana informasi yang kita terima adalah sebuah kebenaran.\r\n\r\nDalam buku ini, Anda akan belajar tentang berbagai konsep dasar logika, termasuk jenis-jenis logika. Tidak hanya itu, buku ini akan menunjukkan kepada Anda bagaimana cara ideal untuk membangun dan mengevaluasi argumen. Kami mengajak Anda untuk menjadikan buku ini sebagai peta perjalanan untuk menajamkan dan mengasah logika Anda. Dengan memahami logika dan mengasah keterampilan berpikir kritis, Anda akan lebih siap menghadapi tantangan dunia modern.\r\n\r\nApa yang akan Anda baca dalam buku ini bukan hanya tentang teori, tetapi juga panduan untuk membantu Anda mengambil keputusan dengan lebih baik, berinteraksi dengan orang lain dengan lebih efektif, dan menciptakan kehidupan yang jauh lebih berkualitas. Seperti yang pernah diungkapkan oleh Socrates, “Kehidupan yang tidak dipertanyakan tidak layak untuk dijalani.” Mari kita mulai perjalanan ini bersama-sama untuk menemukan bagaimana logika dapat membantu Anda melampaui kebisingan dunia hari ini demi mencapai kehidupan yang lebih jelas dan bermakna.\r\n\r\nSelamat membaca dan mengasah pikiran Anda!'),
(11, 'Seni Berpikir Kritis', 'Ibnu Sina', 2025, '9786238661107', 'Turos Pustaka', 'Filsafat', 'Seni Berpikir Kritis: Menakar Kebenaran Sejak dalam Pikiran\r\n\r\nKehidupan digital banyak memengaruhi performa otak manusia. Tidak heran jika hari-hari ini banyak yang mengalami penurunan kemampuan untuk menalar dan berpikir secara kritis. Salah satu kiat untuk mengembalikan skill penting satu ini adalah dengan mempelajari ilmu logika.\r\n\r\nBuku ini tak hanya menjelaskan prinsip-prinsip dasar berpikir, tetapi juga memperbarui cara kita memahami dunia. Dengan gayanya yang khas, Ibnu Sina mengupas bagaimana logika dapat menjadi senjata untuk meruntuhkan ilusi, membongkar syak wasangka, dan menemukan esensi kebenaran.\r\n\r\nSetiap pembahasan dalam buku ini merupakan ajakan untuk melampaui cara berpikir konvensional dan memasuki dimensi yang lebih luas. Jadi, sudah siapkah untuk berpikir lebih kritis?\r\n\r\n\r\nTahun Terbit : Cetakan Pertama, Januari 2025\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.'),
(12, 'Life 3.0 : Menjadi Manusia Pada Era Kecerdasan Buatan', 'Max Tegmark', 2013, '9786230025891', 'Elex Media Komputindo', 'Pengembangan Diri', 'Tegmark, profesor di MIT yang bekerjasama dengan Elon Musk dan banyak melahirkan ide-ide di bidang kosmologi dan kecerdasan buatan, menyatakan kembali pentingnya redefinisi \"MANUSIA\" dalam dunia yang semakin \"dikendalikan\" atau setidaknya memanfaatkan teknologi AI (Artificial Intelligence, atau kecerdasan buatan). Di satu sisi, kecerdasan buatan terbukti sangat membantu memudahkan kehidupan manusia di nyaris segala bidang. Namun, di sisi lain, AI juga membawa dampak cukup serius dalam kehidupan umat manusia, bahkan berpotensi mengancam keamanan manusia itu sendiri. \"Menjadi manusia pada era AI\" adalah penekanan utama Tegmark dalam bukunya, agar kita semua tidak akan pernah kehilangan jati diri kita, atau bahkan kehilangan kendali kita atas teknologi yang seharusnya justru membawa kemudahan dalam kehidupan kita.\r\n\r\nSelling Point:\r\nSebuah pemikiran filosofis praktis mengenai potensi AI sebagai pisau dua sisi dalam kehidupan manusia modern, yang digagas oleh Max Tegmark, guru besar MIT serta mitra industrialis Elon Musk.\r\n\r\nProfil Penulis:\r\nMax Tegmark adalah seorang profesor fisika di MIT dan presiden dari Future of Life Institute. Ia adalah penulis Our Mathematical Universe, dan ia telah tampil di lusinan dokumenter ilmiah. Hasratnya untuk gagasan, petualangan, dan masa depan menginspirasi sangat menular.'),
(13, 'Filosofi Teras (New Cover)', 'Henry Manampiring', 2023, '9786233469319', 'Penerbit Buku Kompas', 'Filsafat', 'Lebih dari 2000 tahun lalu, sebuah mazhab filsafat menemukan akar masalah dan juga solusi dari banyak emosi negatif. Stoisisme, atau Filosofi Teras, adalah filsafat Yunani-Romawi kuno yang bisa membantu kita mengatasi emosi negatif dan menghasilkan mental yang tangguh dalam menghadapi naik-turun nya kehidupan.\r\n\r\nJauh dari kesan filsafat sebagai topik berat dan mengawang-awang, Filosofi Teras justru bersifat praktis dan relevan dengan kehidupan Generasi Milenial dan Gen-Z masa kini.\r\n\r\nBuku yang pertama kali diterbitkan pada 2019 ini mengajarkan kita tentang pengendalian emosi negatif yang ada dalam diri kita. Buku Filosofi Teras menjadi buku mega best seller, dan memenangkan Book of the Year di Indonesia International Book Fair pada 2019. Filosofi Teras memiliki tebal sebanyak 344 halaman.\r\n\r\nBuku ini mudah dipahami dengan ilustrasi tokoh filsafat, serta kata-kata bijak yang menambah daya tarik dalam membaca. Buku karangan Henry Manampiring ini sangat cocok dibaca untuk para generasi milenial, dan Gen Z dalam menghadapi ketakutan, kekhawatiran, kecemasan, serta hal negatif lainnya.\r\n\r\nAwal mula kehadiran buku ini tidak lain dari latar belakang kondisi sang penulis yang didiagnosis major depressive disorder. Hingga akhirnya ia menemukan buku tentang penerapan filsafat stoa dalam hidup.\r\nStoa sendiri identik dengan kesederhanaan, dan menerima keadaan yang tidak bisa dikendalikan. Namun, stoicism bukan berarti pasrah dan tidak peduli sama sekali. Filsafat ini mengajarkan kita untuk memiliki prinsip indifferent.'),
(14, 'Buat Kamu yang Lelah Bersih-Bersih', 'Sayo Konishi', 2025, '9786024413774', 'Mizan', 'Pengembangan Diri', 'Rumah rapi itu nggak harus capek-capek banget, kok!\r\n\r\nSetiap kali lihat rumah berantakan, kamu mengeluh, “Nanti aja deh.” Tapi, makin ditunda makin stres, dan akhirnya … kamu tetap nggak tahu harus mulai dari mana. Ingat ya, berbenah bukan soal gaya, tapi soal kenyamanan. Berbenah itu bukan kerja rodi, tapi soal strategi.\r\n\r\nBerbenah itu realistis saja—nggak perlu jadi perfeksionis atau punya waktu luang seharian. Sayo Konishi, konsultan berbenah dari Jepang dengan pengalaman lebih dari dua dekade, bakal nemenin kamu untuk bikin rumah jadi lebih nyaman dan hidup lebih tertata. Kamu akan belajar cara memilah, menyimpan barang, dan menata rumah sesuai kebutuhan kamu—bukan standar orang lain. Cocok buat kamu yang ingin hidup praktis, rapi, tapi tetap chill.\r\n\r\nDilengkapi dengan contoh-contoh praktis dalam bab-bab pendek dan mudah dipahami, kamu akan belajar:\r\n- Metode 5 langkah simpel dalam berbenah yang bisa kamu jadikan rutinitas.\r\n- Membantu kamu membentuk kebiasaan rapi tanpa tekanan.\r\n- Tip berbenah yang bisa dipraktikkan di mana saja, mudah dan efektif.\r\n\r\nKarena hidup praktis dan rapi itu bukan mitos—asal tahu rumusnya.\r\n\r\nTahun Terbit : Cetakan Pertama, 2025\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(15, 'Sialnya, Kita Bukan Anak Kecil Lagi', 'IZZASAPTA', 2025, '9789797948344', 'Media Kita', 'Pengembangan Diri', '“Sialnya, kita bukan anak kecil lagi.”\r\n\r\nTak ada lagi hari yang terasa singkat karena sibuk bermain di luar rumah.\r\nWaktu sekarang berjalan lambat,\r\nterisi getir keluh kesah yang tak berani disampaikan kepada siapa pun .\r\n\r\nTak ada lagi jemputan Bapak, yang lengkap dengan pelukan nyaman.\r\nKini, segala arah mesti ditempuh sendirian.\r\n\r\nTak ada lagi masakan Ibu yang disajikan penuh cinta di atas meja.\r\nSekarang, makan bak upacara melepas rindu berlauk air mata.\r\n\r\nTernyata, menjadi dewasa tidak semenyenangkan yang dulu kita bayangkan.\r\nTapi, meski tidak bisa kembali ke masa kecil itu lagi,\r\nternyata kita sudah melangkah sejauh ini, dan menyadari satu hal:\r\nmeski jadi dewasa tidak pernah mudah,\r\nkita akan selalu bisa bertahan\r\n\r\n*****\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.\r\n\r\nLibatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(16, 'Understanding Your Inner Child', 'Aba Mehmed Agha', 2025, '9786238114818', 'Checklist', 'Pengembangan Diri', 'Apakah Anda sering merasa kesepian? Atau mungkin rendah diri, tidak mampu menetapkan batasan dengan orang lain, sampai punya masalah kepercayaan kepada orang lain?\r\n\r\nMemang banyak faktor penyebabnya, tetapi mungkin salah satunya adalah inner child Anda belum sembuh. Ya, inner child atau anak batin itu ada, bersemayam dalam jiwa Anda, membentuk karakter dan kepribadian Anda yang sekarang. Ia bisa jadi anak kecil yang bahagia, bisa pula anak yang murung dan punya banyak masalah. Pertanyaannya, sudahkah Anda mengenal inner child Anda?\r\n\r\nCara mendekati inner child, terhubung dengannya, berbicara dengannya, sampai berdamai dengannya semua sudah terangkum dalam buku ini. Secara bertahap, mari ketahui dan pahami si anak batin, lalu hentikan kesedihannya dengan mengobati luka dan traumanya.\r\n\r\n-Mengenal Inner Child\r\n-Keterhubungan Inner Child dengan Diri Sendiri\r\n-Apa yang Ingin Didengar oleh Inner Child dari Anda\r\n-Inner Child yang Terluka dan Penyembuhannya\r\n-Hiduplah Sepenuh Hati\r\n\r\nTahun Terbit : Cetakan Pertama, 2025\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.\r\n'),
(17, 'Berani Perbaiki Diri', 'A. Yogaswara', 2025, ' 9786238114719', 'Checklist', 'Pengembangan Diri', 'Yang namanya hidup, pasti kita menginginkan yang versi terbaik. Segalanya mudah, menyenangkan, dan nyaman untuk dijalani. Namun, yang namanya hidup pula, tidak selamanya berjalan mulus. Pasti ada kerikil-kerikil di tengah jalan. Lucunya, tanpa kita sadari, kita sendirilah yang terkadang mengganggu hidup kita sendiri. Kita yang berulah hingga membuat hidup kita berantakan. Bagaimana bisa?\r\n\r\nSelayaknya blind spot, kita terlalu dekat dengan diri kita sendiri sehingga tidak mampu melihat dengan jelas apa saja yang telah kita perbuat dan dampak negatifnya terhadap hidup. Kita pun menjadi subjektif kepada diri sendiri, dan itu semua akhirnya berujung pada penyesalan.\r\n\r\nMelalui buku ini, penulis mengajak kita untuk refleksi diri, apakah kita termasuk orang yang senang menyabotase hidup sendiri atau tidak. Jika iya, maka kita harus menghentikan semua aksi diri negatif tersebut dengan menerapkan cara-cara yang telah penulis jabarkan dengan ringkas dan praktis.\r\n\r\nLebih baik menyadarinya hari ini, sebelum semuanya terlambat.\r\n• Mengapa Ada Orang yang Menyabotase Hidupnya Sendiri?\r\n• Mengapa Selalu Berkonflik dengan Orang Lain?\r\n• Anda adalah Anda\r\n• Mustahil Membuat Semua Orang Bahagia\r\n• Kesalahan yang Paling Banyak Dilakukan\r\n• dan masih banyak lagi.\r\n\r\n\r\nTahun Terbit : Cetakan Pertama, 2024\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.'),
(18, 'Bijak Mengelola Waktu', 'Amantha Imber', 2024, '9786238036288', 'Gemilang', 'Pengembangan Diri', 'Bijak Mengelola Waktu: Rahasia Orang-Orang Paling Sukses di Dunia Memaksimalkan Waktu\r\n\r\nOrang-orang yang berprestasi tinggi pastinya bekerja secara berbeda. Buku ini membongkar rahasia dan strategi yang dipakai orang-orang sukses untuk membuat segala sesuatunya berjalan lancar. Melalui buku ini, Anda akan menemukan rahasia produktivitas dari para pemikir, pemimpin, dan pengusaha terkemuka di dunia. Ini bukanlah buku produktivitas biasa.\r\n\r\nMelalui pembahasan mendalam tentang manajemen waktu, penulis mengungkap beberapa metode memaksimalkan waktu yang efektif dan meningkatkan produktivitas Anda. Beberapa orang berprestasi tinggi ditampilkan bersama dengan strategi pribadi mereka, seperti: menetapkan sistem alih-alih tujuan, berkonsultasi dengan dewan direksi pribadi, berfokus pada satu hal penting setiap hari, dan pendekatan memaksimalkan daftar tugas dan strategi-strategi lainnya.\r\n\r\nBuku ini akan memungkinkan Anda menguasai kekuatan super dalam menggunakan waktu Anda secara bijak untuk mencapai kesuksesan dalam bisnis dan kehidupan sehari-hari.\r\n\r\n\r\nTahun Terbit : Cetakan Pertama, November 2024\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.'),
(19, 'Filsafat Kepemimpinan Jawa', 'Retno D.N.', 2025, '9786235154077', 'Anak Hebat Indonesia', 'Filsafat', 'Filsafat Kepemimpinan Jawa : Membangun Nilai-nilai Kepemimpinan yang Beretika, Berwibawa, Bijaksana, dan Mengakar dalam Kearifan Lokal\r\n\r\n1.Apakah Anda sedang memegang posisi kepemimpinan atau mempersiapkan diri menjadi seorang pemimpin?\r\n2.Apakah Anda ingin mendalami filsafat kepemimpinan yang menjunjung tinggi etika, kebijaksanaan, dan kearifan lokal?\r\n3.Apakah Anda belum sepenuhnya paham tentang konsep dasar kepemimpinan?\r\n\r\nBuku ini cocok menjadi kompas perjalanan memperdalam ilmu kepemimpinan. Filsafat Kepemimpinan Jawa mengajak Anda menyelami kedalaman filsafat kepemimpinan Jawa, menekankan pentingnya nilai-nilai kearifan lokal dalam membentuk pemimpin yang bijaksana. Dengan berlandaskan spiritualitas, moralitas, dan pengabdian pada kesejahteraan bersama, filsafat ini merefleksikan kepemimpinan bukan sekadar jabatan, tetapi sebagai tugas mulia yang memprioritaskan harmoni antara pemimpin, anggota/masyarakat, dan lingkungan. Dalam buku ini penulis mengajak Anda untuk mendalami bahwa kepemimpinan sejati berakar pada kerendahan hati, tenggang rasa, dan cinta kasih, menjadikannya relevan dalam menghadapi tantangan modern yang kompleks.\r\n\r\nMelalui ajaran-ajaran yang telah diwariskan turun-temurun, buku ini juga mendorong siapapun, termasuk Anda, untuk beradaptasi dan berinovasi, tetap berakar pada jati diri, serta memimpin diri sebelum memimpin orang lain. Setiap halamannya mengajak pembaca untuk merefleksikan bagaimana nilai-nilai Jawa dapat diterapkan dalam konteks kepemimpinan saat ini, menciptakan pemimpin yang tidak hanya berpengaruh positif, tetapi juga menjadi agen perubahan yang memancarkan cahaya harapan di dunia yang semakin dinamis ini. Selamat membaca.\r\n\r\n\r\nTahun Terbit : Cetakan Pertama, Februari 2025\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.'),
(58, 'Spy X Family 01', 'Endo Tatsuya', 2020, '9786230021312', 'Elex Media Komputindo', 'Manga', 'Untuk menjaga perdamaian antara negara-negara saingan Westalis dan Ostania, agen Westalis dengan nama sandi \"Twilight\" ditugaskan untuk memata-matai Donovan Desmond, pemimpin partai politik ekstremis di Ostania. Namun, karena Desmond terkenal tertutup, satu-satunya cara Twilight bisa dekat dengannya adalah dengan mendaftarkan seorang anak di sekolah swasta yang sama dengan putra Desmond dan menyamar sebagai ayah mereka. Untuk mencapai ini, ia menciptakan alias Loid Forger, mengadopsi seorang gadis yatim piatu bernama Anya, dan menikahi seorang wanita bernama Yor Briar, untuk menciptakan citra keluarga yang bahagia. Namun, Yor sebenarnya adalah seorang pembunuh bayaran profesional, baik dia maupun Loid mereka berdua tidak menyadari identitas sebenarnya masing-masing. Keduanya juga tidak menyadari bahwa Anya bisa membaca pikiran, dan mengetahui profesi mereka yang sebenarnya. Terlepas dari faktor-faktor yang tidak diketahui ini, Loid harus belajar memainkan peran ayah dan suami yang sempurna untuk menjalankan misinya.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `librarian`
--

CREATE TABLE `librarian` (
  `librarian_id` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `address` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `librarian`
--

INSERT INTO `librarian` (`librarian_id`, `username`, `gender`, `no_hp`, `address`) VALUES
('LIB001', 'Fattah Syach', 'L', '081234567890', 'Jakarta'),
('LIB002', 'Aqeela Calista', 'P', '082345678901', 'Bandung'),
('LIB003', 'Arya Mohan', 'L', '083456789012', 'Surabaya'),
('LIB004', 'Raisa Marie', 'P', '084567890123', 'Yogyakarta'),
('LIB005', 'Nicole Rossi', 'P', '085678901234', 'Medan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `librarian_id` varchar(10) DEFAULT NULL,
  `loan_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_date` timestamp NULL DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `status` enum('borrowed','returned','overdue') DEFAULT 'borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `loans`
--

INSERT INTO `loans` (`loan_id`, `book_id`, `member_id`, `librarian_id`, `loan_date`, `return_date`, `due_date`, `status`) VALUES
(22, 15, 7, 'LIB003', '2025-05-31 12:11:38', '2025-06-12 04:57:25', NULL, 'returned'),
(23, 16, 7, 'LIB001', '2025-05-31 12:22:46', '2025-06-12 04:57:37', NULL, 'returned'),
(24, 17, 7, 'LIB002', '2025-06-12 02:16:42', '2025-06-12 04:57:33', NULL, 'returned'),
(25, 18, 7, 'LIB003', '2025-06-12 02:33:04', '2025-06-12 04:57:29', NULL, 'returned'),
(26, 3, 7, 'LIB002', '2025-06-12 04:56:29', '2025-06-12 04:57:21', NULL, 'returned'),
(27, 5, 7, 'LIB001', '2025-06-12 05:38:38', '2025-06-12 12:29:57', NULL, 'returned'),
(28, 18, 7, 'LIB005', '2025-06-22 14:00:21', '2025-06-24 15:25:24', NULL, 'returned'),
(29, 17, 7, 'LIB002', '2025-06-22 14:01:43', '2025-06-24 15:25:14', NULL, 'returned'),
(30, 58, 7, 'LIB002', '2025-06-25 06:31:47', NULL, NULL, 'borrowed'),
(31, 19, 7, 'LIB004', '2025-06-25 06:32:29', NULL, NULL, 'borrowed'),
(32, 13, 7, 'LIB005', '2025-06-25 06:36:05', NULL, NULL, 'borrowed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`member_id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$7ap9nPrU4K1cbs4TodJmiOlAy8Okht3iZr5VHW/oSedjEgwPdp2gO', '2025-05-25 00:58:00'),
(2, 'hanif', '$2y$10$a3/EDnXw4pdZnoYsLp36yuZPag146yEQk8rGQgE0KaTFoS/G6GYE2', '2025-05-25 02:45:13'),
(7, 'ree', '$2y$10$d9TUQ1QjL3yz/MedhP7aBeQ8iAlbG0ZeUVdT5XHiSbhxPn62DCCrO', '2025-05-25 03:34:08'),
(8, 'ijul', '$2y$10$/v1BaXxCOpet9u5VLw8/Vero/IXLCnA1AyZXvp8pwCNtq0Fs9eChu', '2025-05-25 04:18:16'),
(9, 'pebi', '$2y$10$7.kAT3IugN1RaeFZiZkn7eUkl7ztpc3jRQpjri3WrfeVDq2wGmCzO', '2025-05-25 04:22:42'),
(13, 'syafei', '$2y$10$c0vLIq6I5DbA.w.5XyYLbe42Brz3uXXoxIEGr7dA7fJYUUUz6e2iG', '2025-05-26 12:00:43'),
(29, 'test', '$2y$10$OxiNUKdsUw6u6vXsy2LqquhGVX52VB1DJqN2pT.e5xRAu0Pji.jFm', '2025-06-22 17:06:09'),
(31, 'test1', '$2y$10$b4z0kDE0i5dnLVhZtZaYVOjkghcJtIyxV5X8orj6S8CQ6oUlt2p66', '2025-06-22 17:07:40'),
(35, 'dzoel', '$2y$10$JT6.KT0TpSzUx/Vdcw3/cekUd2GyKfTwXDLPKJLik7q5YxYTFirne', '2025-06-24 11:12:47'),
(41, 'Yusuf', '$2y$10$XklU/cunDB.8rAploHy6NuBCs1NSy92Bi2Td2e50SGwA83SMEvOFW', '2025-06-30 07:49:05'),
(44, 'Cireng', '$2y$10$FhtmpYq1pW.Hjdq.fPqeuu0kRz2aNG7a9YbDKhmA8e5xnpjgMBujy', '2025-06-30 13:59:55');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indeks untuk tabel `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`librarian_id`);

--
-- Indeks untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`member_id`),
  ADD KEY `note` (`librarian_id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `note` FOREIGN KEY (`librarian_id`) REFERENCES `librarian` (`librarian_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
