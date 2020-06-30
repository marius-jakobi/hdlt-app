<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThumbnailToShippingAddressUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_address_upload_files', function (Blueprint $table) {
            $table->renameColumn('path', 'fileId');
            $table->string('extension', 4)->after('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_address_upload_files', function (Blueprint $table) {
            $table->renameColumn('fileId', 'path');
            $table->dropColumn('extension');
        });
    }
}
