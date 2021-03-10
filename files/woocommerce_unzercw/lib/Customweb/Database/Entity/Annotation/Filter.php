<?php

require_once 'Customweb/Database/Entity/Annotation/IProcessable.php';
require_once 'Customweb/Database/Entity/Meta/Filter.php';
require_once 'Customweb/IAnnotation.php';


/**
 *
 * @author Thomas Hunziker
 * @Target({'Class'})
 *
 */
class Customweb_Database_Entity_Annotation_Filter implements Customweb_IAnnotation, Customweb_Database_Entity_Annotation_IProcessable {
	public $name;
	public $where;
	public $orderBy;

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector){

		$name = trim($this->name, ' "\'');
		if (empty($name)) {
			throw new Exception("The filter annotation requires a name.");
		}
		$filter = new Customweb_Database_Entity_Meta_Filter();

		$filter->setName($name);
		$filter->setOrderBy($this->orderBy);
		$filter->setWhere($this->where);
		$entity->addFilter($filter);
	}

	public function reset(){
		$this->name = null;
		$this->where = null;
		$this->orderBy = null;
	}
}