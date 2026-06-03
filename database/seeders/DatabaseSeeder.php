<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create categories
        $categoriesData = [
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle'],
            ['name' => 'Travel', 'slug' => 'travel'],
            ['name' => 'Food', 'slug' => 'food'],
            ['name' => 'Design', 'slug' => 'design'],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[] = Category::create($data);
        }

        // 2. Create posts data
        $postsData = [
            [
                'title' => 'The Future of Web Development in 2026',
                'category_index' => 0, // Technology
                'excerpt' => 'Discover the latest trends in web development, from framework updates to AI integration.',
                'body' => "Web development is evolving at an unprecedented pace. In 2026, we see a massive shift towards edge rendering, AI-assisted coding, and zero-bundle-size client-side libraries. Developers are expected to understand not just coding, but also system design, automated testing, and developer experience tools like Antigravity. In this post, we will explore the major technologies shaping the industry.\n\nFrom a tooling perspective, modern runtimes are displacing older versions, making fullstack projects fast and lightweight. Developers are building dynamic experiences with less client-side bloat, resulting in highly interactive pages that load in a fraction of a second.",
            ],
            [
                'title' => 'Why Laravel Remains a Top Choice for Developers',
                'category_index' => 0, // Technology
                'excerpt' => 'Explore the reasons why Laravel continues to dominate backend web development.',
                'body' => "Laravel has built a robust ecosystem that goes far beyond a simple PHP framework. With tools like Breeze, Jetstream, Inertia, Livewire, Forge, and Vapor, Laravel makes it incredibly easy to go from a simple idea to a highly scalable production application. The framework's commitment to developer happiness, elegant syntax, and rapid release cycles ensures it remains a top choice in 2026.\n\nFor JavaScript developers entering the backend space, Laravel provides a beautiful, opinionated architecture that simplifies routing, authentication, ORM database querying, and background queue jobs, saving thousands of hours of setup time.",
            ],
            [
                'title' => '10 Simple Habits for a Balanced Daily Life',
                'category_index' => 1, // Lifestyle
                'excerpt' => 'Small daily habits can make a huge impact on your physical and mental well-being.',
                'body' => "Maintaining balance in a fast-paced world can be challenging. By integrating simple habits into your routine, such as morning meditation, walking meetings, drinking enough water, and setting digital boundaries, you can drastically improve your focus and reduce stress levels. Let's break down ten habits that you can start practicing today.\n\nAdditionally, scheduling a simple block of time away from screens and stepping outside helps recharge cognitive functions and clears the mind for creative thinking later in the day.",
            ],
            [
                'title' => 'The Art of Minimalist Living',
                'category_index' => 1, // Lifestyle
                'excerpt' => 'Decluttering your environment can lead to a decluttered and peaceful mind.',
                'body' => "Minimalism isn't just about throwing away things; it's about making room for what truly matters. In this article, we dive deep into the philosophy of minimalism, looking at how physical environments influence our mental state, and how removing excess noise from our schedules helps us focus on our core passions and relationships.\n\nBy simplifying what we own and do, we create more emotional bandwidth to appreciate everyday details, slow down, and reduce overall anxiety.",
            ],
            [
                'title' => 'Exploring the Hidden Gems of Kyoto, Japan',
                'category_index' => 2, // Travel
                'excerpt' => 'Kyoto is famous for temples, but these lesser-known spots will make your trip magical.',
                'body' => "While Kinkaku-ji and Fushimi Inari are spectacular, Kyoto has many secret spots hidden away from the typical tourist crowds. From the quiet bamboo paths in Gio-ji to the tranquil gardens of Tofuku-ji, we share an off-the-beaten-path itinerary that allows you to experience the authentic, serene spirit of Kyoto.\n\nTaking time to enjoy local matcha tea at a traditional wooden teahouse along the quiet streets of Higashiyama is a core memory in the making for any traveler looking to go beyond the postcard landmarks.",
            ],
            [
                'title' => 'A Weekend Guide to Rome, Italy',
                'category_index' => 2, // Travel
                'excerpt' => 'How to experience the historic streets, ruins, and food of Rome in just 48 hours.',
                'body' => "Rome wasn't built in a day, and you certainly can't see it all in a weekend. However, with a smart itinerary, you can visit the Colosseum, throw a coin in the Trevi Fountain, explore the Vatican Museums, and eat some of the best carbonara of your life. Here is our step-by-step guide to maximizing a short trip to the Eternal City.\n\nAvoid the tourist traps by walking into the side alleys of Trastevere for authentic, family-run osterias where fresh pasta is rolled right in front of you.",
            ],
            [
                'title' => 'Mastering the Perfect Sourdough Loaf at Home',
                'category_index' => 3, // Food
                'excerpt' => 'Learn the secrets to achieving a crispy crust and a beautifully airy crumb.',
                'body' => "Baking sourdough is a journey of patience, science, and intuition. From feeding your starter to understanding hydration levels, stretch-and-folds, and the final bake in a Dutch oven, this guide covers everything a beginner needs to know to get a bakery-quality loaf right out of their home oven.\n\nThe real secret lies in ambient temperature control and recognizing the visual cues of fermentation, rather than following a strict timer. Once you get it right, the crackling sound of a cooling crust is highly rewarding.",
            ],
            [
                'title' => 'The Ultimate Guide to Plant-Based Dinners',
                'category_index' => 3, // Food
                'excerpt' => 'Delicious, nutrient-dense recipes that will satisfy everyone at the table.',
                'body' => "Eating plant-based doesn't mean sacrificing flavor or feeling hungry. We have compiled a list of five hearty recipes, including lentil shepherd's pie, spicy chickpea coconut curry, and roasted sweet potato Buddha bowls, that are packed with protein, easy to prepare, and incredibly delicious.\n\nUsing fresh herbs, spices, and acid (like lime or lemon juice) at the end of cooking elevates these plant-based ingredients from standard fare to restaurant-level cuisine.",
            ],
            [
                'title' => 'Understanding the Core Principles of UI/UX',
                'category_index' => 4, // Design
                'excerpt' => 'A beginner guide to contrast, hierarchy, alignment, and spacing in user interfaces.',
                'body' => "Good design is invisible. It guides the user naturally towards their goals without creating confusion. In this post, we analyze the four core pillars of visual interface design: contrast (making key elements stand out), visual hierarchy (directing the reader's eye), alignment (creating clean grids), and spacing (allowing the layout to breathe).\n\nWhen we construct clean interfaces, user friction is minimized, leading to better user satisfaction and higher rates of task completion.",
            ],
            [
                'title' => 'Why Typography Can Make or Break a Design',
                'category_index' => 4, // Design
                'excerpt' => 'Choosing the right typeface is essential for readability and emotional impact.',
                'body' => "Typography is the voice of your text. A sleek sans-serif font communicates modernity and clean professionalism, while a classic serif font brings trust and heritage. We examine how to pair fonts, how line height affects readability, and how choosing the wrong font size can ruin an otherwise perfect user interface.\n\nGreat typography ensures that communication is smooth, clear, and carries the correct emotional tone appropriate for the brand's identity.",
            ],
        ];

        // 3. Create users with specific roles
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $authorUser = User::factory()->create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'role' => 'author',
            'password' => bcrypt('password'),
        ]);

        $readerUser = User::factory()->create([
            'name' => 'Reader User',
            'email' => 'reader@example.com',
            'role' => 'reader',
            'password' => bcrypt('password'),
        ]);

        // 4. Create posts and associate them with the Author
        foreach ($postsData as $postItem) {
            Post::create([
                'user_id' => $authorUser->id,
                'category_id' => $categories[$postItem['category_index']]->id,
                'title' => $postItem['title'],
                'slug' => Str::slug($postItem['title']),
                'excerpt' => $postItem['excerpt'],
                'body' => $postItem['body'],
            ]);
        }
    }
}
