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
            $table->string('nameArtist');
            $table->string('Piece_Title');
            $table->integer('lotNumber');
            $table->integer('year');
            $table->integer('classification_id');
            $table->integer('category_id');
            $table->text('description')->nullable();
            $table->date('auction_date');
            $table->integer('estimated_price_from');
            $table->integer('estimated_price_to');
            $table->integer('reserved_price')->nullable();
            $table->integer('client_id')->nullable();
            $table->tinyInteger('authenticated');
            $table->string('provenance_details');
            $table->string('customer_agreement');
            $table->integer('expert_id')->nullable();
            $table->text('additional_notes')->nullable();
            $table->date('signed_date')->nullable();
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
