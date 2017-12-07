<?php

namespace Kanboard\Plugin\CRProject\Model;

use Kanboard\Core\Base;

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
