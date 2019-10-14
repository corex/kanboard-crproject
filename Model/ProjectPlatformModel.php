<?php

namespace Kanboard\Plugin\CRProject\Model;

use Kanboard\Core\Base;
use Kanboard\Plugin\CRProject\Helper\Arr;

class ProjectPlatformModel extends Base
{
    const TABLE = 'crproject_platform';

    /**
     * Get by id.
     *
     * @param integer $id
     * @return array
     */
    public function getById($id)
    {
        return $this->db->table(self::TABLE)->eq('id', $id)->findOne();
    }

    /**
     * Get all.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->table(self::TABLE)->asc('title')->findAll();
    }

    /**
     * Get all options.
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options = array();
        $rows = $this->getAll();
        foreach ($rows as $row) {
            $options[$row['id']] = $row['title'];
        }
        return $options;
    }

    /**
     * Save.
     *
     * @param array $values
     * @return integer
     */
    public function save(array $values)
    {
        // Extract id.
        $id = Arr::getInt($values, 'id');
        Arr::remove($values, 'id');

        // Prepare color_id.
        if (Arr::get($values, 'color_id') == '') {
            $values['color_id'] = null;
        }

        if ($id > 0) {
            $this->db->table(self::TABLE)->eq('id', $id)->save($values);
        } else {
            $this->db->table(self::TABLE)->save($values);
        }
        if ($id == 0) {
            $id = $this->db->getLastId();
        }

        return $id;
    }

    /**
     * Remove.
     *
     * @param integer $id
     * @return boolean
     */
    public function remove($id)
    {
        return $this->db->table(self::TABLE)->eq('id', $id)->remove();
    }
}
