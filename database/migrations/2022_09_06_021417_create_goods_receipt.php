<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receipt', function (Blueprint $table) {
            $table->bigIncrements('id_gr');
            $table->bigInteger('id_inv')->unsigned()->nullable();
            // $table->foreign('id_inv')->references('id_inv')->on('invoice');
            $table->bigInteger('id_vendor')->unsigned()->nullable();
            // $table->foreign('id_vendor')->references('id_vendor')->on('vendor');
            $table->string('vendor_name')->nullable();
            $table->string('no_po');
            $table->integer('po_item');
            $table->date('gr_date');
            $table->string('delivery_note');
            $table->string('doc_header_text')->nullable();
            $table->string('material_number');
            $table->string('vendor_part_number')->nullable();
            $table->string('mat_desc')->nullable();
            $table->string('valuation_type')->nullable();
            $table->string('gr_number');
            $table->string('uom')->nullable();
            $table->string('currency');
            $table->string('plant_code')->nullable();
            $table->string('harga_satuan');
            $table->integer('jumlah');
            $table->string('jumlah_harga')->nullable();
            $table->string('total_harga');
            $table->string('tax_code')->nullable();
            $table->string('alasan_disp')->nullable();
            $table->string('alasan_reject')->nullable();
            $table->enum('status',['Auto Verify','Verified','Not Verified', 'Rejected', 'Disputed'])->nullable();
            $table->enum('status_invoice',['Not Yet Verified - Draft BA', 'Verified - BA', 'Reject'])->default("Not Yet Verified - Draft BA")->nullable();
            $table->string('mat_doc_it')->nullable();
            $table->string('year')->nullable();
            $table->string('comp_code')->nullable();
            $table->string('ref_doc_no');
            $table->float('total_ppn')->nullable();
            $table->text('lampiran')->nullable();
            $table->text('lam_disp')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_receipt');
    }
}
