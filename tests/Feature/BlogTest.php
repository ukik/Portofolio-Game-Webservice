<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
     public function testInsert (){
       $user = factory(\App\Blog::class, 1)->make([
         'title' => 'Unit Test',
       ]);

       return $this->assertDatabaseHas('blogs', [
         'title' => 'Unit Test',
       ]);
     }
}
