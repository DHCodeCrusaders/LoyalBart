<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\LoyaltyProgram;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'First Organizer',
                'email' => 'organizer1@email.com',
                'is_organizer' => true,
            ],
            [
                'name' => 'Second Organizer',
                'email' => 'organizer2@email.com',
                'is_organizer' => true,
            ],
            [
                'name' => 'First Customer',
                'email' => 'customer1@email.com',
            ],
            [
                'name' => 'Second Customer',
                'email' => 'customer2@email.com',
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        $programs = [
            [
                'title' => "WorldLink Communication Pvt. Ltd.",
                'description' => "WorldLink is the largest Internet and Network Service Provider in Nepal and one of the most prominent IT companies. Founded in September 1995 with the aim of providing Internet and IT services by its present Chairman and Managing Director Dileep Agrawal, WorldLink started off by providing store-and-forward e-mail services over a dial-up link to the Internet in the US. ",
                'photo' => "https://worldlink.com.np/wp-content/uploads/2022/12/WhatsApp-Image-2022-12-29-at-11.46.15.jpeg",
                'organizer_id' => 1,
            ],
            [
                'title' => "Amrapali",
                'description' => "Amrapali Beverage Pvt. Ltd. is in the food and beverage industry specializing in producing juice of different flavors and mineral water and also variety of Can Juice.",
                'photo' => "https://amrapalibeverage.com/uploads/1603112239.jpeg",
                'organizer_id' => 1,
            ],
            [
                'title' => "Sticker Mule",
                'description' => "Sticker Mule aims to build an incredible experience for ordering custom products. We relentlessly focus on making it fast and easy to order custom products. Order in seconds and get your products in days. Free proofs, free artwork help, free shipping and fast turnaround are why people love us.",
                'photo' => "https://assets.stickermule.com/image/upload/c_lfill,fl_lossy,f_auto,q_auto:best,w_auto/re-store-shared/about-experience-image.jpg",
                'organizer_id' => 1,
            ],
            [
                'title' => "Mount Strada Coffee",
                'description' => "Mount Strada Coffee is one of the best barista training in Nepal. Barista training is conducted by certified professional Barista from Specialty Coffee Association. Also, we collect fresh beans from different corners of Nepal and also distribute them in national and international markets as well.",
                'photo' => "https://scontent.fktm10-1.fna.fbcdn.net/v/t39.30808-6/315850735_189685173592417_7745171175191047828_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=e3f864&_nc_ohc=InBv2Tt5P64AX8zkR4s&_nc_ht=scontent.fktm10-1.fna&oh=00_AfAFuP9wO1voqi6u5ZGgggBCFxtJGTTMw2LsrOjgUOdU4A&oe=645B9BB6",
                'organizer_id' => 2,
            ],

            [
                'title' => "Goldstar Shoes",
                'description' => "Launched in 1990, Goldstar Shoes is underpinned by three key features; Comfortable, Durable, and Affordable. Goldstar Shoes are crafted with genuine materials using innovative technology, for this reason, we are able to be part of each household in Nepal and India, as well as gaining popularity in Western countries.",
                'photo' => "https://www.goldstarshoes.com/MediaThumb/original/Media/Goldstar/Banners/slider4-compressor-1.jpg",
                'organizer_id' => 2,
            ],

            [
                'title' => "Chicken Station",
                'description' => "We have more than 50 profitable outlets across the country making us the fastest growing fast-food chain in Nepal. We offer a wide range of fast food at the most affordable price without compromising the quality.",
                'photo' => "https://chickenstation.com.np/wp-content/uploads/2022/01/jorpati.jpg",
                'organizer_id' => 2,
            ],
        ];

        foreach ($programs as $program) {
            LoyaltyProgram::factory()->create($program);
        }

        User::customer()->first()->loyaltyPrograms()
            ->attach([1 => ['points' => 100], 2 => ['points' => 100], 3 => ['points' => 100]]);
            
        User::customer()->skip(1)->first()->loyaltyPrograms()
            ->attach([4 => ['points' => 100], 5 => ['points' => 100], 6 => ['points' => 100]]);
    }
}
