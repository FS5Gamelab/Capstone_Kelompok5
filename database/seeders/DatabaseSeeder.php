<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(Faker $faker): void
    {
        // User::factory(10)->create();


        $user = User::factory()->create([
            'email' => 'user@gmail.com',
        ]);
        $user2 = User::factory()->create([
            'email' => 'admin@gmail.com',
            "role" => "admin",
        ]);
        $user3 = User::factory()->create([
            'email' => 'superadmin@gmail.com',
            "role" => "super admin",
        ]);

        Blog::create([
            "title" => "Tips Memilih Bahan Baku Segar untuk Masakan Anda",
            "slug" => "tips-memilih-bahan-baku-segar-untuk-masakan-anda",
            "description" => "
                <p>Memilih bahan baku segar adalah langkah penting untuk memastikan kualitas masakan Anda tetap prima. Berikut adalah beberapa tips yang bisa Anda terapkan:</p>
                <ul>
                    <li><strong>Pilih Sayuran Segar:</strong> Pastikan sayuran yang Anda pilih memiliki warna yang cerah dan tidak layu. Cobalah untuk membeli sayuran di pasar tradisional atau supplier lokal yang terpercaya.</li>
                    <li><strong>Daging Berkualitas:</strong> Untuk daging, pilih yang berwarna merah segar tanpa bau amis. Jika memungkinkan, belilah daging dari peternak lokal.</li>
                    <li><strong>Bumbu dan Rempah:</strong> Pilih bumbu dan rempah yang masih segar untuk memberikan aroma dan rasa yang lebih kuat pada masakan Anda.</li>
                </ul>
                <p>Dengan memilih bahan baku yang segar, Anda dapat memastikan bahwa masakan Anda tidak hanya lezat tetapi juga sehat untuk dinikmati.</p>
            ",
            "blog_image" => "static/images/samples/bahanbaku.jpg",
        ]);

        Blog::create([
            "title" => "Resep Rahasia Nasi Goreng Spesial Restoran Kami",
            "slug" => "resep-rahasia-nasi-goreng-spesial-restoran-kami",
            "description" => "
                <p>Apakah Anda penasaran dengan resep nasi goreng spesial kami yang selalu membuat lidah bergoyang? Berikut adalah resep rahasia kami:</p>
                <h3>Bahan-bahan:</h3>
                <ul>
                    <li>2 porsi nasi putih</li>
                    <li>2 butir telur</li>
                    <li>100 gram daging ayam, potong dadu</li>
                    <li>2 siung bawang putih, cincang halus</li>
                    <li>2 sendok makan kecap manis</li>
                    <li>1 sendok makan kecap asin</li>
                    <li>1 sendok teh saus tiram</li>
                    <li>1 sendok makan minyak wijen</li>
                    <li>Garam dan merica secukupnya</li>
                    <li>Daun bawang, iris tipis untuk taburan</li>
                </ul>
                <h3>Cara Memasak:</h3>
                <ol>
                    <li>Panaskan minyak di wajan, tumis bawang putih hingga harum.</li>
                    <li>Masukkan daging ayam, masak hingga berubah warna.</li>
                    <li>Tambahkan telur, orak-arik hingga matang.</li>
                    <li>Masukkan nasi putih, aduk rata dengan bahan lainnya.</li>
                    <li>Tambahkan kecap manis, kecap asin, saus tiram, dan minyak wijen. Aduk rata.</li>
                    <li>Bumbui dengan garam dan merica sesuai selera.</li>
                    <li>Angkat dan sajikan dengan taburan daun bawang di atasnya.</li>
                </ol>
                <p>Selamat mencoba dan nikmati kelezatan nasi goreng spesial ala restoran kami di rumah Anda!</p>
            ",
            "blog_image" => "static/images/samples/nasigoreng.jpg",
        ]);

        Blog::create([
            "title" => "Manfaat Mengonsumsi Makanan Sehat Setiap Hari",
            "slug" => "manfaat-mengonsumsi-makanan-sehat-setiap-hari",
            "description" => "
                <p>Mengonsumsi makanan sehat setiap hari memiliki banyak manfaat bagi kesehatan tubuh. Beberapa manfaat tersebut antara lain:</p>
                <ul>
                    <li><strong>Meningkatkan Energi:</strong> Makanan sehat dapat memberikan energi yang cukup untuk menjalani aktivitas sehari-hari.</li>
                    <li><strong>Menjaga Berat Badan Ideal:</strong> Pola makan sehat dapat membantu Anda menjaga berat badan ideal dan mencegah obesitas.</li>
                    <li><strong>Meningkatkan Sistem Kekebalan Tubuh:</strong> Nutrisi yang baik dapat membantu memperkuat sistem kekebalan tubuh.</li>
                    <li><strong>Menjaga Kesehatan Jantung:</strong> Makanan sehat dapat mengurangi risiko penyakit jantung.</li>
                </ul>
                <p>Oleh karena itu, penting untuk selalu memilih makanan yang sehat dan bergizi setiap hari.</p>
            ",
            "blog_image" => "static/images/samples/healthty.jpg",
        ]);
        Blog::create([
            "title" => "Menu baru! Sate Padang",
            "slug" => "menu-baru-sate-padang",
            "description" => "
                <p>Kami akan segera merilis menu baru kami berupa makanan khas pulau minang yaitu sate padang. Kami akan mulai menjual menu ini pada tanggal 20 juni 2024  bagi costemer yang meyukai menu ini, kami menantikan pesanan anda.</p>
            ",
            "blog_image" => "static/images/samples/sate-padang.png",
        ]);
        Blog::create([
            "title" => "Menu baru! Sate Madura",
            "slug" => "menu-baru-sate-madura",
            "description" => "
                <p>Kami akan segera merilis menu baru kami berupa makanan khas madura yaitu sate madura. Kami akan mulai menjual menu ini pada tanggal 2 juli 2024  bagi costemer yang meyukai menu ini, kami menantikan pesanan anda.</p>
            ",
            "blog_image" => "static/images/samples/sate-madura.png",
        ]);
        Blog::create([
            "title" => "Menu baru! Coto Makassar",
            "slug" => "menu-baru-coto-makassar",
            "description" => "
                <p>Kami akan segera merilis menu baru kami yaitu Coto makassar . Kami akan mulai menjual menu ini pada tanggal 4 Agustus 2024  bagi costemer yang meyukai menu ini, kami menantikan pesanan anda.
                </p>
            ",
            "blog_image" => "static/images/samples/coto-mks.png",
        ]);
        Blog::create([
            "title" => "Kejutan!",
            "slug" => "kejutan",
            "description" => "
                <p>Kami memberikan potongan harga sebesar 20% untuk semua produk Selera Negri bagi 10 coustamer pertama yang memesan produk kami pada hari peresmian pembukaan restoran selera negri! Yang akan dibuka pada tanggal 15 juni 2024. 
                </p>
            ",
            "blog_image" => "static/images/samples/disc.png",
        ]);

        $category = Category::create([
            "category_name" => "Main Course",
            "user_id" => 3,
        ]);
        $category2 = Category::create([
            "category_name" => "Sampingan",
            "user_id" => 3,
        ]);

        Product::create([
            "product_image" => "static/images/samples/nasigoreng2.jpg",
            "product_name" => "Nasi Goreng",
            'slug' => "nasi-goreng",
            "type" => "foods",
            "description" => "Nasi goreng spesial",
            "price" => 12000,
            "category_id" => $category->id,
            "user_id" => 3,
            "stock" => 20,
        ]);
        Product::create([
            "product_image" => "static/images/samples/ayam-bakar.png",
            "product_name" => "Ayam Bakar",
            'slug' => "ayam-bakar",
            "type" => "foods",
            "description" => "Ayam Bakar Spesial, Enak dan Murah",
            "price" => 20000,
            "category_id" => $category->id,
            "user_id" => 3,
            "stock" => 20,

        ]);
        Product::create([
            "product_image" => "static/images/samples/nasi-kuning.png",
            "product_name" => "Nasi Kuning",
            'slug' => "nasi-kuning",
            "type" => "foods",
            "description" => "Nasi kuning yang gurih dan enak",
            "price" => 12000,
            "category_id" => $category->id,
            "user_id" => 3,
            "stock" => 20,

        ]);
        Product::create([
            "product_image" => "static/images/samples/eggnog.png",
            "product_name" => "Eggnog",
            'slug' => "eggnog",
            "type" => "drinks",
            "description" => "Minuman manis dari kuning telur yang dikocok ditambah air dan gula atau susu. Sebagai perisa adalah bubuk vanili, pala, atau kayu manis. ",
            "price" => 10000,
            "category_id" => $category2->id,
            "user_id" => 3,
            "stock" => 20,

        ]);
        Product::create([
            "product_image" => "static/images/samples/es-teh.png",
            "product_name" => "Es Teh",
            'slug' => "es-teh",
            "type" => "drinks",
            "description" => "Minuman manis",
            "price" => 5000,
            "category_id" => $category2->id,
            "user_id" => 3,
            "stock" => 20,

        ]);
        Product::create([
            "product_image" => "static/images/samples/hot-coffe.png",
            "product_name" => "Hot Coffe",
            'slug' => "hot-coffe",
            "type" => "drinks",
            "description" => "Kopi panas yang enak",
            "price" => 7000,
            "category_id" => $category2->id,
            "user_id" => 3,
            "stock" => 20,

        ]);
    }
}
