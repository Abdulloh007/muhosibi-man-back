<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("doc_groups")->insert(
            [
                "title"=> "Group",
                "comment"=> "Comment", 
                "status"=> 1, 
            ]
        );
    }
}
