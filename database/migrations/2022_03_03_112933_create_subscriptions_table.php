<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('amount');
            $table->unsignedBigInteger('price_setting_id')->nullable();
            $table->foreign('price_setting_id')->references('id')->on('price_settings')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->tinyInteger('payment_type')->nullable()->comment('1-creatit card,2-debit card');
            $table->tinyInteger('payment_status')->default(0);
            $table->string('transection_id');
            $table->softDeletes();
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
        Schema::dropIfExists('subscriptions');
    }
}
