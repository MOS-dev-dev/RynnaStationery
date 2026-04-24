<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ của bảng products và categories để làm mới
        DB::statement('PRAGMA foreign_keys = OFF;');
        Product::truncate();
        Category::truncate();
        DB::statement('PRAGMA foreign_keys = ON;');

        $faker = Faker::create('vi_VN');

        $categoryNames = [
            'Thức ăn cho chó', 
            'Thức ăn cho mèo', 
            'Đồ chơi thú cưng', 
            'Phụ kiện (Vòng cổ, Dây dắt)', 
            'Chăm sóc & Vệ sinh', 
            'Chuồng & Chăn nệm'
        ];

        $categoryIds = [];
        foreach ($categoryNames as $name) {
            $category = Category::firstOrCreate(['name' => $name]);
            $categoryIds[] = $category->id;
        }

        $petProductNames = [
            'Hạt Royal Canin cho mèo con',
            'Pate Whiskas vị cá ngừ',
            'Thức ăn hạt Pedigree cho chó lớn',
            'Súp thưởng Ciao Churu',
            'Cát sáp đậu nành Tofu Cat Litter',
            'Sữa tắm SOS cho chó lông trắng',
            'Đồ chơi cần câu mèo đính lông chim',
            'Bóng len có chuông cho thú cưng',
            'Chuồng chó gấp gọn tĩnh điện',
            'Khay vệ sinh cho mèo có thành cao',
            'Bát ăn dặm chống sặc cho chó',
            'Dây dắt chó kèm yếm phản quang',
            'Lược chải lông rụng có nút bấm',
            'Đệm nằm hình thú dễ thương',
            'Xịt khử mùi bồn đi vệ sinh',
            'Bánh thưởng xương chó vị bò mặn',
            'Cỏ bạc hà (Catnip) sấy khô nguyên chất',
            'Nhà cây cho mèo (Cat tree) 3 tầng',
            'Nước nhỏ mắt rửa ghèn cho chó mèo',
            'Balo phi hành gia vận chuyển thú cưng'
        ];

        foreach ($petProductNames as $index => $name) {
            $price = $faker->numberBetween(5, 100) * 10000; // Giá từ 50k đến 1000k
            $hasSale = $faker->boolean(40);

            Product::create([
                'name' => $name,
                'category_id' => $categoryIds[array_rand($categoryIds)], // Gán ngẫu nhiên vào các danh mục trên
                'price' => $price,
                'sale_price' => $hasSale ? intval($price * 0.8) : null,
                'stock' => $faker->numberBetween(15, 300),
                'description' => 'Sản phẩm ' . $name . ' chính hãng. ' . $faker->realText(200),
                'image' => 'https://loremflickr.com/400/400/pets?lock=' . ($index + 1), // Sử dụng lock để cố định ảnh
                'brand' => $faker->company(),
                'sold_count' => $faker->numberBetween(0, 500),
                'is_flash_sale' => $faker->boolean(20),
                'flash_sale_end' => $faker->boolean(20) ? now()->addDays(rand(1, 5)) : null,
            ]);
        }
    }
}
