<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $min_user = User::min('id');
        $max_user = User::max('id');

        $content = $this->faker->sentence(100);
        $short_content = wordwrap($content, 30, "<br/>", true);
        $short_content = explode("<br/>", $short_content);
        $short_content = reset($short_content);

        return [
            'user_id' => mt_rand($min_user, $max_user),
            'title' => $this->faker->sentence(6),
            'content' => $content,
            'short_description' => $short_content . "...",
            'banner' => $this->faker->imageUrl(1024, 600),
        ];
    }
}
