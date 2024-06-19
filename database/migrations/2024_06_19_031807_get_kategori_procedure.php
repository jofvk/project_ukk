<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            -- Drop the view if it exists
            DROP VIEW IF EXISTS vKategori;
            
            -- Create or replace the view vKategori
            CREATE OR REPLACE VIEW vKategori AS
            SELECT 
              id, 
              deskripsi, 
              getKategori(kategori) AS kat
            FROM kategori;
            
            -- Drop the procedure if it exists
            DROP PROCEDURE IF EXISTS getKategoriById;
            
            -- Create the stored procedure getKategoriById
            CREATE PROCEDURE getKategoriById(
              IN _id TINYINT
            )
            BEGIN
              SELECT id, deskripsi, kat 
              FROM vKategori
              WHERE id LIKE CONCAT(\'%\', _id, \'%\');
            END;
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('           
             -- Drop the procedure if it exists
            DROP PROCEDURE IF EXISTS getKategoriById;');
    }
};
