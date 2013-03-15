<?php

    /**
     * PublishableBehavior allows the use of datetime fields for start and end ranges on content.  Included
     * functionality allows for checking published status, toggling to published / unpublished status, and
     * adding conditions to a find to properly filter those results
     *
     * PHP versions 4 and 5
     *
     * Copyright 2009, Brightball, Inc. (http://www.brightball.com)
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright 2009, Brightball, Inc. (http://www.brightball.com)
     * @link          http://github.com/aramisbear/brightball-open-source/tree/master Brightball Open Source
     * @lastmodified  $Date: 2009-04-02 13:17:10 -0500 (Thu, 2 Apr 2009) $
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     */
    class EnableableBehavior extends ModelBehavior {

        var $__settings=array();
        var $_built=array();

        function setup(&$model, $settings = array()) {
            $default=array(
                'enabled' => 'enabled'
            );

            if (!isset($this->__settings[$model->alias]))
                $this->__settings[$model->alias]=$default;
            $this->__settings[$model->alias]=am($this->__settings[$model->alias], ife(is_array($settings), $settings, array()));

            $this->_checkColumn($model, $this->__settings[$model->alias]['enabled']);
        }

        function beforeFind(&$model, $query) {
            if (!array_key_exists('enabled', $query))
                return true;
            if ($query['enabled']) { //Return published
                $conditions=$this->publishConditions($model, 1);
                $query['conditions']=Set::merge($query['conditions'], $conditions);
            } else { //Return unpublished
                $conditions=$this->publishConditions($model, 0);
                $query['conditions']=Set::merge($query['conditions'], $conditions);
            }
            return $query;
        }

        function publishConditions(&$model, $published = true) {
            if ($published) {
                $conditions=array(
                    $model->alias . '.' . $this->__settings[$model->alias]['enabled'] => 1
                );
                return $conditions;
            } else {
                $conditions=array(
                    $model->alias . '.' . $this->__settings[$model->alias]['enabled'] => 0
                );
                return $conditions;
            }
        }

        function _checkColumn(&$model, $column) {
            $col=$model->schema($column);
            if (empty($col)) {
                trigger_error('Enableable Model "' . $model->alias . '" is missing column: ' . $column);
            }
        }

        function isEnabled(&$model, $id = '') {

            if (empty($id))
                $id=$model->id;
            if (empty($id))
                return false;

            $page=$model->find('first', array(
                    'fields' => array($this->__settings[$model->alias]['enabled']),
                    'recursive' => -1,
                    'conditions' => array($model->primaryKey => $id)));

            if (
                empty($page[$model->alias][$this->__settings[$model->alias]['enable']])
                || $page[$model->alias][$this->__settings[$model->alias]['start_column']] == 0
            ) {
                return false;
            }
            else
                return true;
        }

        function enable(&$model, $id = array()) {
            return $this->_enabling($model, $id);
        }

        function disable(&$model, $id = array()) {
            return $this->_enabling($model, $id, false);
        }

        function _enabling(&$model, $id = array(), $publish = true) {
            if (empty($id)) {
                if (!empty($model->id))
                    $id=$model->id;
                else
                    return false;
            }

            if (is_scalar($id))
                $id=array($id);

            $fields=array();
            if ($publish) {
                $fields=array($model->alias . '.' . $this->__settings[$model->alias]['enabled'] => 1);
            } else {
                $fields=array($model->alias . '.' . $this->__settings[$model->alias]['enabled'] => 0);
            }

            $model->updateAll($fields, array($model->alias . '.' . $model->primaryKey => $id));

            return true;
        }

    }