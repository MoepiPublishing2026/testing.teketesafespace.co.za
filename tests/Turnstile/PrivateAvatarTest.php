<?php

namespace Tests\Turnstile;

use App\Livewire\AdminSettings;
use App\Livewire\DistrictAdminSettings;
use App\Livewire\ProvincialSettings;
use App\Models\User;
use App\Support\AvatarStore;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TurnstileTestCase;

class PrivateAvatarTest extends TurnstileTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        (require database_path('migrations/0001_01_01_000000_create_users_table.php'))->up();
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('district')->nullable();
        });

        Storage::fake('attachments');
        Storage::fake('public');
    }

    public function test_each_staff_settings_component_stores_profile_picture_on_private_disk(): void
    {
        $cases = [
            [AdminSettings::class, 'school', ['name' => 'Staff', 'email' => 'school@example.test', 'Full_name' => 'Staff', 'phone_number' => null]],
            [DistrictAdminSettings::class, 'district', []],
            [ProvincialSettings::class, 'provincial', []],
        ];

        foreach ($cases as [$component, $role, $fields]) {
            $user = $this->user($role, $role.'@example.test');
            $test = Livewire::actingAs($user)->test($component);

            foreach ($fields as $field => $value) {
                $test->set($field, $value);
            }

            $test->set('profile_picture', UploadedFile::fake()->image('staff.png', 40, 40))
                ->call('updateSettings')
                ->assertHasNoErrors();

            $storedPath = (string) $user->fresh()->profile_picture;
            $this->assertMatchesRegularExpression('#^avatars/[0-9a-z]{26}\.png$#', $storedPath);
            $this->assertTrue(Storage::disk('attachments')->exists($storedPath));
            $this->assertSame([], Storage::disk('public')->allFiles());
        }
    }

    public function test_private_avatar_url_requires_the_otp_verified_owner_and_never_exposes_a_public_path(): void
    {
        $owner = $this->user('school', 'owner@example.test');
        $other = $this->user('school', 'other@example.test');
        $path = app(AvatarStore::class)->store(UploadedFile::fake()->image('avatar.png', 40, 40));
        $owner->forceFill(['profile_picture' => $path])->save();
        $this->assertSame($path, $owner->fresh()->profile_picture);
        $this->assertNotNull(app(AvatarStore::class)->locate($path));
        $url = $owner->fresh()->profile_picture_url;

        $this->assertStringStartsWith('/avatars/'.$owner->id.'?v=', $url);
        $this->assertStringNotContainsString('/storage/', $url);

        $response = $this->actingAs($owner)->withSession(['otp_verified' => true])->get($url)
            ->assertOk()
            ->assertHeader('Content-Type', 'image/png')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertStringContainsString('private', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));

        $this->actingAs($other)->withSession(['otp_verified' => true])
            ->get(route('avatars.show', ['user' => $owner->id]))
            ->assertNotFound();

        $this->actingAs($owner)->withSession(['otp_verified' => false])
            ->get(route('avatars.show', ['user' => $owner->id]))
            ->assertRedirect(route('email.verification'));
    }

    public function test_legacy_profile_picture_migration_moves_and_removes_public_copy(): void
    {
        $user = $this->user('school', 'legacy@example.test');
        $directory = storage_path('app/public/profile_pictures');
        File::ensureDirectoryExists($directory);
        $source = $directory.DIRECTORY_SEPARATOR.'legacy.png';
        $upload = UploadedFile::fake()->image('legacy.png', 40, 40);
        File::copy($upload->getRealPath(), $source);
        $user->forceFill(['profile_picture' => 'profile_pictures/legacy.png'])->save();

        $this->artisan('avatars:migrate-legacy')->assertExitCode(0);

        $storedPath = (string) $user->fresh()->profile_picture;
        $this->assertMatchesRegularExpression('#^avatars/[0-9a-z]{26}\.png$#', $storedPath);
        $this->assertTrue(Storage::disk('attachments')->exists($storedPath));
        $this->assertFileDoesNotExist($source);
    }

    private function user(string $role, string $email): User
    {
        return User::create([
            'name' => 'Staff member',
            'email' => $email,
            'password' => 'password',
            'role' => $role,
        ]);
    }
}
