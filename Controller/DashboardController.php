<?php

namespace Kanboard\Plugin\CRProject\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\CRProject\Helper\Arr;

class DashboardController extends BaseController
{
    /**
     * Show.
     *
     * @throws \Kanboard\Core\Controller\AccessForbiddenException
     * @throws \Kanboard\Core\Controller\PageNotFoundException
     */
    public function show()
    {
        // Get all project status ids by key.
        $projectStatuses = $this->projectHasStatusModel->getAllWithStatus();
        $projectStatuses = Arr::toKey($projectStatuses, 'project_id');

        // Get projects.
        $user = $this->getUser();
        $userId = Arr::getInt($user, 'id');
        $query = $this->projectModel->getQueryColumnStats($this->projectPermissionModel->getActiveProjectIds($userId));
        $projects = $query->findAll();

        $statuses = $this->projectStatusModel->getAll();

        $this->response->html($this->helper->layout->dashboard('CRProject:project/show', array(
            'user' => $user,
            'projectStatuses' => $projectStatuses,
            'projects' => $projects,
            'statuses' => $statuses,
            'title' => t('Project ') . ' &gt; ' . t('Status')
        )));
    }

    /**
     * Visibility.
     */
    public function visibility()
    {
        $id = $this->request->getIntegerParam('id');
        $isHidden = $this->request->getIntegerParam('isHidden');
        $this->projectHasStatusModel->setVisibility($id, $isHidden);
        return $this->response->redirect($this->helper->url->to('DashboardController', 'show',
            array('plugin' => 'CRProject')));
    }

    /**
     * Status.
     */
    public function status()
    {
        $id = $this->request->getIntegerParam('id');
        $statusId = $this->request->getIntegerParam('statusId');
        $this->projectHasStatusModel->setStatus($id, $statusId);
        return $this->response->redirect($this->helper->url->to('DashboardController', 'show',
            array('plugin' => 'CRProject')));
    }
}