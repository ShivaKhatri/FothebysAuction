<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('artists');//customer
            $table->string('Piece_Title');
            $table->integer('lotNumber')->nullable();//admin
            $table->string('lotReferenceNumber');
            $table->integer('from');
            $table->integer('to')->nullable();
            $table->integer('classification_id');
            $table->integer('auction_id')->nullable();//admin
            $table->integer('category_id');
            $table->string('frontImage');
            $table->string('backImage');
            $table->integer('subCategory_id')->nullable();
            $table->integer('auctioneer_comment')->nullable();
            $table->text('description')->nullable();
            $table->integer('estimated_price_from')->nullable();//admin
            $table->integer('estimated_price_to')->nullable();//admin
            $table->integer('reservePrice')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('authenticated')->nullable();//admin
            $table->string('provenance_details');
            $table->string('customer_agreement');
            $table->integer('expert_id')->nullable();//admin
            $table->string('expert_name')->nullable();//admin
            $table->string('lastNumber')->nullable();//admin
            $table->string('approved')->nullable();//admin
            $table->text('additional_notes')->nullable();//admin
            $table->date('signed_date')->nullable();//admin
            $table->string('sold')->nullable();//admin
            $table->integer('sold_to_id')->nullable();//admin
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
        Schema::dropIfExists('items');
    }
}
