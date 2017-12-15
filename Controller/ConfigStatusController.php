<?php

namespace Kanboard\Plugin\CRProject\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\CRProject\Helper\Arr;
use Kanboard\Plugin\CRProject\Model\ProjectStatusModel;

class ConfigStatusController extends BaseController
{
    /**
     * Show.
     */
    public function show()
    {
        $statusIdsInUse = $this->projectHasStatusModel->getAllStatusIdsInUse();
        $statuses = $this->projectStatusModel->getAll();
        $this->response->html($this->helper->layout->config('CRProject:config_status/show', array(
            'statuses' => $statuses,
            'statusIdsInUse' => $statusIdsInUse,
            'title' => t('Settings') . ' &gt; ' . t('Project status')
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
        $result = $this->projectStatusModel->changePosition($id, $position);
        $this->response->json(array('result' => $result));
    }

    /**
     * Edit.
     */
    public function edit()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(ProjectStatusModel::TABLE)->eq('id', $id)->findOne();
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

        $this->projectStatusModel->save($values);

        if ($id > 0) {
            $this->flash->success(t('Status updated'));
        } else {
            $this->flash->success(t('Status created'));
        }
        return $this->response->redirect($this->helper->url->to('ConfigStatusController', 'show',
            array('plugin' => 'CRProject')));
    }

    /**
     * Confirm.
     */
    public function confirm()
    {
        $id = $this->request->getIntegerParam('id');
        $values = $this->db->table(ProjectStatusModel::TABLE)->eq('id', $id)->findOne();
        if ($values === null) {
            $values = array();
        }

        $this->response->html($this->template->render('CRProject:config_status/remove', array(
            'values' => $values
        )));
    }

    /**
     * Set default.
     */
    public function setDefault()
    {
        $id = $this->request->getIntegerParam('id');
        $isDefault = $this->request->getIntegerParam('is_default');
        $this->projectStatusModel->setDefault($id, $isDefault);
        return $this->response->redirect($this->helper->url->to('ConfigStatusController', 'show',
            array('plugin' => 'CRProject')));
    }

    /**
     * Remove.
     */
    public function remove()
    {
        $id = $this->request->getIntegerParam('id');
        if ($this->projectHasStatusModel->inUse($id)) {
            $this->flash->failure(t('Status in use. Can not remove.'));
        } else {
            $this->projectStatusModel->remove($id);
            $this->flash->success('Status removed');
        }
        $this->response->redirect($this->helper->url->to('ConfigStatusController', 'show',
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
        $colors = $this->colorModel->getList();
        $colors = array_merge(array('' => t('None')), $colors);
        $this->response->html($this->template->render('CRProject:config_status/edit', array(
            'values' => $values,
            'errors' => $errors,
            'colors' => $colors
        )));
    }
}