<?php

namespace App\Admin\Controllers;

use App\Models\TagDetails;
use App\Models\Recipe;
use App\Models\TagHeader

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TagDetailsController extends Controller
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
        return Admin::grid(TagDetails::class, function (Grid $grid) {

            $grid->recipe_id('Recipe')->display(function($Recipe){ return 
                User::find($Recipe)->title;});
            $grid->tag_id('Tag')->display(function($TagHeader){ return 
                User::find($Ingredient)->name;});


        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(TagDetails::class, function (Form $form) {

            $form->select('recipe_id','Recipe')->options(function($recipe_id){ return Recipe::all()->pluck('title','id');});
            $form->select('tag_id','Tag')->options(function($tag_id){ return TagHeader::all()->pluck('name','id');});

        });
    }
}
