<?php

/* SVN FILE: $Id: sluggable.php 36 2007-11-26 15:10:14Z mgiglesias $ */

/**
 * Sluggable Behavior class file.
 *
 * @filesource
 * @author Mariano Iglesias
 * @link http://cake-syrup.sourceforge.net/ingredients/sluggable-behavior/
 * @version	$Revision: 36 $
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.models.behaviors
 */

/**
 * Model behavior to support generation of slugs for models.
 *
 * @package app
 * @subpackage app.models.behaviors
 */
class SluggableBehavior extends ModelBehavior {

    /**
     * Contain settings indexed by model name.
     *
     * @var array
     * @access private
     */
    var $__settings = array();

    /**
     * Initiate behavior for the model using specified settings. Available settings:
     *
     * - label: 	(array | string, optional) set to the field name that contains the
     * 				string from where to generate the slug, or a set of field names to
     * 				concatenate for generating the slug. DEFAULTS TO: title
     *
     * - slug:		(string, optional) name of the field name that holds generated slugs.
     * 				DEFAULTS TO: slug
     *
     * - separator:	(string, optional) separator character / string to use for replacing
     * 				non alphabetic characters in generated slug. DEFAULTS TO: -
     *
     * - length:	(integer, optional) maximum length the generated slug can have.
     * 				DEFAULTS TO: 100
     *
     * - overwrite: (boolean, optional) set to true if slugs should be re-generated when
     * 				updating an existing record. DEFAULTS TO: false
     *
     * @param object $Model Model using the behaviour
     * @param array $settings Settings to override for model.
     * @access public
     */
    function setup(&$Model, $settings = array()) {
        $default = array('label' => array('title'), 'slug' => 'slug', 'replace' => '', 'separator' => '-', 'length' => 100, 'overwrite' => false, 'translation' => null);

        if (!isset($this->__settings[$Model->alias])) {
            $this->__settings[$Model->alias] = $default;
        }

        $this->__settings[$Model->alias] = am($this->__settings[$Model->alias], ife(is_array($settings), $settings, array()));
    }

    /**
     * Run before a model is saved, used to set up slug for model.
     *
     * @param object $Model Model about to be saved.
     * @return boolean true if save should proceed, false otherwise
     * @access public
     */
    function beforeSave(&$Model) {
        $return = parent::beforeSave($Model);


        // Make label fields an array
        if (!is_array($this->__settings[$Model->alias]['label'])) {
            $this->__settings[$Model->alias]['label'] = array($this->__settings[$Model->alias]['label']);
        }

       
        // Make sure all label fields are available
        foreach ($this->__settings[$Model->alias]['label'] as $field) {
            if (!$Model->hasField($field)) {
                return $return;
            }
        }
         


        // See if we should be generating a slug
        if ($Model->hasField($this->__settings[$Model->alias]['slug']) && ($this->__settings[$Model->alias]['overwrite'] || empty($Model->id))) {
            // Build label out of data in label fields, if available, or using a default slug otherwise


            $label = '';

            foreach ($this->__settings[$Model->alias]['label'] as $field) {
                if (!empty($Model->data[$Model->alias][$field])) {
                    $label .= ife(!empty($label), ' ', '') . $Model->data[$Model->alias][$field];
                }
            }


            // Keep on going only if we've got something to slug
            if (!empty($label)) {
                // Get the slug

                $slug = $this->__slug($label, $this->__settings[$Model->alias]);


                // Look for slugs that start with the same slug we've just generated
                $conditions = array($Model->alias . '.' . $this->__settings[$Model->alias]['slug'] . ' LIKE' => $slug . '%');

                if (!empty($Model->id)) {
                    $conditions[$Model->alias . '.' . $Model->primaryKey] = '!= ' . $Model->id;
                }

                $result = $Model->find('all', array('conditions' => $conditions, 'fields' => array($Model->primaryKey, $this->__settings[$Model->alias]['slug']), 'recursive' => -1));

                $sameUrls = null;

                if (!empty($result)) {
                    $sameUrls = Set::extract($result, '{n}.' . $Model->alias . '.' . $this->__settings[$Model->alias]['slug']);
                }

                // If we have collissions

                if (!empty($sameUrls)) {
                    $begginingSlug = $slug;
                    $index = 1;

                    // Attach an ending incremental number until we find a free slug
                    while ($index > 0) {
                        if (!in_array($begginingSlug . $this->__settings[$Model->alias]['separator'] . $index, $sameUrls)) {
                            $slug = $begginingSlug . $this->__settings[$Model->alias]['separator'] . $index;
                            $index = -1;
                        }
                        $index++;
                    }
                }

                // Now set the slug as part of the model data to be saved, making sure that
                // we are on the white list of fields to be saved
                if (!empty($Model->whitelist) && !in_array($this->__settings[$Model->alias]['slug'], $Model->whitelist)) {
                    $Model->whitelist[] = $this->__settings[$Model->alias]['slug'];
                }

                $Model->data[$Model->alias][$this->__settings[$Model->alias]['slug']] = $slug;
            }
        }
        return $return;
    }

    /**
     * Generate a slug for the given string using specified settings.
     *
     * @param string $string String from where to generate slug
     * @param array $settings Settings to use (looks for 'separator', 'length' and replace)
     * @return string Slug for given string
     * @access private
     */
    function __slug($string, $settings) {
        setlocale(LC_ALL, 'en_US.UTF8');
        if (!empty($settings['replace'])) {
            $string = str_replace((array) $settings['replace'], ' ', $string);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $settings['separator'], $clean);
        if (strlen($clean) > $settings['length']) {
            $clean = substr($clean, 0, $settings['length']);
        }
        return $clean;
    }

}

?>