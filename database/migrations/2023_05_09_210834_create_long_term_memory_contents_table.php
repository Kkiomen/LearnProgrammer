<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('long_term_memory_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistant_id')->nullable();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->string('type')->nullable()->comment('doc, text');
            $table->string('link')->nullable();
            $table->text('content');
            $table->string('tags')->nullable();
            $table->boolean('sync')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('long_term_memory_contents');
    }
};
