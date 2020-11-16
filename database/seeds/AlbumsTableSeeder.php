<?php

use Illuminate\Database\Seeder;

class AlbumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'user_id' => 1,
            'title' => 'title1',
            'path' => 'path1',
            'image' => 'image1',
            'comment' => 'comment1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('albums')->insert($params);
    }
}
