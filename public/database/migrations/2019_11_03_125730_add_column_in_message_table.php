<?php

use App\Models\Message;
use App\Models\Thread;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('threads_id')->nullable()->default(null);
            $table->foreign('threads_id')->references('id')->on('threads')->onDelete('cascade')->onUpdate('cascade');
        });
        $messages = Message::all();
        foreach ($messages as $message){
            $thread = Thread::where(function($query) use ($message){
                $query->where('user_id', $message->user_id)
                    ->where('to_user', $message->to_user)
                    ->orWhere(function($q) use ($message) {
                        $q->where('to_user', $message->user_id)
                            ->where('user_id', $message->to_user);
                    });
            })
                ->first();
            if ($thread){
                $message->threads_id = $thread->id;
                $message->save();
            }
            else{
                $thread = new Thread();
                $thread->user_id = $message->user_id;
                $thread->to_user = $message->to_user;
                $thread->save();
                $message->threads_id = $thread->id;
                $message->save();
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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_threads_id_foreign');
            $table->dropColumn('threads_id');
        });
    }
}
