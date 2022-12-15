<?php

namespace App\Http\Controllers;

use App\Models\MailCategory;
use App\Http\Requests\StoreMailCategoryRequest;
use App\Http\Requests\UpdateMailCategoryRequest;

class MailCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMailCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMailCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MailCategory $mailCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MailCategory $mailCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMailCategoryRequest  $request
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMailCategoryRequest $request, MailCategory $mailCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailCategory  $mailCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailCategory $mailCategory)
    {
        //
    }
}
