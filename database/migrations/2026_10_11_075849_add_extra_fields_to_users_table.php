<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nis_nip')) {
                $table->string('nis_nip')->nullable()->after('role');
            }

            if (! Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }

            if (! Schema::hasColumn('users', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable();
            }

            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        if (! Schema::hasIndex('users', ['nis_nip'], 'unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('nis_nip');
            });
        }

        if (! Schema::hasForeignKey('users', ['kelas_id'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('kelas_id')->references('id')->on('kelas')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasForeignKey('users', ['kelas_id'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['kelas_id']);
            });
        }

        if (Schema::hasIndex('users', ['nis_nip'], 'unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['nis_nip']);
            });
        }

        $columns = array_values(array_filter(
            ['nis_nip', 'no_hp', 'kelas_id', 'is_active'],
            fn (string $column): bool => Schema::hasColumn('users', $column),
        ));

        if ($columns !== []) {
            Schema::table('users', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
