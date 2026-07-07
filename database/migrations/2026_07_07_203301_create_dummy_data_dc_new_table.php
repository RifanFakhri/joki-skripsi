<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dummy_data_dc_new', function (Blueprint $table) {
            $table->string('NM_SERVIS', 12)->nullable();
            $table->string('NO_CTR', 11)->nullable();
            $table->string('VOYAGE_NO', 17)->nullable();
            $table->string('NM_KAPAL', 17)->nullable();
            $table->string('VOYAGE_NO_PLG', 16)->nullable();
            $table->string('NM_AGEN', 44)->nullable();
            $table->integer('SIZE_CTR')->nullable();
            $table->string('TIPE_CTR', 3)->nullable();
            $table->string('STATUS_VALUE', 11)->nullable();
            $table->integer('BERAT_CTR')->nullable();
            $table->string('POL-POD', 11)->default('IDJKT-IDSBY')->nullable();
            $table->string('POL', 5)->nullable();
            $table->string('POD', 5)->nullable();
            $table->string('Depo_Tujuan', 20)->nullable();
            $table->string('Nopol', 9)->nullable();
            $table->string('No_Lambung', 20)->nullable();
            $table->string('Keterangan', 100)->nullable();
            $table->dateTime('TGL_GTI')->nullable();
            $table->string('alat', 50)->nullable();
            $table->string('operator', 50)->nullable();
            $table->string('STATUS_GATEOUT', 10)->nullable();
        });

        // Trigger check_no_lambung
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::unprepared("
                CREATE TRIGGER `trg_check_no_lambung` BEFORE UPDATE ON `dummy_data_dc_new` FOR EACH ROW BEGIN
                    -- GUHI MAS → harus G
                    IF NEW.NM_KAPAL LIKE '%GUHI MAS%' AND (NEW.No_Lambung IS NOT NULL AND NEW.No_Lambung NOT REGEXP '^G[0-9]+$') THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'No_Lambung untuk GUHI MAS harus diawali G';
                    END IF;

                    -- TANTO → harus T
                    IF NEW.NM_KAPAL LIKE '%TANTO%' AND (NEW.No_Lambung IS NOT NULL AND NEW.No_Lambung NOT REGEXP '^T[0-9]+$') THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'No_Lambung untuk TANTO harus diawali T';
                    END IF;

                    -- MERATUS → harus M
                    IF NEW.NM_KAPAL LIKE '%MERATUS%' AND (NEW.No_Lambung IS NOT NULL AND NEW.No_Lambung NOT REGEXP '^M[0-9]+$') THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'No_Lambung untuk MERATUS harus diawali M';
                    END IF;
                END
            ");
        } elseif ($driver === 'pgsql') {
            DB::unprepared("
                CREATE OR REPLACE FUNCTION check_no_lambung()
                RETURNS TRIGGER AS $$
                BEGIN
                    -- GUHI MAS -> harus G
                    IF NEW.\"NM_KAPAL\" LIKE '%GUHI MAS%' AND (NEW.\"No_Lambung\" IS NOT NULL AND NEW.\"No_Lambung\" !~ '^G[0-9]+$') THEN
                        RAISE EXCEPTION 'No_Lambung untuk GUHI MAS harus diawali G';
                    END IF;

                    -- TANTO -> harus T
                    IF NEW.\"NM_KAPAL\" LIKE '%TANTO%' AND (NEW.\"No_Lambung\" IS NOT NULL AND NEW.\"No_Lambung\" !~ '^T[0-9]+$') THEN
                        RAISE EXCEPTION 'No_Lambung untuk TANTO harus diawali T';
                    END IF;

                    -- MERATUS -> harus M
                    IF NEW.\"NM_KAPAL\" LIKE '%MERATUS%' AND (NEW.\"No_Lambung\" IS NOT NULL AND NEW.\"No_Lambung\" !~ '^M[0-9]+$') THEN
                        RAISE EXCEPTION 'No_Lambung untuk MERATUS harus diawali M';
                    END IF;

                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;

                CREATE TRIGGER trg_check_no_lambung
                BEFORE UPDATE ON dummy_data_dc_new
                FOR EACH ROW
                EXECUTE FUNCTION check_no_lambung();
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::unprepared("DROP TRIGGER IF EXISTS `trg_check_no_lambung`");
        } elseif ($driver === 'pgsql') {
            DB::unprepared("DROP TRIGGER IF EXISTS trg_check_no_lambung ON dummy_data_dc_new");
            DB::unprepared("DROP FUNCTION IF EXISTS check_no_lambung()");
        }

        Schema::dropIfExists('dummy_data_dc_new');
    }
};
