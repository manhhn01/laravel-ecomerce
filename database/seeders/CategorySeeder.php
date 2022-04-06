<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $categoryNames = ["Áo thun ngắn tay", "Áo sơ mi", "Áo sơ mi dài tay", "Áo sơ mi nữ ngắn tay", "Áo voan", "Áo ren", "Áo len", "Áo len dệt kim", "Váy - đầm", "Đầm", "Váy", "Đầm dài tay", "Đầm voan", "Đầm ren", "Đầm len", "Bộ đồ", "Bộ đồ jumpsuit", "Bộ đồ thể thao", "Bộ đồ ngắn tay", "Bộ đồ dài tay", "Áo khoác", "Áo nỉ nữ", "Áo khoác jeans", "Áo vest nữ", "Áo khoác lửng", "Áo dạ nữ", "Áo gile nữ", "Quần nữ", "Quần Jeans nữ", "Quần legging nữ", "Quần short nữ", "Quần thể thao nữ", "Quần harem", "Quần bút chì", "Quần áo nam", "Áo thun", "Áo thun Polo", "Áo thun dài tay", "Áo thun ngắn tay", "Áo sơ mi", "Áo sơ mi ngắn tay", "Áo sơ mi dài tay", "Áo len/ đồ đan", "Áo len dệt kim", "Áo len chui đầu", "Áo jeans nam", "Áo nỉ nam", "Áo nỉ chui đầu", "Áo khoác nam", "Áo da nam", "Áo dạ nam", "Áo khoác Jeans", "Áo gió nam", "Áo Gile nam", "Áo phao nam", "Quần nam", "Quần short nam", "Quần Jeans nam", "Quần Âu nam", "Quần thể thao nam", "Quần short Jeans nam", "Quần túi hộp", "Quần vải kaki"];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categoryNames as $categoryName) {
            Category::factory(['name' => $categoryName])->create();
        }
    }
}
