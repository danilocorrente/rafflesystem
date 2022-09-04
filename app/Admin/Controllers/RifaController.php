<?php

namespace App\Admin\Controllers;

use App\Models\Rifa;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RifaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Rifa';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Rifa());

        $grid->column('id', __('Id'));
        $grid->column('nome_da_rifa', __('Nome da rifa'));
        $grid->column('descricao_curta', __('Descricao curta'));
        $grid->column('imagens_sorteio', __('Imagens sorteio'))->carousel($width = 300, $height = 200);
        $grid->column('descricao_completa', __('Descricao completa'));
        $grid->column('status_rifa', __('Status rifa'));
        $grid->column('forma_da_rifa', __('Forma da rifa'));
        $grid->column('fim_de_cotas', __('Fim de cotas'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));

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
        $show = new Show(Rifa::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nome_da_rifa', __('Nome da rifa'));
        $show->field('descricao_curta', __('Descricao curta'));
        $show->field('imagens_sorteio', __('Imagens sorteio'));
        $show->field('descricao_completa', __('Descricao completa'));
        $show->field('status_rifa', __('Status rifa'));
        $show->field('forma_da_rifa', __('Forma da rifa'));
        $show->field('fim_de_cotas', __('Fim de cotas'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Rifa());



        $form->text('nome_da_rifa', __('Nome da rifa'));
        $form->text('descricao_curta', __('Descrição curta'));
        $form->textarea('descricao_completa', __('Descrição completa'));
        if($form->isCreating()){
            $form->select('forma_da_rifa', __('Forma da rifa'))->options(['finalmanual' => 'Finalização Manual', 'finalcomqtdcotas' => 'Finalização com quantidade de cotas']);
            $form->number('fim_de_cotas', __('Limite de cotas Vendida'))->help('Informe apenas quando não for finalização manual');
            $form->currency('valor_da_cota')->symbol('R$');
        } else {
            $form->select('forma_da_rifa', __('Forma da rifa'))->options(['1' => 'a', 2 => '2'])->disable();
            $form->display('fim_de_cotas', __('Limite de cotas Vendida'));
            $form->ignore('forma_da_rifa');
        }

        $form->multipleImage('imagens_sorteio', __('Imagens do sorteio'))->uniqueName()->sortable()->removable()->rules(function ($form) {

            // If it is not an edit state, add field unique verification
            if (!$id = $form->model()->id) {
                return 'required';
            }
        });
        

        

        return $form;
    }
}
