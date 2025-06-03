<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User; // Import User model
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        // Pastikan ada user untuk di-assign, jika tidak buat baru.
        $userId = User::inRandomOrder()->first()?->id ?? User::factory()->create()->id;

        $hasWitness = fake()->randomElement(['yes', 'no']);
        $knowsPerpetrator = fake()->randomElement(['yes', 'no']);

        return [
            'user_id' => $userId,
            'what_happened' => fake()->paragraph(3),
            'where_happened' => fake()->address(),
            'when_happened' => fake()->dateTimeBetween('-1 year', 'now'),
            'reporter_role' => fake()->randomElement(['mahasiswa', 'staff', 'dosen', 'lainnya']),

            'has_witness' => $hasWitness,
            'witness_name' => $hasWitness === 'yes' ? fake()->name() : null,
            'witness_relation' => $hasWitness === 'yes' ? fake()->randomElement(['teman', 'rekan_kerja', 'keluarga', 'tidak_kenal', 'lainnya']) : null,

            'knows_perpetrator' => $knowsPerpetrator,
            'perpetrator_name' => $knowsPerpetrator === 'yes' ? fake()->name() : null,
            'perpetrator_role' => $knowsPerpetrator === 'yes' ? fake()->randomElement(['mahasiswa', 'staff', 'dosen', 'lainnya']) : 'tidak_diketahui',

            'evidence_path' => null, // Bisa diisi dengan path file dummy jika perlu, untuk sekarang null saja
            'agreement' => true,

            // PENTING: Atur status untuk menguji halaman 'unread'
            // Kita buat sebagian besar 'unread' dan sisanya acak
            'status' => fake()->randomElement(['unread', 'unread', 'unread', 'review', 'ongoing', 'solved']),
        ];
    }

    /**
     * State untuk membuat laporan dengan status 'unread' secara spesifik.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'unread',
        ]);
    }

    /**
     * State untuk membuat laporan dengan status 'review'.
     */
    public function review(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'review',
        ]);
    }

    /**
     * State untuk membuat laporan dengan status 'ongoing'.
     */
    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ongoing',
        ]);
    }

    /**
     * State untuk membuat laporan dengan status 'solved'.
     */
    public function solved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'solved',
        ]);
    }

    /**
     * State untuk membuat laporan dengan status 'denied'.
     */
    public function denied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'denied',
        ]);
    }
}
