use Illuminate\Support\Facades\DB;

public function up()
{
    DB::statement("
        ALTER TABLE absensis
        MODIFY status ENUM(
            'Hadir',
            'Terlambat',
            'Izin',
            'Sakit',
            'Alpha'
        ) DEFAULT 'Hadir'
    ");
}

public function down()
{
    DB::statement("
        ALTER TABLE absensis
        MODIFY status ENUM(
            'Hadir',
            'Izin',
            'Sakit',
            'Alpha'
        ) DEFAULT 'Hadir'
    ");
}