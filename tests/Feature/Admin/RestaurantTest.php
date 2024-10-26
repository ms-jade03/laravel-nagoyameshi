<?php

namespace Tests\Feature\Admin;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    //index
    /** 未ログインのユーザーは管理者側の店舗一覧ページにアクセスできない */
    public function test_guest_cannot_access_admin_restaurants_index()
    {
        $response = $this->get(route('admin.restaurants.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの一般ユーザーは管理者側の店舗一覧ページにアクセスできない */
    public function test_user_cannot_access_admin_restaurants_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの管理者は管理者側の店舗一覧ページにアクセスできる */
    public function test_admin_can_access_admin_restaurants_index()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
 
        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.index'));
        $response->assertStatus(200); 
    }


    //show
    /** 未ログインのユーザーは管理者側の店舗詳細ページにアクセスできない */
    public function test_guest_cannot_access_admin_restaurants_show()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->get(route('admin.restaurants.show', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの一般ユーザーは管理者側の店舗一覧ページにアクセスできない */
    public function test_user_cannot_access_admin_restaurants_show()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.show', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの管理者は管理者側の店舗一覧ページにアクセスできる */
    public function test_admin_can_access_admin_restaurants_show()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.show', $restaurant));
        $response->assertStatus(200);
    }


    //create
    /** 未ログインのユーザーは管理者側の店舗詳細ページにアクセスできない */
    public function test_guest_cannot_access_admin_restaurants_create()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->get(route('admin.restaurants.create', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの一般ユーザーは管理者側の店舗一覧ページにアクセスできない */
    public function test_user_cannot_access_admin_restaurants_create()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.create', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの管理者は管理者側の店舗一覧ページにアクセスできる */
    public function test_admin_can_access_admin_restaurants_create()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.create', $restaurant));
        $response->assertStatus(200);
    }


    //store
    /** 未ログインのユーザーは店舗を登録できない */
    public function test_guest_cannot_access_admin_restaurants_store()
    {
        $restaurant = Restaurant::factory()->make()->toArray();

        $response = $this->post(route('admin.restaurants.store'), $restaurant);
        $this->assertDatabaseMissing('restaurants', $restaurant);
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの一般ユーザーは店舗を登録できない */
    public function test_user_cannot_access_admin_restaurants_store()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->make()->toArray();
        
        $response = $this->actingAs($user)->post(route('admin.restaurants.store'), $restaurant);
        $this->assertDatabaseMissing('restaurants', $restaurant);
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの管理者は店舗を登録できる */
    public function test_admin_can_access_admin_restaurants_store()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->make()->toArray();

        $response = $this->actingAs($admin, 'admin')->post(route('admin.restaurants.store'), $restaurant);
        $this->assertDatabaseHas('restaurants',$restaurant);
        $response->assertRedirect(route('admin.restaurants.show', $restaurant));
    }


    //edit
    /** 未ログインのユーザーは管理者側の店舗編集ページにアクセスできない */
    public function test_guest_cannot_access_admin_restaurants_edit()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->get(route('admin.restaurants.edit', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの一般ユーザーは管理者側の店舗編集ページにアクセスできない */
    public function test_user_cannot_access_admin_restaurants_edit()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.edit', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの管理者は管理者側の店舗編集ページにアクセスできる */
    public function test_admin_can_access_admin_restaurants_edit()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.edit', $restaurant));
        $response->assertStatus(200);
    }


    //update
    /** 未ログインのユーザーは店舗を更新できない */
    public function test_guest_cannot_access_admin_restaurants_update()
    {
        $restaurant = Restaurant::factory()->create();
        $restaurant_update = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 2000,
            'highest_price' => 6000,
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'opening_time' => '10:30:00',
            'closing_time' => '20:30:00',
            'seating_capacity' => 30
        ];

        $response = $this->patch(route('admin.restaurants.update', $restaurant), $restaurant_update);
        $this->assertDatabaseMissing('restaurants', $restaurant_update);
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの一般ユーザーは店舗を更新できない */
    public function test_user_cannot_access_admin_restaurants_update()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();
        $restaurant_update = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 2000,
            'highest_price' => 6000,
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'opening_time' => '10:30:00',
            'closing_time' => '20:30:00',
            'seating_capacity' => 30
        ];

        $response = $this->actingAs($user)->patch(route('admin.restaurants.update', $restaurant), $restaurant_update);
        $this->assertDatabaseMissing('restaurants', $restaurant_update);
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの管理者は店舗を更新できる */
    public function test_admin_can_access_admin_restaurants_update()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();
        $restaurant_update = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 2000,
            'highest_price' => 6000,
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'opening_time' => '10:30:00',
            'closing_time' => '20:30:00',
            'seating_capacity' => 30
        ];

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.restaurants.update', $restaurant), $restaurant_update);
        $this->assertDatabaseHas('restaurants', $restaurant_update);
        $response->assertRedirect(route('admin.restaurants.show', $restaurant));
    }


    //destroy
    /** 未ログインのユーザーは店舗を削除できない */
    public function test_guest_cannot_access_admin_restaurants_destroy()
    {
        $restaurant = Restaurant::factory()->create();
        
        $response = $this->delete(route('admin.restaurants.destroy', $restaurant));
        $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの一般ユーザーは店舗を削除できない */
    public function test_user_cannot_access_admin_restaurants_destroy()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.restaurants.destroy', $restaurant));
        $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);
        $response->assertRedirect(route('admin.login'));
    }

    /** ログイン済みの管理者は店舗を削除できる */
    public function test_admin_can_access_admin_restaurants_destroy()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.restaurants.destroy', $restaurant));
        $this->assertDatabaseMissing('restaurants', ['id' => $restaurant->id]);
        $response->assertRedirect(route('admin.restaurants.index'));
    }
}
