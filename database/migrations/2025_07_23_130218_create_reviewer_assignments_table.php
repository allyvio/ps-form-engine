<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewerAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewer_assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('reviewee_id'); // Peserta yang dinilai
            $table->string('reviewee_name');
            $table->integer('reviewer_id')->nullable(); // Peserta yang menilai (nullable untuk external reviewers)
            $table->string('reviewer_name');
            $table->enum('reviewer_role', [
                'Atasan Langsung',
                'Diri Sendiri', 
                'Rekan Kerja 1',
                'Rekan Kerja 2',
                'Bawahan Langsung 1',
                'Bawahan Langsung 2'
            ]);
            $table->integer('assessment_count')->default(0); // Jumlah assessment
            $table->timestamps();
            
            // Indexes
            $table->index('reviewee_id');
            $table->index('reviewer_id');
            $table->index('reviewer_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviewer_assignments');
    }
}
