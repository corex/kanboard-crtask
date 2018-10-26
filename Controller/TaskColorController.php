<?php

namespace Kanboard\Plugin\CRTask\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\CRTask\Helper\Arr;
use Kanboard\Plugin\CRTask\Model\TaskColorModel;

class TaskColorController extends BaseController
{
    /**
     * Show.
     */
    public function show()
    {
        $colors = $this->taskColorModel->getAll();
        $this->response->html($this->helper->layout->config('CRTask:config_task_color/show', array(
            'colors' => $colors,
            'title' => t('Settings') . ' &gt; ' . t('Task color')
        )));
    }

    /**
     * Position
     */
    public function position()
    {
        $values = $this->request->getJson();
        $id = Arr::getInt($values, 'subtask_id');
        $position = Arr::getInt($values, 'position');
        $result = $this->taskColorModel->changePosition($id, $position);
        $this->response->json(array('result' => $result));
    }

    /**
     * Edit.
     */
    public function edit()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(TaskColorModel::TABLE)->eq('id', $id)->findOne();
        if ($values === null) {
            $values = array();
        }
        $this->form($values);
    }

    /**
     * Update.
     */
    public function update()
    {
        $values = $this->request->getValues();

        $id = Arr::getInt($values, 'id');
        $colorId = Arr::get($values, 'color_id');
        $title = trim(Arr::get($values, 'title'));

        // Validate.
        if ($title == '') {
            return $this->form($values, array(
                'title' => array(t('Title is required'))
            ));
        }

        // Update color properties.
        $color = $this->taskColorModel->getById($id);
        if ($color !== null) {
            $color['color_id'] = $colorId;
            $color['title'] = $title;
            $this->flash->success(t('Task color updated'));
        } else {
            $color = [
                'color_id' => $colorId,
                'title' => $title
            ];
            $this->flash->success(t('Task color created'));
        }
        $this->taskColorModel->save($color);

        return $this->response->redirect($this->helper->url->to('TaskColorController', 'show',
            array('plugin' => 'CRTask')
        ));
    }

    /**
     * Confirm.
     */
    public function confirm()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(TaskColorModel::TABLE)->eq('id', $id)->findOne();
        if ($values === null) {
            $values = array();
        }

        $this->response->html($this->template->render('CRTask:config_task_color/remove', array(
            'values' => $values
        )));
    }

    /**
     * Remove.
     */
    public function remove()
    {
        $id = $this->request->getIntegerParam('id');
        $this->taskColorModel->remove($id);
        $this->flash->success('Task color removed');
        $this->response->redirect($this->helper->url->to('TaskColorController', 'show',
            array('plugin' => 'CRTask')));
    }

    /**
     * Form.
     *
     * @param array $values
     * @param array $errors
     */
    private function form(array $values = array(), array $errors = array())
    {
        $id = Arr::getInt($values, 'id');

        // Get colors.
        $currentColorId = null;
        if ($id > 0) {
            $color = $this->taskColorModel->getById($id);
            $currentColorId = $color['color_id'];
        }
        $colors = $this->taskColorModel->getAllOptionsFiltered($currentColorId);

        $this->response->html($this->template->render('CRTask:config_task_color/edit', array(
            'values' => $values,
            'errors' => $errors,
            'colors' => $colors
        )));
    }
}