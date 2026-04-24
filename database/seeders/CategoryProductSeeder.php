<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Bút', 'slug' => 'but', 'icon' => 'pen'],
            ['name' => 'Giấy', 'slug' => 'giay', 'icon' => 'scroll'],
            ['name' => 'Đèn để bàn', 'slug' => 'den-de-ban', 'icon' => 'lightbulb'],
            ['name' => 'Dụng cụ học sinh', 'slug' => 'dung-cu-hoc-sinh', 'icon' => 'pencil-ruler'],
            ['name' => 'Kệ đựng tài liệu', 'slug' => 'ke-dung-tai-lieu', 'icon' => 'folder-open'],
            ['name' => 'Bảng', 'slug' => 'bang', 'icon' => 'chalkboard'],
            ['name' => 'Vở viết', 'slug' => 'vo-viet', 'icon' => 'book'],
        ];

        foreach ($categories as $cat) {
            $category = Category::updateOrCreate(
                ['name' => $cat['name']],
                ['name' => $cat['name']]
            );

            // Create sample products for each category
            $this->createProductsForCategory($category);
        }
    }

    private function createProductsForCategory($category)
    {
        $productsData = [
            'Bút' => [
                ['name' => 'Bút bi Kaweco Sport (Classic)', 'price' => 550000, 'image' => 'https://images.unsplash.com/photo-1585336261022-69c6e29669a1?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Bút máy Lamy Safari Pastel', 'price' => 750000, 'image' => 'https://images.unsplash.com/photo-151351190280c-47faa305307a?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Set Bút chì kim Rotring 600', 'price' => 890000, 'image' => 'https://images.unsplash.com/photo-1543852786-1cf6624b9987?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Bút Gel Muji (Set 12 màu)', 'price' => 250000, 'image' => 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Bút lông viết thư pháp Tombow', 'price' => 85000, 'image' => 'https://images.unsplash.com/photo-1563836338002-337672228749?q=80&w=800&auto=format&fit=crop'],
            ],
            'Giấy' => [
                ['name' => 'Giấy in mỹ thuật Conqueror A4', 'price' => 120000, 'image' => 'https://images.unsplash.com/photo-1586075010620-2d5218953029?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Xấp giấy Kraft gói quà (10 tờ)', 'price' => 45000, 'image' => 'https://images.unsplash.com/photo-1510212330253-e44876241f3e?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Giấy note Post-it Pastel Mix', 'price' => 35000, 'image' => 'https://images.unsplash.com/photo-1610484826967-09c5720778c7?q=80&w=800&auto=format&fit=crop'],
            ],
            'Đèn để bàn' => [
                ['name' => 'Đèn học chống cận Xiaomi LED', 'price' => 1250000, 'image' => 'https://images.unsplash.com/photo-1534073828943-f801091bb18c?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Đèn trang trí Minimalist Wood', 'price' => 850000, 'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed657f9971?q=80&w=800&auto=format&fit=crop'],
            ],
            'Dụng cụ học sinh' => [
                ['name' => 'Hộp bút vải Canvas Premium', 'price' => 150000, 'image' => 'https://images.unsplash.com/photo-1544200175-961807469a7c?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Thước kẻ nhôm định hình 30cm', 'price' => 65000, 'image' => 'https://images.unsplash.com/photo-1629112444315-f559bc84d8cc?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Gọt bút chì điện tự động', 'price' => 320000, 'image' => 'https://images.unsplash.com/photo-1558238612-42111f151978?q=80&w=800&auto=format&fit=crop'],
            ],
            'Kệ đựng tài liệu' => [
                ['name' => 'Kệ tầng gỗ tre tự nhiên', 'price' => 450000, 'image' => 'https://images.unsplash.com/photo-1512314889357-e157c22f938d?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Hộp file tài liệu sắt lưới đen', 'price' => 180000, 'image' => 'https://images.unsplash.com/photo-1563212629-873623063f45?q=80&w=800&auto=format&fit=crop'],
            ],
            'Bảng' => [
                ['name' => 'Bảng từ trắng treo tường 60x80', 'price' => 580000, 'image' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Bảng ghim bần khung gỗ', 'price' => 350000, 'image' => 'https://images.unsplash.com/photo-1598214812328-3e4b3164a275?q=80&w=800&auto=format&fit=crop'],
            ],
            'Vở viết' => [
                ['name' => 'Sổ tay Midori MD Notebook', 'price' => 380000, 'image' => 'https://images.unsplash.com/photo-1519337265831-281ec6cc8514?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Vở kẻ ngang Camping Design (Set 5)', 'price' => 95000, 'image' => 'https://images.unsplash.com/photo-1516962215378-7fa2e137ae93?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Sổ lò xo Dotgrid B5', 'price' => 120000, 'image' => 'https://images.unsplash.com/photo-1517842645767-c639042777db?q=80&w=800&auto=format&fit=crop'],
            ],
        ];

        if (isset($productsData[$category->name])) {
            foreach ($productsData[$category->name] as $prod) {
                Product::updateOrCreate(
                    ['name' => $prod['name']],
                    [
                        'price' => $prod['price'],
                        'stock' => rand(10, 100),
                        'category_id' => $category->id,
                        'image' => $prod['image'], // Using external URL directly
                        'description' => 'Sản phẩm ' . $prod['name'] . ' chất lượng cao, thiết kế tinh tế phù hợp cho mọi không gian làm việc.',
                        'is_flash_sale' => (rand(1, 10) > 8),
                        'sale_price' => (rand(1, 10) > 8) ? ($prod['price'] * 0.8) : null,
                    ]
                );
            }
        }
    }
}
