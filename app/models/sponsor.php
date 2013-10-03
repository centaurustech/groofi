<?php

/**
 * @property User $User
 */
class Sponsor extends AppModel {

    var $name="Sponsor";
    var $useTable="sponsors_image";
    var $primaryKey='id';
    var $conditions;
    var $order;
    var $limit;
    var $belongsTo=array(
    );


}

?>