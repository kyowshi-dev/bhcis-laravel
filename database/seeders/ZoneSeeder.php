public function run(): void
{
    $zones = [];
    for ($i = 1; $i <= 10; $i++) {
        $zones[] = [
            'id' => $i,
            'zone_number' => (string)$i, // Matches the migration column
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    DB::table('zones')->insert($zones);
}