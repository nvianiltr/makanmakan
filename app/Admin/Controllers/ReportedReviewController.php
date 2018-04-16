<?php

namespace App\Admin\Controllers;

use App\Models\ReportedReview;
use App\Models\User;
use App\Models\Review;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ReportedReviewController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(ReportedReview::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->review_id('Review')->display(function($Review){ return 
                Review::find($Review)->content;});
            $grid->user_id('User')->display(function($User){ return 
                User::find($User)->username;});
            $grid->reason();
            $grid->dateReported();

            
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ReportedReview::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('Review')->options(function($review_id){ return Review::all()->pluck('content','id');});
            $form->select('User')->options(function($user_id){ return User::all()->pluck('username','id');});
            $form->text('reason');
            $form->text('dateReported');

        });
    }
}
