<?php

namespace Kanboard\Plugin\CRProject\Model;

use Kanboard\Core\Base;
use Kanboard\Plugin\CRProject\Helper\Arr;

class ConfigTaskColorModel extends Base
{
    const TABLE = 'crproject_task_color';

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
     * Get by color id.
     *
     * @param string $colorId
     * @return array
     */
    public function getByColorId($colorId)
    {
        return $this->db->table(self::TABLE)->eq('color_id', $colorId)->findOne();
    }

    /**
     * Get all.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->table(self::TABLE)->asc('position')->asc('title')->findAll();
    }

    /**
     * Get all as options.
     *
     * @return array
     */
    public function getOptions()
    {
        $options = array();
        $rows = $this->getAll();
        foreach ($rows as $row) {
            $options[$row['color_id']] = $row['title'];
        }
        return $options;
    }

    /**
     * Get all as options.
     *
     * @return array
     */
    public function getAllOptionsFiltered()
    {
        $optionColorIds = array_keys($this->getOptions());
        $systemOptions = $this->colorModel->getList();
        $colors = [];
        foreach ($systemOptions as $colorId => $title) {
            if (in_array($colorId, $optionColorIds)) {
                continue;
            }
            $colors[$colorId] = $title;
        }
        return $colors;
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

        // Make sure position is set.
        if (Arr::getInt($values, 'position') == 0) {
            $maxPosition = intval($this->db->table(self::TABLE)->desc('position')->findOneColumn('position'));
            $values['position'] = $maxPosition + 1;
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

    /**
     * Change position.
     *
     * @param integer $id
     * @param integer $position
     * @return boolean
     */
    public function changePosition($id, $position)
    {
        if ($position < 1 || $position > $this->db->table(self::TABLE)->count()) {
            return false;
        }
        $currentIds = $this->db->table(self::TABLE)->neq('id', $id)->asc('position')->findAllByColumn('id');
        $results = array();
        $offset = 1;
        foreach ($currentIds as $currentId) {
            if ($offset == $position) {
                $results[] = $this->db->table(self::TABLE)->eq('id', $id)->update(array('position' => $offset));
                $offset++;
            }
            $results[] = $this->db->table(self::TABLE)->eq('id', $currentId)->update(array('position' => $offset));
            $offset++;
        }
        return !in_array(false, $results, true);
    }
}