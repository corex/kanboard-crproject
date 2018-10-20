<?php

namespace Kanboard\Plugin\CRProject\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\CRProject\Helper\Arr;
use Kanboard\Plugin\CRProject\Model\ConfigTaskColorModel;

class ConfigTaskColorController extends BaseController
{
    /**
     * Show.
     */
    public function show()
    {
        $colors = $this->configTaskColorModel->getAll();
        $this->response->html($this->helper->layout->config('CRProject:config_task_color/show', array(
            'colors' => $colors,
            'title' => t('Settings') . ' &gt; ' . t('Project task color')
        )));
    }

    /**
     * Visibility.
     */
    public function visibility()
    {
        $colorId = $this->request->getStringParam('color_id', null);
        $isVisible = $this->request->getIntegerParam('isVisible');
        $this->configTaskColorModel->setVisibility($colorId, $isVisible);
        return $this->response->redirect($this->helper->url->to('ConfigTaskColorController', 'show',
            array('plugin' => 'CRProject')));
    }

    /**
     * Position
     */
    public function position()
    {
        $values = $this->request->getJson();
        $id = Arr::getInt($values, 'subtask_id');
        $position = Arr::getInt($values, 'position');
        $result = $this->configTaskColorModel->changePosition($id, $position);
        $this->response->json(array('result' => $result));
    }

    /**
     * Edit.
     */
    public function edit()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(ConfigTaskColorModel::TABLE)->eq('id', $id)->findOne();
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
        $color = $this->configTaskColorModel->getById($id);
        if ($color !== null) {
            $color['title'] = $title;
            $this->flash->success(t('Task color updated'));
        } else {
            $color = [
                'color_id' => $colorId,
                'title' => $title
            ];
            $this->flash->success(t('Task color created'));
        }
        $this->configTaskColorModel->save($color);

        return $this->response->redirect($this->helper->url->to('ConfigTaskColorController', 'show',
            array('plugin' => 'CRProject')));
    }

    /**
     * Confirm.
     */
    public function confirm()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(ConfigTaskColorModel::TABLE)->eq('id', $id)->findOne();
        if ($values === null) {
            $values = array();
        }

        $this->response->html($this->template->render('CRProject:config_task_color/remove', array(
            'values' => $values
        )));
    }

    /**
     * Remove.
     */
    public function remove()
    {
        $id = $this->request->getIntegerParam('id');
        $this->configTaskColorModel->remove($id);
        $this->flash->success('Task color removed');
        $this->response->redirect($this->helper->url->to('ConfigTaskColorController', 'show',
            array('plugin' => 'CRProject')));
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
        if ($id > 0) {
            $colors = $this->colorModel->getList();
        } else {
            $colors = $this->configTaskColorModel->getAllOptionsFiltered();
        }
        $this->response->html($this->template->render('CRProject:config_task_color/edit', array(
            'values' => $values,
            'errors' => $errors,
            'colors' => $colors
        )));
    }
}