<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->filter('like');
        $grid->column('cover', __('Cover'))->image();
        $grid->column('parent', __('Parent'))->display(function ($parent) {
            if ($parent !== 0 && $parent !== null) {
                return Category::findOrFail($parent)->name;
            } else {
                return "";
            }
        });

        $states = [
            'on' => ['value' => 'pending', 'text' => 'Publish', 'color' => 'primary'],
            'off' => ['value' => 'publish', 'text' => 'Pending', 'color' => 'default'],
        ];
        $grid->column('status', __('Status'))->switch($states);

        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });
        $grid->quickSearch('name');
        $grid->filter(function ($filter) {

            // $filter->date('updated_at', 'Lọc theo ngày tháng');
            $filter->between('updated_at', 'Lọc theo ngày tháng')->datetime();
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('cover', __('Cover'));
        $show->field('parent', __('Parent'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->text('name', __('Name'));
        $form->hidden('slug', __('Slug'));
        $form->cropper('cover', __('Cover'));
        $form->select('parent', __('Parent'))->options(function ($par_id) {
            $categories = Category::where('status', 1)->get()->pluck('name', 'id');
            return $categories;
        });
        $states = [
            'on' => ['value' => 'pending', 'text' => 'Pending', 'color' => 'success'],
            'off' => ['value' => 'publish', 'text' => 'Publish', 'color' => 'danger'],
        ];
        $form->switch('status', __('Status'))->states($states);
        $form->saving(function (Form $form) {
            $form->slug = Str::slug($form->name, "-");
        });

        $form->saved(function (Form $form) {
            $category = Category::find($form->model()->id);
            $this->checkFolderContent();
            $this->exportToJson($category);
            $this->exportCategories();
        });
        return $form;
    }

    public function checkFolderContent()
    {
        if (!file_exists(public_path() . '/content/')) {
            mkdir(public_path() . '/content/', 0777);
        }
        if (!file_exists(public_path() . '/content/categories/')) {
            mkdir(public_path() . '/content/categories/', 0777);
        }
    }

    public function exportToJson($category)
    {
        $data = $category->toArray();
        // $data['posts'] = $category->posts()->where('status', 1)->select('id', 'title', 'slug', 'summary', 'feature_image', 'updated_at')->orderBy('id', 'desc')->limit(12)->get()->toArray();
        file_put_contents(public_path() . '/content/categories/' . $category->slug . '.json', json_encode($data));
    }

    public function exportCategories()
    {
        $allCats = Category::where('status', 'publish')->get();
        $allCatsData = [];
        foreach ($allCats as $cat) {
            $catData = $cat->toArray();
            $catData['posts'] = $cat->posts()->count();
            array_push($allCatsData, $catData);
        }
        file_put_contents(public_path() . '/content/categories.json', json_encode($allCatsData));
    }
}
