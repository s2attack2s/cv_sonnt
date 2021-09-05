<?php
// Challenges
Schema::create('Challenges', function (Blueprint $table) {
        $table->integer('id')->primary();                                  
        $table->string('fullname', 50);       
        $table->string('email', 255);   
        $table->string('phone', 20);          
        $table->string('company', 100);       
        $table->string('industry', 100);  
        $table->string('content')->nullable();  

        $table->string('created_by',10)->nullable();        
        $table->string('updated_by',10)->nullable();          
        $table->dateTime('deleted_at')->nullable();          
        $table->string('deleted_by', 10)->nullable();         
        $table->timestamps();
});

// Slides
Schema::create('Slides', function (Blueprint $table) {
    $table->integer('id');                                  
    $table->string('lang', 5);     
    $table->string('img', 255);          
    $table->string('link', 255);          
    $table->string('text', 255);       
    $table->boolean('show', 1);  

    $table->string('created_by',10)->nullable();        
    $table->string('updated_by',10)->nullable();          
    $table->dateTime('deleted_at')->nullable();          
    $table->string('deleted_by', 10)->nullable();         
    $table->timestamps();
    $table->primary(array('id', 'lang'));

// Process
Schema::create('Process', function (Blueprint $table) {
    $table->integer('id');                                  
    $table->string('lang', 5);     
    $table->string('title', 50);          
    $table->string('description');          
    $table->string('content');       
    $table->integer('order');       
    $table->boolean('show', 1);  

    $table->string('created_by',10)->nullable();        
    $table->string('updated_by',10)->nullable();          
    $table->dateTime('deleted_at')->nullable();          
    $table->string('deleted_by', 10)->nullable();         
    $table->timestamps();
    $table->primary(array('id', 'lang'));

// Stories
Schema::create('Stories', function (Blueprint $table) {
    $table->integer('id');                                  
    $table->string('lang', 5);     
    $table->string('title', 50);          
    $table->string('description',200);          
    $table->string('logo',255);       
    $table->string('url',255); 
    $table->integer('order');        
    $table->boolean('show', 1);  

    $table->string('created_by',10)->nullable();        
    $table->string('updated_by',10)->nullable();          
    $table->dateTime('deleted_at')->nullable();          
    $table->string('deleted_by', 10)->nullable();         
    $table->timestamps();
    $table->primary(array('id', 'lang'));

// Settings
Schema::create('Settings', function (Blueprint $table) {
    $table->integer('id');                                  
    $table->string('lang', 5);     
    $table->string('facebook', 50);          
    $table->string('google_plus',200);          
    $table->string('skype',255);       
    $table->string('ameblo',255); 
    $table->integer('about_us');        
    $table->boolean('stories', 1);  
    $table->boolean('stories', 1);  
    $table->boolean('stories', 1);  

    $table->string('created_by',10)->nullable();        
    $table->string('updated_by',10)->nullable();          
    $table->dateTime('deleted_at')->nullable();          
    $table->string('deleted_by', 10)->nullable();         
    $table->timestamps();
    $table->primary(array('id', 'lang'));


facebook	nnvarchar	kiểu chữ	255
google_plus	nnvarchar	kiểu chữ	255
skype	nnvarchar	kiểu chữ	255
ameblo	nnvarchar	kiểu chữ	255
about_us	mediumtext	kiểu chữ	
stories	mediumtext	kiểu chữ	
process	mediumtext	kiểu chữ	
about_us_img	nnvarchar	kiểu chữ	255
description	nnvarchar	kiểu chữ	500
keyword	nnvarchar	kiểu chữ	100
author	nnvarchar	kiểu chữ	100
phone	nnvarchar	kiểu chữ	20
address	nnvarchar	kiểu chữ	200
email	nnvarchar	kiểu chữ	255
icon	nnvarchar	kiểu chữ	255
created_at	datetime2	time	19
created_by	nnvarchar	kiểu chữ	10
updated_at	datetime2	time	19
updated_by	nnvarchar	kiểu chữ	10
deleted_at	datetime2	time	19
deleted_by	nnvarchar	kiểu chữ	10
