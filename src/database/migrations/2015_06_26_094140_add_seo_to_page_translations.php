<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeoToPageTranslations extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('cms_page_translations', function (Blueprint $table) {
            $table->string('meta_keywords');
            $table->text('meta_description');
            $table->string('seo_title');
            $table->boolean('include_in_sitemap');
            $table->string('robots_index');
            $table->string('robots_follow');
            $table->string('canonical_url');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('cms_page_translations', function (Blueprint $table) {
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_description');
            $table->dropColumn('seo_title');
            $table->dropColumn('include_in_sitemap');
            $table->dropColumn('robots_index');
            $table->dropColumn('robots_follow');
            $table->dropColumn('canonical_url');
        });
    }
}
