<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\SecureStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_profile_photo_and_view_it(): void
    {
        Storage::fake(SecureStorage::DISK);

        $user = User::factory()->create(['photo' => null]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'photo' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
        ]);

        $response->assertRedirect(route('profile.edit'));

        $user->refresh();
        $this->assertTrue($user->hasProfilePhoto());
        Storage::disk(SecureStorage::DISK)->assertExists($user->photo);

        $photoResponse = $this->actingAs($user)->get(route('secure.photos.show', $user));
        $photoResponse->assertOk();
    }

    public function test_profile_photo_url_falls_back_when_file_missing(): void
    {
        $user = User::factory()->create([
            'photo' => 'profile_photos/missing.jpg',
            'name' => 'Budi Santoso',
        ]);

        $this->assertFalse($user->hasProfilePhoto());
        $this->assertStringContainsString('ui-avatars.com', $user->profilePhotoUrl());
    }
}
