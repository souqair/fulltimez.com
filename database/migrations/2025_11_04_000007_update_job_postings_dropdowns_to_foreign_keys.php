<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add foreign key columns
        Schema::table('job_postings', function (Blueprint $table) {
            $table->foreignId('experience_level_id')->nullable()->after('employment_type_id')->constrained('experience_levels')->onDelete('set null');
            $table->foreignId('experience_year_id')->nullable()->after('experience_level')->constrained('experience_years')->onDelete('set null');
            $table->foreignId('education_level_id')->nullable()->after('experience_years')->constrained('education_levels')->onDelete('set null');
            $table->foreignId('salary_currency_id')->nullable()->after('salary_max')->constrained('salary_currencies')->onDelete('set null');
            $table->foreignId('salary_period_id')->nullable()->after('salary_currency')->constrained('salary_periods')->onDelete('set null');
        });

        // Migrate experience_level data
        $experienceLevels = [
            'entry' => 'Entry Level',
            'mid' => 'Mid Level',
            'senior' => 'Senior Level',
            'executive' => 'Executive Level',
        ];

        foreach ($experienceLevels as $slug => $name) {
            $level = DB::table('experience_levels')->where('slug', $slug)->first();
            if (!$level) {
                $levelId = DB::table('experience_levels')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $level = (object)['id' => $levelId];
            }
            
            if ($level) {
                DB::table('job_postings')
                    ->where('experience_level', $slug)
                    ->update(['experience_level_id' => $level->id]);
            }
        }

        // Migrate experience_years data
        $experienceYears = [];
        for ($i = 1; $i <= 10; $i++) {
            $name = $i === 1 ? '1 Year' : $i . ' Years';
            $value = $name;
            $year = DB::table('experience_years')->where('value', $value)->first();
            if (!$year) {
                $yearId = DB::table('experience_years')->insertGetId([
                    'name' => $name,
                    'value' => $value,
                    'sort_order' => $i,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $year = (object)['id' => $yearId];
            }
            $experienceYears[$value] = $year->id;
        }

        // Update job_postings with experience_year_id
        foreach ($experienceYears as $value => $id) {
            DB::table('job_postings')
                ->where('experience_years', $value)
                ->update(['experience_year_id' => $id]);
        }

        // Migrate education_level data
        $educationLevels = [
            'Phd' => 'PhD',
            'Master' => 'Master',
            'Bachelor' => 'Bachelor',
            'Higher Secondary' => 'Higher Secondary',
            'Primary' => 'Primary',
            'Diploma' => 'Diploma',
            'Not Required' => 'Not Required',
        ];

        foreach ($educationLevels as $name => $displayName) {
            $slug = \Illuminate\Support\Str::slug($name);
            $level = DB::table('education_levels')->where('slug', $slug)->first();
            if (!$level) {
                $levelId = DB::table('education_levels')->insertGetId([
                    'name' => $displayName,
                    'slug' => $slug,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $level = (object)['id' => $levelId];
            }
            
            if ($level) {
                DB::table('job_postings')
                    ->where('education_level', $name)
                    ->orWhere('education_level', $displayName)
                    ->update(['education_level_id' => $level->id]);
            }
        }

        // Migrate salary_currency data
        $currencies = [
            'AED' => ['name' => 'UAE Dirham', 'symbol' => 'د.إ'],
            'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
            'EUR' => ['name' => 'Euro', 'symbol' => '€'],
            'GBP' => ['name' => 'British Pound', 'symbol' => '£'],
        ];

        foreach ($currencies as $code => $data) {
            $currency = DB::table('salary_currencies')->where('code', $code)->first();
            if (!$currency) {
                $currencyId = DB::table('salary_currencies')->insertGetId([
                    'code' => $code,
                    'name' => $data['name'],
                    'symbol' => $data['symbol'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $currency = (object)['id' => $currencyId];
            }
            
            if ($currency) {
                DB::table('job_postings')
                    ->where('salary_currency', $code)
                    ->update(['salary_currency_id' => $currency->id]);
            }
        }

        // Migrate salary_period data
        $periods = [
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'weekly' => 'Weekly',
            'hourly' => 'Hourly',
        ];

        foreach ($periods as $slug => $name) {
            $period = DB::table('salary_periods')->where('slug', $slug)->first();
            if (!$period) {
                $periodId = DB::table('salary_periods')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $period = (object)['id' => $periodId];
            }
            
            if ($period) {
                DB::table('job_postings')
                    ->where('salary_period', $slug)
                    ->orWhere('salary_period', strtolower($name))
                    ->update(['salary_period_id' => $period->id]);
            }
        }

        // Drop old columns
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn('experience_level');
            $table->dropColumn('experience_years');
            $table->dropColumn('education_level');
            $table->dropColumn('salary_currency');
            $table->dropColumn('salary_period');
        });
    }

    public function down(): void
    {
        // Add back old columns
        Schema::table('job_postings', function (Blueprint $table) {
            $table->enum('experience_level', ['entry', 'mid', 'senior', 'executive'])->default('entry')->after('employment_type_id');
            $table->string('experience_years')->nullable()->after('experience_level');
            $table->string('education_level')->nullable()->after('experience_years');
            $table->string('salary_currency', 3)->default('USD')->after('salary_max');
            $table->string('salary_period')->default('monthly')->after('salary_currency');
        });

        // Migrate data back
        $levels = DB::table('experience_levels')->get();
        foreach ($levels as $level) {
            DB::table('job_postings')
                ->where('experience_level_id', $level->id)
                ->update(['experience_level' => $level->slug]);
        }

        $years = DB::table('experience_years')->get();
        foreach ($years as $year) {
            DB::table('job_postings')
                ->where('experience_year_id', $year->id)
                ->update(['experience_years' => $year->value]);
        }

        $educations = DB::table('education_levels')->get();
        foreach ($educations as $edu) {
            DB::table('job_postings')
                ->where('education_level_id', $edu->id)
                ->update(['education_level' => $edu->name]);
        }

        $currencies = DB::table('salary_currencies')->get();
        foreach ($currencies as $currency) {
            DB::table('job_postings')
                ->where('salary_currency_id', $currency->id)
                ->update(['salary_currency' => $currency->code]);
        }

        $periods = DB::table('salary_periods')->get();
        foreach ($periods as $period) {
            DB::table('job_postings')
                ->where('salary_period_id', $period->id)
                ->update(['salary_period' => $period->slug]);
        }

        // Drop foreign key columns
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropForeign(['experience_level_id']);
            $table->dropForeign(['experience_year_id']);
            $table->dropForeign(['education_level_id']);
            $table->dropForeign(['salary_currency_id']);
            $table->dropForeign(['salary_period_id']);
            $table->dropColumn(['experience_level_id', 'experience_year_id', 'education_level_id', 'salary_currency_id', 'salary_period_id']);
        });
    }
};

