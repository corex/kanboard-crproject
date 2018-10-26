<?php

namespace Kanboard\Plugin\CRProject\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\ProjectModel;
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
        $columnCounterMax = $this->configModel->get('crproject_column_count');
        if (intval($columnCounterMax) < 1) {
            $columnCounterMax = 1;
        }

        $statusShowId = $this->request->getStringParam('status_show_id', 0);

        // Get all project status ids by key.
        $projectStatuses = $this->projectHasStatusModel->getAllWithStatus();
        $projectStatuses = Arr::toKey($projectStatuses, 'project_id');

        // Get projects.
        $user = $this->getUser();
        $userId = Arr::getInt($user, 'id');
        $query = $this->projectModel->getQueryColumnStats($this->projectPermissionModel->getActiveProjectIds($userId));
        $query->asc(ProjectModel::TABLE . '.name');
        $projects = $query->findAll();

        $statuses = $this->projectStatusModel->getAll();

        $projectIds = $this->projectHasStatusModel->getProjectIdsByStatusId($statusShowId);
        $projectIdsByStatusIds = $this->projectHasStatusModel->getProjectIdsByStatusIds(false);

        $this->response->html($this->helper->layout->dashboard('CRProject:dashboard/show', array(
            'user' => $user,
            'projectStatuses' => $projectStatuses,
            'projects' => $projects,
            'statuses' => $statuses,
            'projectIds' => $projectIds,
            'projectIdsByStatusIds' => $projectIdsByStatusIds,
            'statusShowId' => $statusShowId,
            'title' => t('Project') . ' &gt; ' . t('Status'),
            'columnCounterMax' => $columnCounterMax
        )));
    }

    /**
     * Visibility.
     */
    public function visibility()
    {
        $id = $this->request->getIntegerParam('id');
        $statusShowId = $this->request->getStringParam('status_show_id', 0);
        $isHidden = $this->request->getIntegerParam('isHidden');
        $this->projectHasStatusModel->setVisibility($id, $isHidden);
        return $this->response->redirect($this->helper->url->to('DashboardController', 'show',
            array('plugin' => 'CRProject', 'status_show_id' => $statusShowId)));
    }

    /**
     * Status.
     */
    public function status()
    {
        $id = $this->request->getIntegerParam('id');
        $statusShowId = $this->request->getStringParam('status_show_id', 0);
        $statusId = $this->request->getIntegerParam('statusId');
        $this->projectHasStatusModel->setStatus($id, $statusId);
        return $this->response->redirect($this->helper->url->to('DashboardController', 'show',
            array('plugin' => 'CRProject', 'status_show_id' => $statusShowId)));
    }
}