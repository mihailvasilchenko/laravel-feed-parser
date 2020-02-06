<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeedTest extends TestCase
{
    /**
     * Test if feed data is passed to the page.
     *
     * @test
     *
     * @return void
     */
    public function test_if_feed_data_is_passed_to_view()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/home');

        $response->assertViewHas('items');
        $response->assertViewHas('top');
    }

    /**
     * Test if feed top returns an array of 10 items.
     *
     * @test
     *
     * @return void
     */
    public function test_if_feed_data_top_has_array_of_10_items()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/home');

        $top = $response->original->getData()['top'];

        $this->assertIsArray($top);
        $this->assertCount(10, $top);
    }
}
