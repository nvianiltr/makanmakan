<?php

namespace App\Admin\Controllers;

use App\Models\Review;
use App\Models\Recipe;
use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ReviewController extends Controller
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
        return Admin::grid(Review::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->recipe_id('Recipe')->display(function($Recipe){ return 
                User::find($Recipe)->title;});
            $grid->user_id('User')->display(function($User){ return 
                User::find($User)->username;});
            $grid->content();
            $grid->datePosted();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Review::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('recipe_id','Recipe')->options(function($recipe_id){ return Recipe::all()->pluck('title','id');});
            $form->select('user_id','User')->options(function($user_id){ return User::all()->pluck('username','id');});
            $form->text('content');
            $form->text('datePosted');
        });
    }
}
