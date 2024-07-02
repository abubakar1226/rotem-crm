<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\MessageTemplate;
use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->templates() as $template) {
            MessageTemplate::create($template);
        }
    }

    private function templates()
    {
        return [
            [
                'message' => "Hi {{Customer Name}},\\n\\nWe tried reaching you a couple of times but missed you.\\n"
                    . "We're here to help with your garage door issue whenever you're free.\\n\\nThanks!\\n\\n"
                    . "MRS Garage Door Team",
                'category' => StatusEnum::noResponse()
            ],
            [
                'message' => "Hi {{Customer Name}},\\n\\nWe tried reaching you a couple of times but missed you.\\n"
                    . "We're here to help with your garage door issue whenever you're free.\\n\\nThanks!\\n\\n"
                    . "MRS Garage Door Team",
                'category' => StatusEnum::noResponseTwice()
            ]
        ];
    }
}
