<?php

namespace Kanboard\Plugin\CRProject\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\CRProject\Helper\Arr;
use Kanboard\Plugin\CRProject\Model\ProjectPlatformModel;

class ConfigPlatformController extends BaseController
{
    /**
     * Show.
     */
    public function show()
    {
        $platforms = $this->projectPlatformModel->getAll();
        $this->response->html($this->helper->layout->config('CRProject:config_platform/show', array(
            'platforms' => $platforms,
            'title' => t('Platforms') . ' &gt; ' . t('Project platform')
        )));
    }

    /**
     * Position
     */

    /**
     * Edit.
     */
    public function edit()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(ProjectPlatformModel::TABLE)->eq('id', $id)->findOne();
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

        // Validate.
        $title = trim(Arr::get($values, 'title'));
        if ($title == '') {
            return $this->form($values, array(
                'title' => array(t('Title is required'))
            ));
        }

        $colorId = trim(Arr::get($values, 'color_id'));
        if ($colorId == '') {
            return $this->form($values, array(
                'color_id' => array(t('You need to choose color'))
            ));
        }

        $this->projectPlatformModel->save($values);

        if ($id > 0) {
            $this->flash->success(t('Platform updated'));
        } else {
            $this->flash->success(t('Platform created'));
        }
        return $this->response->redirect($this->helper->url->to(
            'ConfigPlatformController',
            'show',
            array('plugin' => 'CRProject')
        ));
    }

    /**
     * Confirm.
     */
    public function confirm()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(ProjectPlatformModel::TABLE)->eq('id', $id)->findOne();
        if ($values === null) {
            $values = array();
        }

        $this->response->html($this->template->render('CRProject:config_platform/remove', array(
            'values' => $values
        )));
    }

    /**
     * Remove.
     */
    public function remove()
    {
        $id = $this->request->getIntegerParam('id');
        if ($this->projectHasStatusModel->platformInUse($id)) {
            $this->flash->failure(t('Platform in use. Can not remove.'));
        } else {
            $this->projectPlatformModel->remove($id);
            $this->flash->success('Platform removed');
        }
        $this->response->redirect($this->helper->url->to(
            'ConfigPlatformController',
            'show',
            array('plugin' => 'CRProject')
        ));
    }

    /**
     * Form.
     *
     * @param array $values
     * @param array $errors
     */
    private function form(array $values = array(), array $errors = array())
    {
        $colors = $this->colorModel->getList();
        $colors = array_merge(array('' => t('None')), $colors);
        $this->response->html($this->template->render('CRProject:config_platform/edit', array(
            'values' => $values,
            'errors' => $errors,
            'colors' => $colors
        )));
    }
}