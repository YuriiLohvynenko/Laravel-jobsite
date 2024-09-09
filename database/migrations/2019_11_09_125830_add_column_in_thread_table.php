<?php

use App\Models\Message;
use App\Models\Thread;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInThreadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->enum('chat_status', ['enable', 'disable'])->default('enable');
        });
        $threads = Thread::all();
        foreach ($threads as $thread){
            $message = Message::where('threads_id', $thread->id)
                ->whereNotNull('listing_id')
                ->first();
            if ($message){
                $thread->listing_id = $message->listing_id;
                $thread->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('listing_id');
            $table->dropColumn('chat_status');
        });
    }
}
