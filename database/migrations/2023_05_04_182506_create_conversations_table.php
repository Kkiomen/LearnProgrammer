<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Class\Conversation\Enum\ConversationStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('assistant_id')->nullable();
            $table->unsignedInteger('consultant_id')->nullable();
            $table->string('session_hash')->nullable();
            $table->text('title')->nullable();
            $table->boolean('active')->default(false);
            $table->enum('status', ConversationStatus::toArray())->default(ConversationStatus::ASSISTANT);
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
        Schema::dropIfExists('conversations');
    }
};
