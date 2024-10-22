<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** 未ログインのユーザーは管理者側の会員一覧ページにアクセスできない */
    public function test_guest_user_cannot_access_admin_users_index()
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/login');
    }

    /** ログイン済みの一般ユーザーは管理者側の会員一覧ページにアクセスできない */
    public function test_non_admin_user_cannot_access_admin_users_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertStatus(403);
    }

    /** ログイン済みの管理者は管理者側の会員一覧ページにアクセスできる */
    public function test_admin_user_can_access_admin_users_index()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    
    /** 未ログインのユーザーは管理者側の会員詳細ページにアクセスできない */
    public function test_guest_user_cannot_access_admin_user_show()
    {
        // ID 195のユーザー詳細ページにアクセスする想定
        $response = $this->get('/admin/users/195');
        $response->assertRedirect('/login');
    }

    /** テスト: ログイン済みの一般ユーザーは管理者側の会員詳細ページにアクセスできない */
    public function test_non_admin_user_cannot_access_admin_user_show()
    {
        $user = User::factory()->create();

        // ID 195のユーザー詳細ページにアクセスする想定
        $response = $this->actingAs($user)->get('/admin/users/195');
        $response->assertStatus(403);
    }

    /** テスト: ログイン済みの管理者は管理者側の会員詳細ページにアクセスできる */
    public function test_admin_user_can_access_admin_user_show()
    {
        $admin = User::factory()->admin()->create();

        // ID 195のユーザー詳細ページにアクセスする想定
        $response = $this->actingAs($admin)->get('/admin/users/195');
        $response->assertStatus(200);
    }
}
