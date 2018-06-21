<?php

namespace Kanboard\Plugin\CRProject\Model;

use Kanboard\Core\Base;
use Kanboard\Model\ProjectModel;

class ProjectHasStatusModel extends Base
{
    const TABLE = 'crproject_has_status';

    /**
     * Get by project id.
     *
     * @param integer $projectId
     * @return array|null
     */
    public function getByProjectId($projectId)
    {
        return $this->db->table(self::TABLE)->eq('project_id', $projectId)->findOne();
    }

    /**
     * Get all hidden project ids.
     *
     * @return array
     */
    public function getAllHiddenProjectsIds()
    {
        $hiddenProjects = $this->db->table(self::TABLE)
            ->left(ProjectStatusModel::TABLE, 'ps', 'id', self::TABLE, 'status_id')
            ->beginOr()
            ->eq(ProjectHasStatusModel::TABLE . '.is_hidden', 1)
            ->eq('ps.is_visible', 0)
            ->closeOr()
            ->findAllByColumn(self::TABLE . '.project_id');
        return $hiddenProjects;
    }

    /**
     * Get project ids by status id.
     *
     * @param integer $statusId If 0, then all. If -1 then not set.
     * @return array
     */
    public function getProjectIdsByStatusId($statusId)
    {
        if ($statusId === null) {
            $statusId = 0;
        }

        $query = $this->db->table(ProjectModel::TABLE);
        if ($statusId > 0) {
            // Get all on status id.
            $query->join(ProjectHasStatusModel::TABLE, 'project_id', 'id');
            $query->eq(ProjectHasStatusModel::TABLE . '.status_id', $statusId);
        } elseif ($statusId == -1) {
            // Get all not set.
            $query->left(ProjectHasStatusModel::TABLE, 'phs', 'project_id', ProjectModel::TABLE, 'id')
                ->beginOr()
                ->eq('phs.status_id', 0)
                ->isNull('phs.status_id')
                ->closeOr();
        }

        $projects = $query->findAllByColumn(ProjectModel::TABLE . '.id');
        return $projects;
    }

    /**
     * Get project ids by status ids for lookup.
     *
     * @return array
     */
    public function getProjectIdsByStatusIds()
    {
        $query = $this->db->table(ProjectModel::TABLE);
        $query->join(ProjectHasStatusModel::TABLE, 'project_id', 'id');
        $projects = $query->findAll();

        // Compile result ids for lookup.
        $result = [];
        if (count($projects) > 0) {
            foreach ($projects as $project) {
                $status_id = $project['status_id'];
                $project_id = $project['project_id'];
                if ($status_id === null || $project_id === null) {
                    continue;
                }
                if (!isset($result[$status_id]) && !is_array($result[$status_id])) {
                    $result[$status_id] = [];
                }
                $result[$status_id][] = $project_id;
            }
        }

        return $result;
    }

    /**
     * Set status.
     *
     * @param integer $projectId
     * @param integer $statusId
     */
    public function setStatus($projectId, $statusId)
    {
        $this->setFieldValue($projectId, 'status_id', $statusId);
    }

    /**
     * Set visibility.
     *
     * @param integer $projectId
     * @param integer $isHidden
     */
    public function setVisibility($projectId, $isHidden)
    {
        $this->setFieldValue($projectId, 'is_hidden', $isHidden);
    }

    /**
     * In use.
     *
     * @param integer $statusId
     * @return boolean
     */
    public function inUse($statusId)
    {
        return $this->db->table(self::TABLE)->eq('status_id', $statusId)->count() > 0;
    }

    /**
     * Get all status ids in use.
     *
     * @return array
     */
    public function getAllStatusIdsInUse()
    {
        return $this->db->table(self::TABLE)->distinct()->findAllByColumn('status_id');
    }

    /**
     * Get all.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->table(self::TABLE)->findAll();
    }

    /**
     * Get all with status.
     *
     * @return array
     */
    public function getAllWithStatus()
    {
        return $this->db->table(self::TABLE)
            ->join(ProjectStatusModel::TABLE, 'id', 'status_id')
            ->findAll();
    }

    /**
     * Set field value.
     *
     * @param integer $projectId
     * @param string $field
     * @param mixed $value
     */
    private function setFieldValue($projectId, $field, $value)
    {
        $row = $this->getByProjectId($projectId);
        $values = array('project_id' => $projectId, $field => $value);
        $query = $this->db->table(self::TABLE);
        if ($row !== null) {
            $query->eq('id', $row['id']);
        }
        $query->save($values);
    }
}
