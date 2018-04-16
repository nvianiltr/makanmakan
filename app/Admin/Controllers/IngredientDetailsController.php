<?php

namespace App\Admin\Controllers;

use App\Models\IngredientDetails;
use App\Models\Recipe;
use App\Models\Ingredient;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class IngredientDetailsController extends Controller
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
        return Admin::grid(IngredientDetails::class, function (Grid $grid) {

            $grid->recipe_id('Recipe')->display(function($Recipe){ return 
                User::find($Recipe)->title;});
            $grid->ingredient_id('Ingredient')->display(function($Ingredient){ return 
                User::find($Ingredient)->name;});
            $grid->quantity();
            $grid->unit();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(IngredientDetails::class, function (Form $form) {

            $form->select('Recipe')->options(function($recipe_id){ return Recipe::all()->pluck('title','id');});
            $form->select('Ingredient')->options(function($ingredient_id){ return Ingredient::all()->pluck('name','id');});
            $form->text('quantity');
            $form->text('unit');

        
        });
    }
}
